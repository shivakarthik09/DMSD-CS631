<?php
session_start();

// Check if admin is logged in, otherwise redirect to login page
if (!isset($_SESSION["admin_username"])) {
    header("Location: admin_login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Books</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .header {
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            text-align: center;
        }
        .menu {
            background-color: #ddd;
            padding: 25px 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .menu ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
            text-align: center;
        }
        .menu ul li {
            display: inline;
            margin-right: 20px;
        }
        .menu ul li:last-child {
            margin-right: 0;
        }
        .menu ul li a {
            text-decoration: none;
            color: #333;
            padding: 10px 20px;
            border-radius: 5px;
            background-color: #fff;
            transition: background-color 0.3s ease;
        }
        .menu ul li a:hover {
            background-color: #ccc;
        }
        .sidebar {
            background-color: #333;
            color: #fff;
            padding: 20px;
            border-radius: 5px;
            height: 100%;
        }
        .sidebar ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }
        .sidebar ul li {
            margin-bottom: 10px;
        }
        .sidebar ul li a {
            text-decoration: none;
            color: #fff;
            transition: color 0.3s ease;
        }
        .sidebar ul li a:hover {
            color: #ccc;
        }
        .content {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Welcome, <?php echo $_SESSION["admin_username"]; ?>!</h1>
    </div>

    <div class="container">
        <div class="menu">
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="Document_copy.php">Documents</a></li>
                <li><a href="Management Insights.php">Management Insights</a></li>
                <li><a href="book.php">Books</a></li>
                <li><a href="student_dash.php">Readers</a></li>
                
                <li><a href="logout.php" class="logout-btn">Logout</a></li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-3">
                <div class="sidebar">
                     <h4>Books Management</h4>
                    <ul>
                        <li><a href="createbook.php">Add Book</a></li>
                        <li><a href="searchbook.php">Search Book</a></li>
                        <li><a href="editbook.php">Edit/Delete Book</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-9">
                <div class="content">
                    <h2>Books</h2>
                    <!-- Add your books content here -->
                </div>
            </div>
        </div>
    </div>

</body>
</html>
