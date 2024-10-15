<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include '../dbconnection.php'; // Adjust the path as needed

// Fetch the teacher's details
if (isset($_GET['id'])) {
    $teacherid = intval($_GET['id']);
} elseif (isset($_POST['teacherid'])) {
    $teacherid = intval($_POST['teacherid']);
} else {
    $errorMessage = "No teacher ID provided.";
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $teacherid = intval($_POST['teacherid']);
    $userName = $_POST['userName'];
    $firstName = $_POST['firstName'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['phoneNumber'];

    // Prepare SQL statement to update teacher
    $stmt = $conn->prepare("UPDATE teachers SET userName = ?, firstName = ?, surname = ?, email = ?, phoneNumber = ? WHERE teacherid = ?");
    $stmt->bind_param('sssssi', $userName, $firstName, $surname, $email, $phoneNumber, $teacherid);
    if ($stmt->execute()) {
        $successMessage = "Teacher updated successfully!";
    } else {
        $errorMessage = "Error: " . $stmt->error;
    }
    $stmt->close();
}

// Fetch the updated teacher's details
if (isset($teacherid)) {
    $query = "SELECT * FROM teachers WHERE teacherid = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $teacherid);
    $stmt->execute();
    $result = $stmt->get_result();
    $teacher = $result->fetch_assoc();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Teacher</title>
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
            max-width: 800px; /* Adjust width if needed */
            margin: auto;
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

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header text-center">
                        <h3>Edit Teacher</h3>
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
                        <?php if (isset($teacher)): ?>
                        <form action="edit_teacher.php?id=<?php echo $teacherid; ?>" method="POST">
                            <input type="hidden" name="teacherid" value="<?php echo htmlspecialchars($teacher['teacherid']); ?>">
                            <div class="form-group">
                                <label for="userName">Username</label>
                                <input type="text" class="form-control" id="userName" name="userName" value="<?php echo htmlspecialchars($teacher['userName']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="firstName">First Name</label>
                                <input type="text" class="form-control" id="firstName" name="firstName" value="<?php echo htmlspecialchars($teacher['firstName']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="surname">Surname</label>
                                <input type="text" class="form-control" id="surname" name="surname" value="<?php echo htmlspecialchars($teacher['surname']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email address</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($teacher['email']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="phoneNumber">Phone Number</label>
                                <input type="text" class="form-control" id="phoneNumber" name="phoneNumber" value="<?php echo htmlspecialchars($teacher['phoneNumber']); ?>" required>
                            </div>
                            <button type="submit" name="update" class="btn btn-primary btn-block">Update Teacher</button>
                        </form>
                        <?php else: ?>
                        <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
                        <a href="manage_teachers.php" class="btn btn-secondary btn-block">Go Back</a>
                        <?php endif; ?>
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
