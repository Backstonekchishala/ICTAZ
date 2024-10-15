<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include '../dbconnection.php'; // Adjust the path as needed

// Check if ID is provided
if (isset($_GET['id'])) {
    $teacherid = intval($_GET['id']);

    // Prepare SQL statement to delete teacher
    $stmt = $conn->prepare("DELETE FROM teachers WHERE teacherid = ?");
    $stmt->bind_param('i', $teacherid);
    if ($stmt->execute()) {
        $successMessage = "Teacher deleted successfully!";
    } else {
        $errorMessage = "Error: " . $stmt->error;
    }
    $stmt->close();
} else {
    $errorMessage = "Invalid ID.";
}

header("Location: view_teacher.php"); // Redirect back to view_teacher.php
exit();
?>
