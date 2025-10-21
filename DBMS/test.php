<?php
$conn = mysqli_connect("localhost", "root", "", "visitor_management", 3306);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully to visitor_management!";
?>
