<?php
$servername = "localhost";
$username = "root"; // لو شغال على XAMPP، خليها root
$password = ""; // لو شغال على XAMPP، خليها فاضية
$dbname = "users_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}
?>
