<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require '../dbconnection.php';

// Retrieve the examination number from the request
if (isset($_POST['search'])) {
    $examination_number = trim($_POST['examination_number']);

    // Prepare SQL statement to retrieve pupil results based on the examination number
    $stmt = $conn->prepare("
        SELECT p.firstName, p.surname, s.subject_name, r.marks, r.grade, r.date, r.class
        FROM results r
        JOIN pupils p ON r.pupilid = p.pupilid
        JOIN subjects s ON r.subjectid = s.subjectid
        WHERE p.examination_number = ?
    ");
    $stmt->bind_param("s", $examination_number);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<table class='table table-bordered'>";
        echo "<thead><tr><th>#</th><th>First Name</th><th>Surname</th><th>Subject</th><th>Marks</th><th>Grade</th><th>Date</th><th>Class</th></tr></thead>";
        echo "<tbody>";
        $counter = 1;
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($counter++) . "</td>";
            echo "<td>" . htmlspecialchars($row['firstName'] ?? 'N/A') . "</td>";
            echo "<td>" . htmlspecialchars($row['surname'] ?? 'N/A') . "</td>";
            echo "<td>" . htmlspecialchars($row['subject_name'] ?? 'N/A') . "</td>";
            echo "<td>" . htmlspecialchars($row['marks'] ?? 'N/A') . "</td>";
            echo "<td>" . htmlspecialchars($row['grade'] ?? 'N/A') . "</td>";
            echo "<td>" . htmlspecialchars($row['date'] ?? 'N/A') . "</td>";
            echo "<td>" . htmlspecialchars($row['class'] ?? 'N/A') . "</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
    } else {
        echo "<p>No results found for the provided examination number.</p>";
    }
    $stmt->close();
} else {
    echo "<p>Please enter an examination number to search for results.</p>";
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Results</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <div class="container">
        <h2 class="mt-4">View Results</h2>
        <form method="POST" action="view_results.php">
            <div class="form-group">
                <label for="examination_number">Examination Number:</label>
                <input type="text" name="examination_number" id="examination_number" class="form-control" required>
            </div>
            <button type="submit" name="search" class="btn btn-primary">Search</button>
        </form>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
