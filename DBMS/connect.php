<?php
 // Required for using $_SESSION
ob_start();

$host = "localhost";
$username = "root";
$password = "";
$dbname = "visitor_management";
$port = 3306;

$conn = mysqli_connect($host, $username, $password, $dbname, $port);

if (!$conn) {
    die("Error occurred while connecting to database: " . mysqli_connect_error());
} else {
    $_SESSION["Login-Key"] = "ALMA_CA";
}

ob_end_flush();
?>
