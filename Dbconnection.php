<?php
// db_connection.php

// Database connection
global $conn;
$conn = new mysqli('localhost:3306', 'root', '', 'LibraryManagement');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
