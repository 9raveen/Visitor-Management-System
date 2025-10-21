<?php
session_start();
include 'connect.php';

// Check if security is logged in
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'security') {
    header('Location: login.html');
    exit();
}

date_default_timezone_set('Asia/Kolkata');

// Fetch visitors who are still inside
$sql = "SELECT * FROM visitors WHERE Departure = 'Inside'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Security Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #eef2f7;
        }
        .dashboard-card {
            background: #fff;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            animation: fadeIn 0.6s ease;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px);}
            to { opacity: 1; transform: translateY(0);}
        }
        .header-title {
            font-size: 2.2rem;
            font-weight: bold;
            color: #343a40;
        }
        .btn-custom {
            border-radius: 8px;
        }
        .table thead {
            background-color: #212529;
            color: white;
        }
        .logout-btn {
            background-color: #dc3545;
            border: none;
            transition: 0.3s;
        }
        .logout-btn:hover {
            background-color: #c82333;
        }
        .mark-exit-btn {
            background-color: #007bff;
            border: none;
            transition: 0.3s;
        }
        .mark-exit-btn:hover {
            background-color: #0056b3;
        }
        .no-visitors {
            background-color: #d1ecf1;
            color: #0c5460;
            padding: 15px;
            border-radius: 8px;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="dashboard-card">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="header-title"><i class="fas fa-user-shield me-2"></i>Security Dashboard</h2>
            <a href="logout.php" class="btn logout-btn btn-custom"><i class="fas fa-sign-out-alt me-1"></i> Logout</a>
        </div>

        <h5 class="mb-3">Visitors Currently Inside</h5>

        <?php if ($result->num_rows > 0): ?>
            <div class="table-responsive">
                <table class="table table-hover align-middle table-bordered">
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>Username</th>
                            <th>Phone</th>
                            <th>Purpose of Visit</th>
                            <th>Arrival Time</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($visitor = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($visitor['UserId']); ?></td>
                                <td><?php echo htmlspecialchars($visitor['Username']); ?></td>
                                <td><?php echo htmlspecialchars($visitor['Phone']); ?></td>
                                <td><?php echo htmlspecialchars($visitor['PurposeOfVisit']); ?></td>
                                <td><?php echo htmlspecialchars($visitor['Arrival']); ?></td>
                                <td>
                                    <form method="POST" action="security_exit.php" class="d-inline">
                                        <input type="hidden" name="user_id" value="<?php echo $visitor['UserId']; ?>">
                                        <button type="submit" class="btn mark-exit-btn btn-sm btn-custom">
                                            <i class="fas fa-door-open me-1"></i> Mark Exit
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="no-visitors text-center">
                <i class="fas fa-user-slash fa-2x mb-2"></i>
                <h5>No visitors currently inside.</h5>
            </div>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
</body>
</html>
