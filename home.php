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
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            padding: 20px;
        }
        .header {
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            text-align: center;
            margin-bottom: 20px;
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

        .logout-btn:hover {
            background-color: #a93226;
        }
        .info-box {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 20px;
            margin-bottom: 20px;
            background-color: #fff;
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

                <li><a href="Document_copy.php">Document</a></li>
                <li><a href="book.php">Books</a></li>
                <li><a href="Management Insights.php">Management Insights</a></li>
                <li><a href="student_dash.php">Readers</a></li>
                <li><a href="#">Transactions</a></li>
                <li><a href="logout.php" class="logout-btn">Logout</a></li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="info-box">
                    <h3>Total Books</h3>
                    <!-- Replace 'X' with the actual total number of books -->
                    <p>X</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-box">
                    <h3>Borrowed Books</h3>
                    <!-- Replace 'Y' with the actual number of borrowed books -->
                    <p>Y</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-box">
                    <h3>Total Students</h3>
                    <!-- Replace 'Z' with the actual total number of students -->
                    <p>Z</p>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
