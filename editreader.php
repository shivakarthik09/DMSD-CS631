<?php
session_start();

// Check if admin is logged in, otherwise redirect to login page
if (!isset($_SESSION["admin_username"])) {
    header("Location: admin_login.php");
    exit;
}

$conn = new mysqli('localhost:3306', 'root', '', 'LibraryManagement');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Check if the form is submitted and $_POST values are set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['RId'])) {
    // Retrieve Reader ID from the form
    $RId = $_POST['RId'];

    // Check if delete button is clicked
    if(isset($_POST['delete'])) {
        // Delete the reader based on the provided Reader ID
        $delete_sql = "DELETE FROM Reader WHERE RId = '$RId'";
        if ($conn->query($delete_sql) === TRUE) {
            echo "<script>alert('Reader deleted successfully')</script>";
        } else {
            echo "<script>alert('Error deleting reader: " . $conn->error . "')</script>";
        }
    }
}
// Function to fetch reader's information
function getReaderInfo($conn, $RId) {
    $reader_info_sql = "SELECT * FROM Reader WHERE RId = '$RId'";
    $result = $conn->query($reader_info_sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row;
    } else {
        return false;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Readers</title>
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
              
              <li><a href="logout.php" class="logout-btn">Logout</a></li>
          </ul>
      </div>

      <div class="row">

          <div class="col-md-9">
    <div class="content">
        <h2>Edit/Delete Reader</h2>
        <!-- Vertical form for inserting and deleting a reader -->
        <form action="editreader.php" method="post">
                        <div class="form-group">
                            <label for="RId">Reader Id:</label>
                            <input type="text" class="form-control" id="RId" name="RId">
                        </div>
                        <?php
                        if (isset($_POST['edit'])) {
                            $RId = $_POST['RId'];
                            $reader_info = getReaderInfo($conn, $RId);
                            if ($reader_info) {
                                echo '<div class="form-group">';
                                echo '<label for="Name">Name:</label>';
                                echo '<input type="text" class="form-control" id="Name" name="Name" value="' . $reader_info['Name'] . '">';
                                echo '</div>';
                                echo '<div class="form-group">';
                                echo '<label for="Address">Address:</label>';
                                echo '<input type="text" class="form-control" id="Address" name="Address" value="' . $reader_info['Address'] . '">';
                                echo '</div>';
                                echo '<div class="form-group">';
                                echo '<label for="PhoneNumber">PhoneNumber:</label>';
                                echo '<input type="text" class="form-control" id="PhoneNumber" name="PhoneNumber" value="' . $reader_info['PhoneNumber'] . '">';
                                echo '</div>';
                                echo '<div class="form-group">';
                                echo '<label for="Type">Type:</label>';
                                echo '<select class="form-control" id="Type" name="Type">';
                                echo '<option value="Staff" ' . ($reader_info['Type'] == 'Staff' ? 'selected' : '') . '>Staff</option>';
                                echo '<option value="Student" ' . ($reader_info['Type'] == 'Student' ? 'selected' : '') . '>Student</option>';
                                echo '<option value="Public" ' . ($reader_info['Type'] == 'Public' ? 'selected' : '') . '>Public</option>';
                                echo '<option value="Other" ' . ($reader_info['Type'] == 'Other' ? 'selected' : '') . '>Other</option>';
                                echo '</select>';
                                echo '</div>';
                                echo '<button type="submit" class="btn btn-primary" name="edit">Edit Reader</button>';
                            } else {
                                echo '<p>Reader not found!</p>';
                            }
                        } else {
                            echo '<button type="submit" class="btn btn-primary" name="edit">Edit Reader</button>';
                        }
                        ?>
                    </form>
                    <br>

                    <!-- Form for deleting a reader -->
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label for="RId">ReaderID to delete:</label>
                            <input type="text" class="form-control" id="RId" name="RId">
                        </div>
                        <button type="submit" class="btn btn-danger" name="delete">Delete Reader</button>
                    </form>
                    <a href="student_dash.php" class="btn btn-secondary mt-3">Back</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
