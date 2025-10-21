<?php
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];

    date_default_timezone_set('Asia/Kolkata');
    $checkout_time = date('Y/m/d H:i:s');

    // Get visitor details before updating
    $stmt = $conn->prepare("SELECT * FROM visitors WHERE UserId = ?");
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $visitorDetails = $result->fetch_assoc();
    $stmt->close();

    // Update departure time
    $stmt = $conn->prepare("UPDATE visitors SET Departure = ? WHERE UserId = ?");
    $stmt->bind_param("ss", $checkout_time, $user_id);
    $stmt->execute();
    $stmt->close();

    // Add departure time to visitor details
    $visitorDetails['Departure'] = $checkout_time;
}

header("Location: security_dashboard.php");
exit();
?>
