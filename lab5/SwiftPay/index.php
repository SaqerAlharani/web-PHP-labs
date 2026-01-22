<?php
require 'db_config.php';
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SwiftPay | بوابة الدفع الذكية</title>
    <link rel="stylesheet" href="theme.css">
</head>
<body>

<div class="container">

    <section class="hero">
        <h1>مرحباً بك في SwiftPay</h1>
        <p>
            بوابتك الرقمية لإدارة المدفوعات والتحويلات المالية  
            بسرعة، أمان، وسهولة تامة.
        </p>
        <a href="payment.php" class="btn-primary">إرسال دفعة جديدة</a>
    </section>


    <section class="card">
        <h2>كيف يعمل SwiftPay؟</h2>

        <div class="steps">
            <div class="step">
                <span>1</span>
                <h4>تحديد الحساب</h4>
                <p>اختر حساب المصدر وحساب المستلم</p>
            </div>

            <div class="step">
                <span>2</span>
                <h4>المبلغ المالي</h4>
                <p>حدد قيمة المبلغ المراد إرساله</p>
            </div>

            <div class="step">
                <span>3</span>
                <h4>المعالجة الفورية</h4>
                <p>يتم تنفيذ العملية في أجزاء من الثانية</p>
            </div>

            <div class="step">
                <span>4</span>
                <h4>سجل العمليات</h4>
                <p>تتبع مدفوعاتك من خلال لوحة التحكم</p>
            </div>
        </div>
    </section>

    <footer class="footer">
        <p>© <?php echo date('Y'); ?> نظام SwiftPay - صقر الحراني</p>
    </footer>

</div>

</body>
</html>
