<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: index.php");
    exit();
}

$data = json_decode(file_get_contents('users.json'), true);
$user = $_SESSION["username"];

if ($user == "ELMIX") {
    header("Location: admin.php");
    exit();
}

$userData = $data["users"][$user];
?>

<h2>رقم كارت المشاهدة: <?php echo $userData["card_number"]; ?></h2>
<h1 style="color: gold;">MH PRO</h1>
<p>CLIENT NAME: <?php echo $userData["client_name"]; ?></p>
<p>PROGRAM NAME: <?php echo $userData["program_name"]; ?> 🟠</p>
<p>Payment End Date: <?php echo $userData["payment_end"]; ?></p>
<p>تاريخ الإصدار: <?php echo $userData["issue_date"]; ?></p>
<p>تاريخ الإستحقاق: <?php echo $userData["due_date"]; ?></p>
<p>المبلغ المحدد: <?php echo $userData["amount_due"]; ?></p>
<p>تكلفة الخدمة: <?php echo $userData["service_cost"]; ?></p>
<p>الإجمالي: <?php echo $userData["total"]; ?></p>
<p>USER NAME: <?php echo $user; ?></p>
<p>رمز ال<?php echo $user; ?> نشط 🟢</p>
<p>EXPIRED: <?php echo $userData["expired"]; ?></p>

<a href="logout.php">تسجيل الخروج</a>
