<?php
session_start();
include("db.php");

if (!isset($_SESSION['user']) || $_SESSION['user']['username'] != 'ELMIX') {
    header("Location: index.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_user'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $full_name = $_POST['full_name'];

    $sql = "INSERT INTO users (username, password, full_name, status) 
            VALUES ('$username', '$password', '$full_name', 'active')";

    if ($conn->query($sql) === TRUE) {
        echo "تمت إضافة المستخدم بنجاح!";
    } else {
        echo "خطأ: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>إدارة المستخدمين</title>
</head>
<body>
    <h2>إضافة مستخدم جديد</h2>
    <form method="post">
        اسم المستخدم: <input type="text" name="username" required><br>
        كلمة المرور: <input type="password" name="password" required><br>
        الاسم الكامل: <input type="text" name="full_name"><br>
        <button type="submit" name="add_user">إضافة</button>
    </form>
</body>
</html>
