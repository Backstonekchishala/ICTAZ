<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require '../dbconnection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? '';
    $firstName = $_POST['firstName'] ?? '';
    $surname = $_POST['surname'] ?? '';
    $dateOfBirth = $_POST['dateOfBirth'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $grade = $_POST['grade'] ?? '';
    $address = $_POST['address'] ?? '';
    $guardianContact = $_POST['guardianContact'] ?? '';
    $class = $_POST['class'] ?? ''; // Handle potential undefined index
    $examinationNumber = $_POST['examination_number'] ?? ''; // Added field

    // Validate required fields
    if (empty($username) || empty($firstName) || empty($surname) || empty($dateOfBirth) || empty($gender) || empty($grade) || empty($address) || empty($guardianContact) || empty($class) || empty($examinationNumber)) {
        echo "<script>alert('All fields are required.');window.location='add_pupil.php';</script>";
        exit();
    }

    // Calculate age
    $birthDate = new DateTime($dateOfBirth);
    $today = new DateTime();
    $age = $today->diff($birthDate)->y;

    if ($age < 7) {
        echo "<script>alert('Pupil must be at least 7 years old.');window.location='add_pupil.php';</script>";
        exit();
    }

    // Default password hash
    $defaultPasswordHash = password_hash('defaultpassword', PASSWORD_DEFAULT);

    // SQL query to insert new pupil
    $sql = "INSERT INTO pupils (username, password, firstName, surname, dateOfBirth, gender, grade, class, address, guardianContact, examination_number) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }

    $bind = $stmt->bind_param("sssssssssss", $username, $defaultPasswordHash, $firstName, $surname, $dateOfBirth, $gender, $grade, $class, $address, $guardianContact, $examinationNumber);
    if ($bind === false) {
        die('Bind param failed: ' . htmlspecialchars($stmt->error));
    }

    $execute = $stmt->execute();
    if ($execute) {
        echo "<script>
                alert('Pupil added successfully.');
                window.location='add_pupil.php'; // Redirect to the form to add another pupil
              </script>";
    } else {
        echo "<script>
                alert('Error adding pupil: " . htmlspecialchars($stmt->error) . "');
                window.location='add_pupil.php'; // Redirect to the form
              </script>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Pupil</title>
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
        .add-pupil-container {
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
        .btn-primary {
            background-color: #28a745; /* Green color */
            border: none;
        }
        .btn-primary:hover {
            background-color: #218838; /* Darker green on hover */
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
    </style>
    <script>
        function validateDateOfBirth() {
            var dateOfBirth = document.getElementById('dateOfBirth').value;
            var birthDate = new Date(dateOfBirth);
            var today = new Date();
            var age = today.getFullYear() - birthDate.getFullYear();
            var monthDifference = today.getMonth() - birthDate.getMonth();
            
            if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }

            if (age < 7) {
                alert('Pupil must be at least 7 years old.');
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-success">
        <div class="container">
            <span class="navbar-brand mb-0 h1">Chalimbana Secondary Pupil Management System</span>
        </div>
    </nav>

    <div class="container add-pupil-container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header text-center">
                        <h3>Add Pupil</h3>
                    </div>
                    <div class="card-body">
                        <form action="add_pupil.php" method="POST" onsubmit="return validateDateOfBirth();">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" required>
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
                                <label for="dateOfBirth">Date of Birth</label>
                                <input type="date" class="form-control" id="dateOfBirth" name="dateOfBirth" required>
                            </div>
                            <div class="form-group">
                                <label for="gender">Gender</label>
                                <select class="form-control" id="gender" name="gender" required>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="grade">Grade</label>
                                <select class="form-control" id="grade" name="grade" required>
                                    <?php
                                    for ($i = 8; $i <= 12; $i++) {
                                        echo "<option value='Grade $i'>Grade $i</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="class">Class</label>
                                <select class="form-control" id="class" name="class" required>
                                    <?php
                                    // Example classes, adjust as needed
                                    $classes = ['Class A', 'Class B', 'Class C'];
                                    foreach ($classes as $classOption) {
                                        echo "<option value='$classOption'>$classOption</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" id="address" name="address" placeholder="Enter address" required>
                            </div>
                            <div class="form-group">
                                <label for="guardianContact">Guardian Contact</label>
                                <input type="text" class="form-control" id="guardianContact" name="guardianContact" placeholder="Enter guardian contact" required>
                            </div>
                            <div class="form-group">
                                <label for="examination_number">Examination Number</label>
                                <input type="text" class="form-control" id="examination_number" name="examination_number" placeholder="Enter examination number" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Add Pupil</button>
                        </form>
                        <a href="admin_dashboard.php" class="btn btn-secondary btn-block mt-3">Go to Dashboard</a>
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
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
