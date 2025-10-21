<?php
include 'connect.php';

$username = "security1"; // You can change this
$password_plain = "security123"; // Plain password
$password_hashed = password_hash($password_plain, PASSWORD_DEFAULT); // Securely hashed
$role = "security";

// Check if user already exists
$check = $conn->prepare("SELECT * FROM users WHERE username = ?");
$check->bind_param("s", $username);
$check->execute();
$check_result = $check->get_result();

if ($check_result->num_rows > 0) {
    echo "⚠️ User '$username' already exists.";
} else {
    $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $password_hashed, $role);

    if ($stmt->execute()) {
        echo "✅ Security user '$username' created successfully.";
    } else {
        echo "❌ Error: " . $stmt->error;
    }
    $stmt->close();
}

$check->close();
$conn->close();
?>
