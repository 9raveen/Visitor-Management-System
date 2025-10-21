<?php
// Start the session to store any messages
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Visitor Details</title>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="/images/favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Calistoga&display=swap" rel="stylesheet">

    <!-- jQuery + Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <style>
        body {
            background: #f4f6f8;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 20px;
        }

        #p03 {
            font-family: 'Calistoga', cursive;
            font-size: 3vw;
            color: #2c3e50;
            font-weight: bold;
            text-align: center;
            margin-bottom: 30px;
        }

        .table-box {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
            overflow-x: auto;
        }

        .table th, .table td {
            vertical-align: middle !important;
        }

        .alert {
            width: 80%;
            margin: 10px auto 20px;
        }

        .qr-code {
            width: 100px;
            height: 100px;
            margin: 0 auto;
        }

        .qr-code img {
            width: 100%;
            height: 100%;
        }

        .modal-qr {
            text-align: center;
        }

        .modal-qr img {
            max-width: 300px;
            margin: 20px auto;
        }

        @media (max-width: 768px) {
            #p03 {
                font-size: 6vw;
            }

            .table-box {
                padding: 15px;
            }

            .qr-code {
                width: 80px;
                height: 80px;
            }
        }
    </style>
</head>

<body>

    <!-- Status Messages -->
    <?php
    if (isset($_GET['msg']) && $_GET['msg'] === 'success') {
        echo "<div class='alert alert-success text-center'>Visitor registered successfully!🎉</div>";
    }
    
    ?>

    <p id="p03">VISITOR DETAILS</p>

    <div class="container table-box">
        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered text-center">
                <thead class="thead-dark">
                    <tr>
                        <th>UserId</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Host Name</th>
                        <th>Host Email</th>
                        <th>Host Phone</th>
                        <th>Purpose of Visit</th>
                        <th>Arrival</th>
                        <th>Departure</th>
                        <th>QR Code</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include("connect.php");

                    $sql = "SELECT * FROM visitors ORDER BY Arrival DESC";
                    $result = mysqli_query($conn, $sql);

                    while ($row = $result->fetch_assoc()) {
                        // Generate QR code using QR Server API
                        $qrData = json_encode([
                            'id' => $row['UserId'],
                            'name' => $row['Username'],
                            'purpose' => $row['PurposeOfVisit']
                        ]);
                        $qrCodeUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' . urlencode($qrData);
                        
                        echo "<tr>
                            <td>{$row['UserId']}</td>
                            <td>{$row['Username']}</td>
                            <td>{$row['Email']}</td>
                            <td>{$row['Phone']}</td>
                            <td>{$row['HostName']}</td>
                            <td>{$row['HostEmail']}</td>
                            <td>{$row['HostPhone']}</td>
                            <td>{$row['PurposeOfVisit']}</td>
                            <td>{$row['Arrival']}</td>
                            <td>{$row['Departure']}</td>
                            <td>
                                <div class='qr-code'>
                                    <a href='#' data-toggle='modal' data-target='#qrModal{$row['UserId']}'>
                                        <img src='{$qrCodeUrl}' alt='QR Code'>
                                    </a>
                                </div>
                            </td>
                        </tr>";
                        
                        // Modal for QR code
                        echo "<div class='modal fade' id='qrModal{$row['UserId']}' tabindex='-1' role='dialog' aria-hidden='true'>
                            <div class='modal-dialog' role='document'>
                                <div class='modal-content'>
                                    <div class='modal-header'>
                                        <h5 class='modal-title'>Visitor QR Code</h5>
                                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                            <span aria-hidden='true'>&times;</span>
                                        </button>
                                    </div>
                                    <div class='modal-body modal-qr'>
                                        <img src='{$qrCodeUrl}' alt='QR Code'>
                                        <p class='mt-3'><strong>Visitor ID:</strong> {$row['UserId']}</p>
                                        <p><strong>Name:</strong> {$row['Username']}</p>
                                        <p><strong>Purpose of Visit:</strong> {$row['PurposeOfVisit']}</p>
                                    </div>
                                </div>
                            </div>
                        </div>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- Stylish Button to Redirect to Dashboard -->
<footer>
<div class="text-center mt-5">
    <a href="dash.html" class="btn btn-custom">Go to Dashboard</a>
</div>
<style>
    .btn-custom {
        background-color: #0071e3; /* Apple-style blue */
        color: white;
        font-size: 16px;
        padding: 12px 40px;
        border-radius: 50px;
        border: none;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.3s ease-in-out;
        box-shadow: 0 5px 15px rgba(0, 113, 227, 0.2);
    }

    .btn-custom:hover {
        background-color: #0056b3;
        transform: translateY(-2px); /* Subtle upward motion */
        box-shadow: 0 8px 25px rgba(0, 113, 227, 0.3);
    }

    .btn-custom:focus {
        outline: none;
    }

    .badge {
        padding: 8px 12px;
        font-size: 0.9em;
        font-weight: 500;
        letter-spacing: 0.3px;
    }

    .bg-warning {
        background-color: #ffc107 !important;
        color: #000;
    }

    .bg-success {
        background-color: #28a745 !important;
    }

    .bg-danger {
        background-color: #dc3545 !important;
    }
</style>
</footer>
</body>

</html>
