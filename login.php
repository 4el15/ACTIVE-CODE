<?php
session_start();
include("db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password' AND status='active'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['user'] = $user;
        header("Location: dashboard.php");
        exit();
    } else {
        echo "اسم المستخدم أو كلمة المرور غير صحيحة، أو الحساب مغلق.";
    }
}
?>
