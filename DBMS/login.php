<?php
session_start();
include 'connect.php'; // Database connection

// Sanitize inputs
$username = trim($_POST['username']);
$password = $_POST['password'];

if (empty($username) || empty($password)) {
    echo "⚠️ Please enter both username and password.";
    exit();
}

// Prepare and execute query
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo "SQL error: " . $conn->error;
    exit();
}

$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    // Password check
    if (password_verify($password, $user['password']) || $password == $user['password']) {
        // Save session variables
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['name'] = $user['name'] ?? $user['username']; // fallback to username if name is missing
        $_SESSION['role'] = $user['role'];

        // Redirect based on role
        switch ($user['role']) {
            case 'admin':
                header("Location: admin_dashboard.php");
                break;
            case 'receptionist':
                header("Location: receptionist_dashboard.php");
                break;
            case 'security':
                header("Location: security_dashboard.php");
                break;
            default:
                echo "❌ Unknown role.";
                exit();
        }
        exit();
    } else {
        echo "❌ Invalid password.";
    }
} else {
    echo "❌ User not found.";
}
?>
