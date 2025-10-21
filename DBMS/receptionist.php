<?php
include 'connect.php';

$username = "reception1";
$role = "receptionist";
$password = password_hash("reception123", PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $username, $password, $role);
$stmt->execute();
$stmt->close();

echo "Receptionist user created.";
?>
