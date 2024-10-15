<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require '../dbconnection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $examination_number = $_POST['examination_number'] ?? '';
    $subject_name = $_POST['subject'] ?? '';
    $marks = $_POST['marks'] ?? '';
    $grade = $_POST['grade'] ?? ''; // Added grade
    $date = $_POST['date'] ?? '';
    $class = $_POST['class'] ?? '';

    // Validate required fields
    if (empty($examination_number) || empty($subject_name) || empty($marks) || empty($grade) || empty($date) || empty($class)) {
        echo "<script>alert('All fields are required.');window.location='update_results.php';</script>";
        exit();
    }

    // Get the subjectid from the subject_name
    $getSubjectId = $conn->prepare("SELECT subjectid FROM subjects WHERE subject_name = ?");
    $getSubjectId->bind_param("s", $subject_name);
    $getSubjectId->execute();
    $getSubjectId->bind_result($subjectid);
    $getSubjectId->fetch();
    $getSubjectId->close();

    if ($subjectid) {
        // Check if pupil exists
        $checkPupil = $conn->prepare("SELECT pupilid FROM pupils WHERE examination_number = ?");
        $checkPupil->bind_param("s", $examination_number);
        $checkPupil->execute();
        $checkPupil->bind_result($pupilid);
        $checkPupil->fetch();
        $checkPupil->close();

        if ($pupilid) {
            // Pupil exists, insert result
            $sql = "INSERT INTO results (pupilid, subjectid, marks, grade, date, class)
                    VALUES (?, ?, ?, ?, ?, ?)";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iissss", $pupilid, $subjectid, $marks, $grade, $date, $class);

            if ($stmt->execute()) {
                echo "<script>
                        alert('Result added successfully.');
                        window.location='update_results.php'; // Redirect to the form to add another result
                      </script>";
            } else {
                echo "<script>
                        alert('Error adding result: " . htmlspecialchars($stmt->error) . "');
                        window.location='update_results.php'; // Redirect to the form
                      </script>";
            }

            $stmt->close();
        } else {
            echo "<script>alert('Examination number does not exist.');window.location='update_results.php';</script>";
        }
    } else {
        echo "<script>alert('Subject does not exist.');window.location='update_results.php';</script>";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Results</title>
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
        .update-results-container {
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
        function validateForm() {
            // Additional validation logic can be added here if needed
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

    <div class="container update-results-container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header text-center">
                        <h3>Update Results</h3>
                    </div>
                    <div class="card-body">
                        <form action="update_results.php" method="POST" onsubmit="return validateForm();">
                            <div class="form-group">
                                <label for="examination_number">Examination Number</label>
                                <input type="text" class="form-control" id="examination_number" name="examination_number" placeholder="Enter examination number" required>
                            </div>
                            <div class="form-group">
                                <label for="subject">Subject</label>
                                <select class="form-control" id="subject" name="subject" required>
                                    <?php
                                    // Fetch subjects from the database
                                    $result = $conn->query("SELECT subject_name FROM subjects");
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<option value='" . htmlspecialchars($row['subject_name']) . "'>" . htmlspecialchars($row['subject_name']) . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="marks">Marks</label>
                                <input type="text" class="form-control" id="marks" name="marks" placeholder="Enter marks" required>
                            </div>
                            <div class="form-group">
                                <label for="grade">Grade</label>
                                <input type="text" class="form-control" id="grade" name="grade" placeholder="Enter grade" required>
                            </div>
                            <div class="form-group">
                                <label for="date">Date</label>
                                <input type="date" class="form-control" id="date" name="date" required>
                            </div>
                            <div class="form-group">
                                <label for="class">Class</label>
                                <input type="text" class="form-control" id="class" name="class" placeholder="Enter class" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Add Result</button>
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
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
