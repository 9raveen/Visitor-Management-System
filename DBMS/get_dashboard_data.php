<?php
header("Content-Type: application/json");
include("connect.php");

if (!$conn) {
    echo json_encode(["error" => "Database connection failed."]);
    exit;
}

// Count stats
$insideQuery = "SELECT COUNT(*) as count FROM visitors WHERE Departure IS NULL OR TRIM(Departure) = '' OR Departure = 'Inside'";

$outsideQuery = "SELECT COUNT(*) as count FROM visitors WHERE Departure IS NOT NULL";
$totalQuery = "SELECT COUNT(*) as count FROM visitors WHERE DATE(Arrival) = CURDATE()";
$alertQuery = "SELECT COUNT(*) as count FROM visitors WHERE Departure IS NULL AND TIMESTAMPDIFF(HOUR, Arrival, NOW()) > 8";

// Recent Check-ins
$recentQuery = "SELECT Username, Arrival, Departure FROM visitors ORDER BY Arrival DESC LIMIT 5";

// Execute queries
$inside = $conn->query($insideQuery)->fetch_assoc()["count"];
$outside = $conn->query($outsideQuery)->fetch_assoc()["count"];
$total = $conn->query($totalQuery)->fetch_assoc()["count"];
$alerts = $conn->query($alertQuery)->fetch_assoc()["count"];

$recent = [];
$result = $conn->query($recentQuery);
while ($row = $result->fetch_assoc()) {
    $status = (empty($row["Departure"]) || trim($row["Departure"]) === '' || $row["Departure"] === 'Inside') ? "Inside" : "Checked Out";

    $recent[] = [
        "name" => $row["Username"],
        "checkIn" => $row["Arrival"],
        "checkOut" => $row["Departure"],
        "status" => $status
    ];
}

// Return JSON
echo json_encode([
    "inside" => $inside,
    "outside" => $outside,
    "total" => $total,
    "alerts" => $alerts,
    "recentCheckins" => $recent
]);
?>
