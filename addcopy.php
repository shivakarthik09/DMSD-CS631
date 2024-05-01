<?php
session_start();

// Check if admin is logged in, otherwise redirect to login page
if (!isset($_SESSION["admin_username"])) {
    header("Location: admin_login.php");
    exit;
}

// Database connection
$conn = new mysqli('localhost:3307', 'root', '', 'LibraryManagement');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
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
        .content {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table th, .table td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: left;
        }
        .table th {
            background-color: #f2f2f2;
        }
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        .pagination a {
            color: black;
            float: left;
            padding: 8px 16px;
            text-decoration: none;
            border: 1px solid #ddd;
            margin: 0 4px;
        }
        .pagination a.active {
            background-color: #4CAF50;
            color: white;
        }
        .pagination a:hover:not(.active) {
            background-color: #ddd;
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
              <li><a href="book.php">Books</a></li>
              <li><a href="student_dash.php">Readers</a></li>
              <li><a href="#">Transactions</a></li>
              <li><a href="logout.php" class="logout-btn">Logout</a></li>
          </ul>
      </div>

      <div class="row">
          <div class="col-md-3">
              <div class="sidebar">
                  <!-- <h3>Book Management</h3> -->
                  <ul>
                      <li><a href="addcopy.php">Add Copy</a></li>
                      <li><a href="Searchcopy.php">Search Copy</a></li>
                      <li><a href="editcopy.php">Edit Copy</a></li>


                  </ul>
              </div>
          </div>
          <div class="col-md-9">
    <div class="content">
        <h2>Add Copy</h2>
        <!-- Vertical form for inserting a document copy -->
        <form action="admin_functions.php?function=addDocumentCopy" method="post">
            <div class="form-group">
                <label for="DID">DID:</label>
                <input type="text" class="form-control" id="DID" name="DID">
            </div>
            <div class="form-group">
                <label for="BID">BID:</label>
                <input type="text" class="form-control" id="BID" name="BID">
            </div>
            <div class="form-group">
                <label for="ShelfNumber">Shelf Position:</label>
                <input type="text" class="form-control" id="Position" name="Position">
            </div>
            <div class="form-group">
              <label for="Status">Status:</label>
                  <select class="form-control" id="Status" name="Status">
                      <option value="Available">Available</option>
                      <option value="Reserved">Reserved</option>
                      <option value="Borrowed">Borrowed</option>
                  </select>
            </div>
            <button type="submit" class="btn btn-primary">Add Copy</button>
        </form>
    </div>
</div>



            </div>
        </div>
    </div>

</body>
</html>
