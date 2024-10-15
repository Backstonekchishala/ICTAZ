<?php
// update_pupil.php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require '../dbconnection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $firstName = $_POST['firstName'];
    $surname = $_POST['surname'];
    $dateOfBirth = $_POST['dateOfBirth'];
    $gender = $_POST['gender'];
    $grade = $_POST['grade'];
    $address = $_POST['address'];
    $guardianContact = $_POST['guardianContact'];

    // SQL query to update pupil details
    $sql = "UPDATE pupils SET firstName=?, surname=?, dateOfBirth=?, gender=?, grade=?, address=?, guardianContact=? WHERE userName=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssss", $firstName, $surname, $dateOfBirth, $gender, $grade, $address, $guardianContact, $username);

    if ($stmt->execute()) {
        echo "<script>alert('Pupil updated successfully.');window.location='view_pupils.php';</script>";
    } else {
        echo "<script>alert('Error updating pupil: " . htmlspecialchars($stmt->error) . "');window.location='view_pupils.php';</script>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
?>
