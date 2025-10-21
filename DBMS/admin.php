<?php
include 'connect.php';

$name = "Admin User";
$username = "admin";
$email = trim($_POST['email']); // instead of 'username'
$role = "admin";
$password = password_hash("admin123", PASSWORD_DEFAULT); // secure hash

$stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $name, $email, $password, $role);
$stmt->execute();
$stmt->close();

echo "Admin user created.";
echo "✅ Admin user created. <a href='login.html'>Go to Login</a>";

?>
