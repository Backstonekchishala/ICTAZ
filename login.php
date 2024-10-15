<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include 'dbconnection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Protect against SQL injection
    $email = mysqli_real_escape_string($conn, $email);

    // Default password for all users
    $default_password = '1234';

    // Function to verify user
    function verify_user($conn, $email, $default_password, $table, $redirect_page) {
        $sql = "SELECT * FROM $table WHERE email = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Prepare failed: " . htmlspecialchars($conn->error));
        }
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($default_password, $row['password'])) {
                // Login successful
                foreach ($row as $key => $value) {
                    $_SESSION[$key] = $value;
                }
                header("Location: $redirect_page");
                exit();
            } else {
                echo "<script>alert('Incorrect password. Please try again.');window.location='index.php';</script>";
            }
        }
        $stmt->close();
    }

    // Check if the user is a teacher
    verify_user($conn, $email, $default_password, 'teachers', 'teacher/teacher_dashboard.php');

    // Check if the user is an admin
    verify_user($conn, $email, $default_password, 'admin', 'admin/admin_dashboard.php');

    // Check if the user is a parent
    verify_user($conn, $email, $default_password, 'parents', 'parent/parent_dashboard.php');

    // No user found with that email
    echo "<script>alert('User with this email does not exist.');window.location='index.php';</script>";

    $conn->close();
}
?>
