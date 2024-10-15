<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Only start session if it's not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require '../dbconnection.php';

// Check if the ID is provided and is valid
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('Invalid pupil ID.');
}

$pupilid = intval($_GET['id']);

// Prepare the SQL query to delete the pupil
$sql = "DELETE FROM pupils WHERE pupilid = ?";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die('Prepare failed: ' . htmlspecialchars($conn->error));
}

$bind = $stmt->bind_param("i", $pupilid);
if ($bind === false) {
    die('Bind param failed: ' . htmlspecialchars($stmt->error));
}

$execute = $stmt->execute();
if ($execute) {
    // Successfully deleted
    echo "<script>alert('Pupil deleted successfully.');window.location='view_pupils.php';</script>";
} else {
    // Error occurred
    echo "<script>alert('Error deleting pupil: " . htmlspecialchars($stmt->error) . "');window.location='view_pupils.php';</script>";
}

$stmt->close();
$conn->close();
?>
