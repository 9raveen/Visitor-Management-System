<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'receptionist') {
    header("Location: login.html");
    exit();
}

include 'connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Receptionist Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f2f5;
            font-family: 'Poppins', sans-serif;
        }
        .dashboard-card {
            background: linear-gradient(to right, #ffffff, #f8f9fa);
            border-radius: 16px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            padding: 40px 30px;
            margin-top: 50px;
        }
        .header-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #343a40;
        }
        .table thead {
            background-color: #4e73df;
            color: #ffffff;
        }
        .btn-custom {
            border-radius: 10px;
            font-weight: 500;
            padding: 10px 20px;
        }
        .btn-success {
            background-color: #1cc88a;
            border: none;
        }
        .btn-success:hover {
            background-color: #17a673;
        }
        .btn-danger:hover {
            background-color: #c82333;
        }
        .visitor-heading {
            margin-top: 30px;
            font-weight: 600;
            color: #4e73df;
        }
        .table-hover tbody tr:hover {
            background-color: #e9ecef;
        }
        .register-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="dashboard-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="header-title">Receptionist Dashboard</h2>
                <a href="logout.php" class="btn btn-danger btn-custom">Logout</a>
            </div>

            <!-- Register Button -->
            <div class="mb-4">
                <a href="index.html" class="btn btn-success btn-custom register-btn">
                    ➕ Register New Visitor
                </a>
            </div>

            <!-- Visitor Table -->
            <h5 class="visitor-heading">Visitor List</h5>
            <div class="table-responsive">
                <table class="table table-hover align-middle table-bordered">
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Host Name</th>
                            <th>Arrival Time</th>
                            <th>Departure Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM visitors ORDER BY Arrival DESC";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                    <td>" . htmlspecialchars($row['UserId']) . "</td>
                                    <td>" . htmlspecialchars($row['Username']) . "</td>
                                    <td>" . htmlspecialchars($row['Email']) . "</td>
                                    <td>" . htmlspecialchars($row['Phone']) . "</td>
                                    <td>" . htmlspecialchars($row['HostName']) . "</td>
                                    <td>" . htmlspecialchars($row['Arrival']) . "</td>
                                    <td>" . htmlspecialchars($row['Departure']) . "</td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7' class='text-center'>No visitors found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
