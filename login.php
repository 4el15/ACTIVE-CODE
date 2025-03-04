<?php
session_start();
$conn = new mysqli("localhost", "root", "", "iptv_system");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ? AND password = ?");
    $stmt->bind_param("is", $user_id, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['role'] = $row['role'];
        
        if ($row['role'] == 'admin') {
            header("Location: admin.php");
        } else {
            header("Location: client.php");
        }
    } else {
        echo "خطأ في ID أو الباسورد!";
    }
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <form method="POST">
        <h2>ACCOUNT CONTROL</h2>
        <input type="text" name="user_id" placeholder="USER ID" required>
        <input type="password" name="password" placeholder="PASSWORD" required>
        <button type="submit">LOGIN</button>
    </form>
</body>
</html>
