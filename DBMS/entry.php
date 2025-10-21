<?php
include("connect.php");
include("function.php");
include("email_functions.php");

// Define variables and sanitize input
$Name = $Email = $Phone = $HostName = $HostEmail = $HostPhone = $Address = $PurposeOfVisit = "";
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Name = test_input($_POST["Name"]);
    $Email = test_input($_POST["Email"]);
    $Phone = test_input($_POST["Phone"]);
    $HostName = test_input($_POST["HostName"]);
    $HostEmail = test_input($_POST["HostEmail"]);
    $HostPhone = test_input($_POST["HostPhone"]);
    $Address = test_input($_POST["Address"]);
    $PurposeOfVisit = test_input($_POST["PurposeOfVisit"]);

    // Validation
    if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid visitor email format.";
    }
    if (!filter_var($HostEmail, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid host email format.";
    }
    if (!preg_match("/^[0-9]{10}$/", $Phone)) {
        $errors[] = "Invalid visitor phone number. Must be 10 digits.";
    }
    if (!preg_match("/^[0-9]{10}$/", $HostPhone)) {
        $errors[] = "Invalid host phone number. Must be 10 digits.";
    }

    if (empty($errors)) {
        date_default_timezone_set('Asia/Kolkata');
        $Arrive = date('Y/m/d H:i:s');
        $Depart = "Inside";

        // Generate approval token
        $approval_token = bin2hex(random_bytes(32));

        // Get unique UserId
        $stmtCount = $conn->prepare("SELECT COUNT(*) AS total FROM visitors");
        $stmtCount->execute();
        $result = $stmtCount->get_result();
        $row = $result->fetch_assoc();
        $number = 2100 + (int)$row['total'];
        $UserId = "IIITN" . $number;
        $stmtCount->close();

        // Prepare the SQL statement
        $stmt = $conn->prepare("INSERT INTO visitors (UserId, Username, Email, Phone, HostName, HostEmail, HostPhone, PurposeOfVisit, Arrival, Departure) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'Inside')");
        $stmt->bind_param("sssssssss", $UserId, $Name, $Email, $Phone, $HostName, $HostEmail, $HostPhone, $PurposeOfVisit, $Arrive);

        if ($stmt->execute()) {
            header("Location: display.php?msg=success");
            exit();
        } else {
            $message = "Oops! There was a problem saving your information.";
            echo "<script>
                alert('$message');
                window.location.href = 'index.html';
            </script>";
        }

        $stmt->close();
        $conn->close();
    } else {
        // If validation fails, show alert and go back to form
        $message = implode("\\n", $errors);
        echo "<script>
            alert('$message');
            window.location.href = 'index.html';
        </script>";
    }
}

// Input sanitization function
function test_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}
?>
