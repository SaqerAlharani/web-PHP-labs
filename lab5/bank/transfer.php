<?php
/*
====================================================
Banking System - Transfer Module
Student Name: صقر الحراني
====================================================
*/
require 'config.php';


$error = '';
$success = '';

/* ===== حماية CSRF ===== */
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'] ?? '')) {
        $error = "طلب غير صالح، يرجى إعادة المحاولة";
    } else {

        $from_acc = (int)$_POST['from_acc'];
        $to_acc   = (int)$_POST['to_acc'];
        $amount   = (float)$_POST['amount'];

        if (!$from_acc || !$to_acc || !$amount) {
            $error = "جميع الحقول مطلوبة";
        } elseif ($from_acc === $to_acc) {
            $error = "لا يمكن التحويل إلى نفس الحساب";
        } elseif ($amount <= 0) {
            $error = "المبلغ يجب أن يكون أكبر من صفر";
        } else {
            try {
                $conn->beginTransaction();

                /* قفل الحساب المرسل */
                $stmt = $conn->prepare(
                    "SELECT balance FROM accounts WHERE id = ? FOR UPDATE"
                );
                $stmt->execute([$from_acc]);
                $sender = $stmt->fetch();

                if (!$sender) {
                    throw new Exception("الحساب المرسل غير موجود");
                }

                if ($sender['balance'] < $amount) {
                    throw new Exception("الرصيد غير كافٍ");
                }

                $stmt = $conn->prepare(
                    "UPDATE accounts SET balance = balance - ? WHERE id = ?"
                );
                $stmt->execute([$amount, $from_acc]);

                $stmt = $conn->prepare(
                    "UPDATE accounts SET balance = balance + ? WHERE id = ?"
                );
                $stmt->execute([$amount, $to_acc]);

                $stmt = $conn->prepare(
                    "INSERT INTO transactions (from_acc, to_acc, amount) VALUES (?, ?, ?)"
                );
                $stmt->execute([$from_acc, $to_acc, $amount]);

                $conn->commit();
                $success = "تم تنفيذ التحويل بنجاح";

            } catch (Exception $e) {
                $conn->rollBack();
                $error = "فشل التحويل: " . $e->getMessage();
            }
        }
    }
}

$accounts = $conn->query("SELECT * FROM accounts")->fetchAll();

$transactions = $conn->query("
    SELECT t.*, 
           a1.name AS from_name, 
           a2.name AS to_name
    FROM transactions t
    LEFT JOIN accounts a1 ON t.from_acc = a1.id
    LEFT JOIN accounts a2 ON t.to_acc = a2.id
    ORDER BY t.created_at DESC
    LIMIT 10
")->fetchAll();
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تحويل الأموال</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

    <div class="header-nav">
        <h1>نظام التحويلات المصرفية</h1>
        <a href="index.php" class="back-link">العودة للرئيسية</a>
    </div>

    <?php if ($error): ?>
        <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <div class="card">
        <h2>إجراء تحويل جديد</h2>

        <form method="POST">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">

            <div class="form-group">
                <label>الحساب المرسل</label>
                <select name="from_acc" required>
                    <option value="">اختر الحساب</option>
                    <?php foreach ($accounts as $acc): ?>
                        <option value="<?= $acc['id']; ?>">
                            <?= $acc['name']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>الحساب المستلم</label>
                <select name="to_acc" required>
                    <option value="">اختر الحساب</option>
                    <?php foreach ($accounts as $acc): ?>
                        <option value="<?= $acc['id']; ?>">
                            <?= $acc['name']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>المبلغ</label>
                <input type="number" name="amount" min="0.01" step="0.01" placeholder="أدخل المبلغ" required>
            </div>

            <button class="btn">تنفيذ التحويل</button>
        </form>
    </div>

    <div class="card">
        <h2>الحسابات</h2>
        <div class="accounts-grid">
            <?php foreach ($accounts as $acc): ?>
                <div class="account-card">
                    <div class="account-name"><?= $acc['name']; ?></div>
                    <div class="account-balance"><?= number_format($acc['balance'], 2); ?>$</div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="card">
        <h2>آخر العمليات</h2>

        <?php if (!$transactions): ?>
            <div class="empty-state">لا توجد عمليات بعد</div>
        <?php else: ?>
            <div class="transactions-list">
                <?php foreach ($transactions as $t): ?>
                    <div class="transaction-item">
                        <div>
                            <div class="transaction-accounts">
                                <?= $t['to_name']; ?> ← <?= $t['from_name']; ?> 
                            </div>
                            <div class="transaction-date">
                                <?= date('Y-m-d H:i', strtotime($t['created_at'])); ?>
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
        © <?= date('Y'); ?> النظام المصرفي
    </footer>

</div>

</body>
</html>

