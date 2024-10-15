<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include '../dbconnection.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $userName = $_POST['userName'];
    $firstName = $_POST['firstName'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['phoneNumber'];

    // Fetch the hashed password of backstonekchishala@gmail.com
    $result = $conn->query("SELECT password FROM teachers WHERE email = 'backstonekchishala@gmail.com'");
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row['password'];
    } else {
        die("Default teacher's password not found.");
    }

    // Prepare SQL statement to insert new teacher
    $stmt = $conn->prepare("INSERT INTO teachers (userName, firstName, surname, email, password, phoneNumber) VALUES (?, ?, ?, ?, ?, ?)");
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    // Bind parameters and execute statement
    $stmt->bind_param('ssssss', $userName, $firstName, $surname, $email, $hashedPassword, $phoneNumber);
    if ($stmt->execute()) {
        $successMessage = "Teacher added successfully!";
    } else {
        $errorMessage = "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Teacher</title>
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
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-success">
        <div class="container">
            <span class="navbar-brand mb-0 h1">Chalimbana Secondary Pupil Management System</span>
        </div>
    </nav>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header text-center">
                        <h3>Add Teacher</h3>
                    </div>
                    <div class="card-body">
                        <?php
                        if (isset($successMessage)) {
                            echo '<div class="alert alert-success">' . $successMessage . '</div>';
                        }
                        if (isset($errorMessage)) {
                            echo '<div class="alert alert-danger">' . $errorMessage . '</div>';
                        }
                        ?>
                        <form action="add_teacher.php" method="POST">
                            <div class="form-group">
                                <label for="userName">Username</label>
                                <input type="text" class="form-control" id="userName" name="userName" placeholder="Enter username" required>
                            </div>
                            <div class="form-group">
                                <label for="firstName">First Name</label>
                                <input type="text" class="form-control" id="firstName" name="firstName" placeholder="Enter first name" required>
                            </div>
                            <div class="form-group">
                                <label for="surname">Surname</label>
                                <input type="text" class="form-control" id="surname" name="surname" placeholder="Enter surname" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email address</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
                            </div>
                            <div class="form-group">
                                <label for="phoneNumber">Phone Number</label>
                                <input type="text" class="form-control" id="phoneNumber" name="phoneNumber" placeholder="Enter phone number" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Add Teacher</button>
                            <a href="admin_dashboard.php" class="btn btn-secondary btn-block mt-3">Go to Dashboard</a>                        </form>
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
