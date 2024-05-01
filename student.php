<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard</title>
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
        .search-form {
            text-align: center;
        }
        .search-form input[type="text"] {
            width: 60%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
        }
        .search-form button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }
        .search-form button:hover {
            background-color: #45a049;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Welcome, Student!</h1>

    <div class="search-form">
        <form action="" method="GET">
            <input type="text" name="student_id" placeholder="Enter your student ID" required>
            <button type="submit">Search Books</button>
        </form>
    </div>

    <?php
    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'LibraryManagement');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve student ID from the form
    if (isset($_GET['student_id'])) {
        $student_id = $_GET['student_id'];
        
        // Query to get borrowed books by the student
        $sql = "SELECT Document.Title, Borrowing.BorrowDate, Borrowing.ReturnDate
                FROM Borrowing
                INNER JOIN Copy ON Borrowing.CopyId = Copy.CopyId
                INNER JOIN Document ON Copy.DId = Document.DId
                WHERE Borrowing.RId = $student_id";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Display borrowed books in a table
            echo "<table>";
            echo "<tr><th>Title</th><th>Borrow Date</th><th>Return Date</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>".$row['Title']."</td><td>".$row['BorrowDate']."</td><td>".$row['ReturnDate']."</td></tr>";
            }
            echo "</table>";
        } else {
            echo "No borrowed books found for this student.";
        }
    }
    ?>

</div>

</body>
</html>
