<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include '../dbconnection.php'; // Adjust the path as needed

// Handle delete request
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $stmt = $conn->prepare("DELETE FROM teachers WHERE teacherid = ?");
    $stmt->bind_param('i', $delete_id);
    if ($stmt->execute()) {
        $successMessage = "Teacher deleted successfully!";
    } else {
        $errorMessage = "Error: " . $stmt->error;
    }
    $stmt->close();
}

// Fetch teachers from the database
$query = "SELECT * FROM teachers";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Teachers</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Custom styles -->
    <style>
        body {
            background-color: #f8f9fa;
            margin-bottom: 60px;
        }
        .card {
            border-radius: 10px;
            width: 100%;
            max-width: 1200px; /* Increased max-width */
            margin: auto; /* Center the card */
        }
        .card-header {
            background-color: #28a745;
            color: white;
            border-radius: 10px 10px 0 0;
        }
        .btn-primary {
            background-color: #28a745;
            border: none;
        }
        .btn-primary:hover {
            background-color: #218838;
        }
        .navbar {
            background-color: #28a745;
        }
        .navbar-brand {
            color: white;
        }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            background-color: #28a745;
            color: white;
            text-align: center;
            padding: 10px 0;
        }
        .footer p {
            margin: 0;
            color: white;
        }
        table {
            width: 100%;
            margin: auto;
        }
        thead th {
            background-color: #e9ecef;
        }
        tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-success">
        <div class="container">
            <span class="navbar-brand mb-0 h1">Chalimbana Secondary Pupil Management System</span>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="admin_dashboard.php">Go to Dashboard</a>
                    </li>
                </ul>
            </div>        
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-header text-center">
                        <h3>View Teachers</h3>
                    </div>
                    <div class="card-body">
                        <?php
                        if (isset($successMessage)) {
                            echo '<div class="alert alert-success">' . $successMessage . '</div>';
                        }
                        if (isset($errorMessage)) {
                            echo '<div class="alert alert-danger">' . $errorMessage . '</div>';
                        }

                        if ($result->num_rows > 0) {
                            echo '<table class="table table-bordered table-striped">';
                            echo '<thead>';
                            echo '<tr>';
                            echo '<th>ID</th>';
                            echo '<th>Username</th>';
                            echo '<th>First Name</th>';
                            echo '<th>Surname</th>';
                            echo '<th>Email</th>';
                            echo '<th>Phone Number</th>';
                            echo '<th>Actions</th>'; // Added column for actions
                            echo '</tr>';
                            echo '</thead>';
                            echo '<tbody>';
                            while ($row = $result->fetch_assoc()) {
                                echo '<tr>';
                                echo '<td>' . $row['teacherid'] . '</td>';
                                echo '<td>' . $row['userName'] . '</td>';
                                echo '<td>' . $row['firstName'] . '</td>';
                                echo '<td>' . $row['surname'] . '</td>';
                                echo '<td>' . $row['email'] . '</td>';
                                echo '<td>' . $row['phoneNumber'] . '</td>';
                                echo '<td>';
                                echo '<a href="edit_teacher.php?id=' . $row['teacherid'] . '" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit</a> ';
                                echo '<a href="?delete_id=' . $row['teacherid'] . '" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure you want to delete this teacher?\');"><i class="fas fa-trash"></i> Delete</a>';
                                echo '</td>';
                                echo '</tr>';
                            }
                            echo '</tbody>';
                            echo '</table>';
                        } else {
                            echo '<div class="alert alert-info">No teachers found.</div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="text-muted mb-0">Chalimbana Secondary Pupil Management System &copy; 2024</p>
        </div>
    </footer>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
