<?php
	include 'templates/session.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            margin-bottom: 30px;
        }
        .login-options {
            display: flex;
            justify-content: center;
        }
        .login-options a {
            text-decoration: none;
            color: #333;
            padding: 20px;
            margin: 0 10px;
            border-radius: 5px;
            background-color: #f0f0f0;
            transition: background-color 0.3s ease;
        }
        .login-options a:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Login</h1>

        <div class="login-options">
			
		<a href="adminlogin.php">Login as Admin</a>
            <a href="student.php">Login as Student</a>
        </div>
    </div>

</body>
</html>
