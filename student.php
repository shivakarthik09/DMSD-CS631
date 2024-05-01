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
            <input type="text" name="student_id" placeholder="Enter your ID" required>
            <button type="submit">Search Borrowing</button>
        </form>
    </div>

   

    <div class="search-form">
<form action="" method="post">
        <label for="search">Search by:</label>
        <select name="search_by" id="search_by">
            <option value="DId">DId</option>
            <option value="Title">Title</option>
        </select>
        <input type="text" name="search_term" id="search_term">
        <button type="submit" name="search_btn">Search</button>
    </form>
    </div>
    <br>
    <?php
    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'LibraryManagement');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetching data based on search criteria
    if (isset($_POST['search_btn'])) {
        $search_by = $_POST['search_by'];
        $search_term = $_POST['search_term'];

        $sql = "SELECT * FROM Document WHERE $search_by = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $search_term);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>DId</th><th>Title</th><th>PublisherId</th><th>PublicationDate</th><th>Type</th><th>ISBN</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['DId'] . "</td>";
                echo "<td>" . $row['Title'] . "</td>";
                echo "<td>" . $row['PublisherId'] . "</td>";
                echo "<td>" . $row['PublicationDate'] . "</td>";
                echo "<td>" . $row['Type'] . "</td>";
                echo "<td>" . $row['ISBN'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "No results found.";
        }
    }
?>

    <?php
// // Database connection
// $conn = new mysqli('localhost', 'root', '', 'LibraryManagement');
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }


// Retrieve student ID from the form
if (isset($_GET['student_id'])) {
    $student_id = $_GET['student_id'];


    
    // Query to get borrowed books by the student along with fine calculation
    $sql = "SELECT Document.Title, Borrowing.BorrowDate, Borrowing.ReturnDate, Borrowing.FineAmount
            FROM Borrowing
            INNER JOIN Copy ON Borrowing.CopyId = Copy.CopyId
            INNER JOIN Document ON Copy.DId = Document.DId
            WHERE Borrowing.RId = $student_id";

    $result = $conn->query($sql);


    $sqll = "SELECT Name FROM Reader WHERE RId = $student_id";
    $result1 = $conn->query($sqll);
    // $stmt1 = $conn->prepare($sqll);
    // $stmt1->bind_param("i", $student_id);
    // $stmt1->execute();
    // $result1 = $stmt1->get_result();

    if ($result1->num_rows > 0) {
        $row1 = $result1->fetch_assoc();
        echo "<center><b>Welcome " . $row1['Name']."</b></center>";
    } else {
        echo "No reader found with the provided ID.";
    }
// }

    if ($result->num_rows > 0) {
        // Display borrowed books along with fine in a table
        echo "<table>";
        echo "<tr><th>Title</th><th>Borrow Date</th><th>Return Date</th><th>Fine Amount</th></tr>";
        while ($row = $result->fetch_assoc()) {
            // Calculate fine based on return date and current date
            $returnDate = new DateTime($row['ReturnDate']);
            $currentDate = new DateTime();
            $fine = 0;
            if ($returnDate < $currentDate) {
                $daysLate = $currentDate->diff($returnDate)->days;
                $fine = $daysLate * $row['FineAmount'];
            }
            echo "<tr><td>".$row['Title']."</td><td>".$row['BorrowDate']."</td><td>".$row['ReturnDate']."</td><td>$".$fine."</td></tr>";
        }
        echo "</table>";
    } else {
        echo "No borrowed books found for this student.";
    }
}


?>
<br>
<a href="index.php">Home</a>
<br>
<br>
<center>Note: Checkout, returns and reservation contact admin.</center>


</div>

</body>
</html>
