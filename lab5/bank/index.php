<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>النظام المصرفي | الصفحة الرئيسية</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

    <section class="hero">
        <h1>نظام التحويلات المصرفية</h1>
        <p>
            منصة آمنة لإجراء التحويلات المالية بين الحسابات  
            مع تتبع كامل لجميع العمليات
        </p>
        <a href="transfer.php" class="btn-primary">ابدأ التحويل الآن</a>
    </section>


    <section class="card">
        <h2>طريقة استخدام النظام</h2>

        <div class="steps">
            <div class="step">
                <span>1</span>
                <h4>اختيار الحسابات</h4>
                <p>تحديد الحساب المرسل والمستلم</p>
            </div>

            <div class="step">
                <span>2</span>
                <h4>إدخال المبلغ</h4>
                <p>كتابة قيمة المبلغ المراد تحويله</p>
            </div>

            <div class="step">
                <span>3</span>
                <h4>تأكيد العملية</h4>
                <p>مراجعة البيانات قبل الإرسال</p>
            </div>

            <div class="step">
                <span>4</span>
                <h4>إتمام التحويل</h4>
                <p>تنفيذ العملية بنجاح فورًا</p>
            </div>
        </div>
    </section>

    <footer class="footer">
        <p>© <?php echo date('Y'); ?> النظام المصرفي - صقر الحراني</p>
    </footer>

</div>

</body>
</html>
