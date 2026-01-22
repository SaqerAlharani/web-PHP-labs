<?php
/*
====================================================
SwiftPay - Secure Payment Module
Refactored by: صقر الحراني
====================================================
*/
require 'db_config.php';

$msg_error = '';
$msg_success = '';

// CSRF Protection
if (empty($_SESSION['payment_token'])) {
    $_SESSION['payment_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!hash_equals($_SESSION['payment_token'], $_POST['token'] ?? '')) {
        $msg_error = "خطأ في الجلسة، حاول مرة أخرى";
    } else {

        $sender_acc    = (int)$_POST['sender'];
        $recipient_acc = (int)$_POST['recipient'];
        $payment_val   = (float)$_POST['val'];

        if (!$sender_acc || !$recipient_acc || !$payment_val) {
            $msg_error = "يرجى ملء جميع الحقول المطلوبة";
        } elseif ($sender_acc === $recipient_acc) {
            $msg_error = "لا يمكنك التحويل لنفس الحساب";
        } elseif ($payment_val <= 0) {
            $msg_error = "يجب أن يكون المبلغ أكبر من صفر";
        } else {
            try {
                $conn->beginTransaction();

                // Lock sender record
                $stmt = $conn->prepare("SELECT balance FROM accounts WHERE id = ? FOR UPDATE");
                $stmt->execute([$sender_acc]);
                $sender = $stmt->fetch();

                if (!$sender) {
                    throw new Exception("حساب المصدر غير موجود");
                }

                if ($sender['balance'] < $payment_val) {
                    throw new Exception("الرصيد غير كافٍ لإتمام العملية");
                }

                // Update Balances
                $stmt = $conn->prepare("UPDATE accounts SET balance = balance - ? WHERE id = ?");
                $stmt->execute([$payment_val, $sender_acc]);

                $stmt = $conn->prepare("UPDATE accounts SET balance = balance + ? WHERE id = ?");
                $stmt->execute([$payment_val, $recipient_acc]);

                // Log Transaction
                $stmt = $conn->prepare("INSERT INTO transactions (sender_id, recipient_id, amount) VALUES (?, ?, ?)");
                $stmt->execute([$sender_acc, $recipient_acc, $payment_val]);

                $conn->commit();
                $msg_success = "تمت عملية الدفع بنجاح";

            } catch (Exception $ex) {
                $conn->rollBack();
                $msg_error = "فشلت العملية: " . $ex->getMessage();
            }
        }
    }
}

$all_accounts = $conn->query("SELECT * FROM accounts")->fetchAll();

$history = $conn->query("
    SELECT t.*, 
           a1.full_name AS sender_name, 
           a2.full_name AS recipient_name
    FROM transactions t
    LEFT JOIN accounts a1 ON t.sender_id = a1.id
    LEFT JOIN accounts a2 ON t.recipient_id = a2.id
    ORDER BY t.executed_at DESC
    LIMIT 10
")->fetchAll();
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>SwiftPay | إرسال دفعة</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="theme.css">
</head>
<body>

<div class="container">

    <div class="hero" style="padding: 30px 20px;">
        <h1>بوابة SwiftPay المالية</h1>
        <a href="index.php" style="color: white; text-decoration: none; font-size: 0.9rem;">← العودة للرئيسية</a>
    </div>

    <?php if ($msg_error): ?>
        <div class="alert alert-error"><?= htmlspecialchars($msg_error) ?></div>
    <?php endif; ?>

    <?php if ($msg_success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($msg_success) ?></div>
    <?php endif; ?>

    <div class="card">
        <h2>إجراء دفعة جديدة</h2>

        <form method="POST">
            <input type="hidden" name="token" value="<?= $_SESSION['payment_token']; ?>">

            <div class="form-group">
                <label>الحساب المرسل (المصدر)</label>
                <select name="sender" required>
                    <option value="">اختر الحساب</option>
                    <?php foreach ($all_accounts as $acc): ?>
                        <option value="<?= $acc['id']; ?>">
                            <?= $acc['full_name']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>حساب المستلم</label>
                <select name="recipient" required>
                    <option value="">اختر الحساب</option>
                    <?php foreach ($all_accounts as $acc): ?>
                        <option value="<?= $acc['id']; ?>">
                            <?= $acc['full_name']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>المبلغ المراد تحويله</label>
                <input type="number" name="val" min="0.01" step="0.01" placeholder="0.00" required>
            </div>

            <button class="btn">تأكيد وإرسال الدفعة</button>
        </form>
    </div>

    <div class="card">
        <h2>أرصدة الحسابات</h2>
        <div class="accounts-grid">
            <?php foreach ($all_accounts as $acc): ?>
                <div class="account-card">
                    <div class="account-name"><?= $acc['full_name']; ?></div>
                    <div class="account-balance"><?= number_format($acc['balance'], 2); ?>$</div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="card">
        <h2>سجل التحويلات الأخيرة</h2>

        <?php if (!$history): ?>
            <div style="text-align: center; color: #94a3b8;">لا توجد عمليات مسجلة حتى الآن</div>
        <?php else: ?>
            <div class="transactions-list">
                <?php foreach ($history as $t): ?>
                    <div class="transaction-item">
                        <div>
                            <div class="transaction-accounts">
                                من: <?= $t['sender_name']; ?> <br> إلى: <?= $t['recipient_name']; ?> 
                            </div>
                            <div class="transaction-date">
                                <?= date('d/m/Y H:i', strtotime($t['executed_at'])); ?>
                            </div>
                        </div>
                        <div class="transaction-amount">
                            <?= number_format($t['amount'], 2); ?>$
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <footer class="footer">
        © <?= date('Y'); ?> نظام SwiftPay المطور - صقر الحراني
    </footer>

</div>

</body>
</html>
