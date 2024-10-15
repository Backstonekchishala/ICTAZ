<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Only start session if it's not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require '../dbconnection.php';

// Check if the ID is provided
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('Invalid pupil ID.');
}

$pupilid = intval($_GET['id']);

// Fetch the pupil's current details
$sql = "SELECT * FROM pupils WHERE pupilid = ?";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die('Prepare failed: ' . htmlspecialchars($conn->error));
}

$bind = $stmt->bind_param("i", $pupilid);
if ($bind === false) {
    die('Bind param failed: ' . htmlspecialchars($stmt->error));
}

$execute = $stmt->execute();
if ($execute === false) {
    die('Execute failed: ' . htmlspecialchars($stmt->error));
}

$result = $stmt->get_result();
if ($result->num_rows === 0) {
    die('Pupil not found.');
}

$pupil = $result->fetch_assoc();

$stmt->close();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data with default values
    $username = $_POST['username'] ?? '';
    $firstName = $_POST['firstName'] ?? '';
    $surname = $_POST['surname'] ?? '';
    $dateOfBirth = $_POST['dateOfBirth'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $grade = $_POST['grade'] ?? '';
    $address = $_POST['address'] ?? '';
    $guardianContact = $_POST['guardianContact'] ?? '';
    $examination_number = $_POST['examination_number'] ?? ''; // Default to an empty string if not set

    // Check if examination_number is set
    if (empty($examination_number)) {
        die('Examination number is required.');
    }

    // Update the pupil's details
    $sql = "UPDATE pupils SET username = ?, firstName = ?, surname = ?, dateOfBirth = ?, gender = ?, grade = ?, address = ?, guardianContact = ?, examination_number = ? WHERE pupilid = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }

    $bind = $stmt->bind_param("sssssssssi", $username, $firstName, $surname, $dateOfBirth, $gender, $grade, $address, $guardianContact, $examination_number, $pupilid);
    if ($bind === false) {
        die('Bind param failed: ' . htmlspecialchars($stmt->error));
    }

    $execute = $stmt->execute();
    if ($execute) {
        echo "<script>alert('Pupil updated successfully.');window.location='view_pupils.php';</script>";
    } else {
        echo "<script>alert('Error updating pupil: " . htmlspecialchars($stmt->error) . "');window.location='edit_pupil.php?id=$pupilid';</script>";
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
    <title>Edit Pupil</title>
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
        .edit-pupil-container {
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
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-success">
        <div class="container">
            <span class="navbar-brand mb-0 h1">Chalimbana Secondary Pupil Management System</span>
        </div>
    </nav>

    <div class="container edit-pupil-container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header text-center">
                        <h3>Edit Pupil</h3>
                    </div>
                    <div class="card-body">
                        <form action="edit_pupil.php?id=<?php echo htmlspecialchars($pupilid); ?>" method="POST">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($pupil['username'] ?? ''); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="firstName">First Name</label>
                                <input type="text" class="form-control" id="firstName" name="firstName" value="<?php echo htmlspecialchars($pupil['firstName'] ?? ''); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="surname">Surname</label>
                                <input type="text" class="form-control" id="surname" name="surname" value="<?php echo htmlspecialchars($pupil['surname'] ?? ''); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="dateOfBirth">Date of Birth</label>
                                <input type="date" class="form-control" id="dateOfBirth" name="dateOfBirth" value="<?php echo htmlspecialchars($pupil['dateOfBirth'] ?? ''); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="gender">Gender</label>
                                <select class="form-control" id="gender" name="gender" required>
                                    <option value="Male" <?php echo ($pupil['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                                    <option value="Female" <?php echo ($pupil['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="grade">Grade</label>
                                <select class="form-control" id="grade" name="grade" required>
                                    <?php
                                    for ($i = 1; $i <= 12; $i++) {
                                        $gradeValue = "Grade $i";
                                        echo "<option value='$gradeValue'" . ($pupil['grade'] == $gradeValue ? ' selected' : '') . ">$gradeValue</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" id="address" name="address" value="<?php echo htmlspecialchars($pupil['address'] ?? ''); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="guardianContact">Guardian Contact</label>
                                <input type="text" class="form-control" id="guardianContact" name="guardianContact" value="<?php echo htmlspecialchars($pupil['guardianContact'] ?? ''); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="examination_number">Examination Number</label>
                                <input type="text" class="form-control" id="examination_number" name="examination_number" value="<?php echo htmlspecialchars($pupil['examination_number'] ?? ''); ?>" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Update Pupil</button>
                            <a href=".php" class="btn btn-secondary btn-block mt-3">Go to Dashboard</a>

                        </form>
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
