<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require '../dbconnection.php';

// Query to retrieve all pupils
$sql = "SELECT pupilid, username, firstName, surname, dateOfBirth, gender, grade, class, address, guardianContact, examination_number FROM pupils";
$result = $conn->query($sql);

if ($result === false) {
    die('Error retrieving pupils: ' . htmlspecialchars($conn->error));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Pupils</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Custom styles for dashboard -->
    <style>
        body {
            background-color: #f8f9fa;
            margin-bottom: 60px; /* Adjusted to make space for the fixed footer */
        }
        .view-pupils-container {
            margin-top: 100px;
        }
        .card {
            border-radius: 10px;
            width: 100%;
        }
        .card-header {
            background-color: #28a745; /* Green color */
            color: white;
            border-radius: 10px 10px 0 0; /* top-left, top-right, bottom-right, bottom-left */
        }
        .navbar {
            background-color: #28a745; /* Green color */
        }
        .navbar-brand {
            color: white;
        }
        .navbar-dark .navbar-nav .nav-link {
            color: white;
        }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            background-color: #28a745; /* Green color */
            color: white;
            text-align: center;
            padding: 10px 0;
        }
        .footer p {
            color: white;
        }
        table {
            width: 100%;
            margin-bottom: 20px;
        }
        th, td {
            text-align: center;
            padding: 20px; /* Increased padding for larger cells */
            font-size: 16px; /* Increased font size */
        }
        th {
            background-color: #28a745; /* Green color */
            color: white;
            font-size: 18px; /* Increased font size for headers */
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .btn-edit, .btn-delete {
            margin: 0 5px;
            display: inline-block; /* Ensure buttons are on the same line */
        }
        .btn-group {
            display: flex; /* Use flexbox to keep buttons on the same line */
            justify-content: center; /* Center align buttons horizontally */
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-success">
        <div class="container">
            <span class="navbar-brand mb-0 h1">Chalimbana Secondary Pupil Management System</span>
        </div>
    </nav>

    <div class="container view-pupils-container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-header text-center">
                        <h3>View Pupils</h3>
                    </div>
                    <div class="card-body">
                        <?php
                        if ($result->num_rows > 0) {
                            echo "<table class='table table-bordered'>";
                            echo "<thead><tr><th>Username</th><th>First Name</th><th>Surname</th><th>Date of Birth</th><th>Gender</th><th>Grade</th><th>Class</th><th>Address</th><th>Guardian Contact</th><th>Examination Number</th><th>Actions</th></tr></thead>";
                            echo "<tbody>";
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr><td>" . htmlspecialchars($row['username']) . "</td><td>" . htmlspecialchars($row['firstName']) . "</td><td>" . htmlspecialchars($row['surname']) . "</td><td>" . htmlspecialchars($row['dateOfBirth']) . "</td><td>" . htmlspecialchars($row['gender']) . "</td><td>" . htmlspecialchars($row['grade']) . "</td><td>" . htmlspecialchars($row['class']) . "</td><td>" . htmlspecialchars($row['address']) . "</td><td>" . htmlspecialchars($row['guardianContact']) . "</td><td>" . htmlspecialchars($row['examination_number']) . "</td>";
                                echo "<td><div class='btn-group'><a href='edit_pupil.php?id=" . htmlspecialchars($row['pupilid']) . "' class='btn btn-warning btn-edit'><i class='fas fa-edit'></i> Edit</a>";
                                echo "<a href='delete_pupil.php?id=" . htmlspecialchars($row['pupilid']) . "' class='btn btn-danger btn-delete' onclick='return confirm(\"Are you sure you want to delete this pupil?\");'><i class='fas fa-trash'></i> Delete</a></div></td></tr>";
                            }
                            echo "</tbody>";
                            echo "</table>";
                        } else {
                            echo "<p>No pupils found.</p>";
                        }
                        $conn->close();
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p>&copy; 2024 Chalimbana Secondary Pupil Management System</p>
        </div>
    </footer>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
