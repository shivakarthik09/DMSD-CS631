<?php
session_start();

#include 'templates/session.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve username and password from form
    $username = $_POST["username"];
    $password = $_POST["password"];

  include 'Dbconnection.php';
    // Prepare and execute SQL statement to fetch user from database
    $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Verify password if user exists
    if ($user && password_verify($password, $user['password'])) {
        // Authentication successful
        // Start a session and store admin data in session variables
        $_SESSION["admin_id"] = $user['id'];
        $_SESSION["admin_username"] = $user['username'];
        $_SESSION["admin_firstname"] = $user['firstname'];
        $_SESSION["admin_lastname"] = $user['lastname'];
        $_SESSION["admin_photo"] = $user['photo'];
        $_SESSION["admin_created_on"] = $user['created_on'];

        // Redirect to home page
        header("Location: home.php");
        exit;
    } else {
        // Authentication failed
        // Redirect back to login page with error message
        $_SESSION["error"] = "Invalid username or password";
        header("Location: admin_login.php");
        exit;
    }
}
?>
