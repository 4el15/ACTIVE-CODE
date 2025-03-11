<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: index.html");
    exit();
}

$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم</title>
</head>
<body>
    <h2>مرحبًا، <?php echo $user['full_name']; ?></h2>
    <p>رقم كارت المشاهدة: <?php echo $user['card_number']; ?></p>
    <p>الباقة: <?php echo $user['package']; ?></p>
    <p>الموزع: <?php echo $user['distributor']; ?></p>
    <p>تاريخ الإصدار: <?php echo $user['issue_date']; ?></p>
    <p>تاريخ الانتهاء: <?php echo $user['end_date']; ?></p>
    <p>المبلغ المدفوع: <?php echo $user['amount_paid']; ?> EGP</p>
    <p>إجمالي الدفع: <?php echo $user['total_payment']; ?> EGP</p>
    <br>
    <a href="logout.php">تسجيل الخروج</a>
    <a href="https://wa.me/201024348882">💬 دعم فني</a>
</body>
</html>
