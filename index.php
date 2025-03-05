<?php
session_start();
$data = json_decode(file_get_contents('users.json'), true);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    if (isset($data["users"][$username]) && $data["users"][$username]["password"] == $password) {
        $_SESSION["username"] = $username;
        header("Location: dashboard.php");
        exit();
    } else {
        echo "<script>alert('خطأ في اسم المستخدم أو كلمة المرور');</script>";
    }
}
?>

<form method="post">
    <input type="text" name="username" placeholder="اسم المستخدم" required>
    <input type="password" name="password" placeholder="كلمة المرور" required>
    <button type="submit">تسجيل الدخول</button>
</form>
