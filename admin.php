<?php
session_start();
if ($_SESSION["username"] != "ELMIX") {
    header("Location: index.php");
    exit();
}

$data = json_decode(file_get_contents('users.json'), true);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $data["users"][$username] = [
        "password" => $_POST["password"],
        "card_number" => $_POST["card_number"],
        "client_name" => $_POST["client_name"],
        "program_name" => $_POST["program_name"],
        "payment_end" => $_POST["payment_end"],
        "issue_date" => $_POST["issue_date"],
        "due_date" => $_POST["due_date"],
        "amount_due" => $_POST["amount_due"],
        "service_cost" => $_POST["service_cost"],
        "total" => $_POST["total"],
        "expired" => $_POST["expired"],
        "status" => $_POST["status"]
    ];
    file_put_contents('users.json', json_encode($data, JSON_PRETTY_PRINT));
    echo "<script>alert('تم تحديث البيانات بنجاح!');</script>";
}

if (isset($_GET["delete"])) {
    unset($data["users"][$_GET["delete"]]);
    file_put_contents('users.json', json_encode($data, JSON_PRETTY_PRINT));
    echo "<script>alert('تم حذف المستخدم!'); window.location.href='admin.php';</script>";
}
?>

<h2>لوحة تحكم الإدمن</h2>

<h3>إضافة / تعديل مستخدم</h3>
<form method="post">
    <input type="text" name="username" placeholder="اسم المستخدم" required>
    <input type="password" name="password" placeholder="كلمة المرور" required>
    <input type="text" name="card_number" placeholder="رقم كارت المشاهدة">
    <input type="text" name="client_name" placeholder="اسم العميل">
    <input type="text" name="program_name" placeholder="الباقة">
    <input type="text" name="payment_end" placeholder="مدة الاشتراك">
    <input type="text" name="issue_date" placeholder="تاريخ الإصدار">
    <input type="text" name="due_date" placeholder="تاريخ الإستحقاق">
    <input type="text" name="amount_due" placeholder="المبلغ المحدد">
    <input type="text" name="service_cost" placeholder="تكلفة الخدمة">
    <input type="text" name="total" placeholder="الإجمالي">
    <input type="text" name="expired" placeholder="تاريخ انتهاء الاشتراك">
    <select name="status">
        <option value="active">نشط</option>
        <option value="inactive">غير نشط</option>
    </select>
    <button type="submit">حفظ</button>
</form>

<h3>المستخدمون</h3>
<ul>
<?php foreach ($data["users"] as $user => $info) {
    if ($user != "ELMIX") {
        echo "<li>$user - <a href='admin.php?delete=$user'>حذف</a></li>";
    }
} ?>
</ul>

<a href="logout.php">تسجيل الخروج</a>
