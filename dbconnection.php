<?php

// Database connection parameters
$host = 'localhost'; // Replace with your host
$username = 'bc'; // Replace with your database username
$password = 'Tasheni'; // Replace with your database password
$database = 'pms'; // Replace with your database name

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
