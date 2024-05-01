<?php
session_start();

// Check if admin is logged in, otherwise redirect to login page
if (!isset($_SESSION["admin_username"])) {
    header("Location: admin_login.php");
    exit;
}

// Database connection
$conn = new mysqli('localhost:3306', 'root', '', 'LibraryManagement');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to add a document copy
function addDocumentCopy() {
    global $conn;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $DID = $_POST["DID"];
        $BID = $_POST["BID"];
        $Position = $_POST["Position"];
        $Status = "Available"; // Assuming initial status is 'Available'

        // Check if Status is provided in the form submission
        if (isset($_POST["Status"])) {
            $Status = $_POST["Status"];
        }

        // Validate the status value to ensure it's one of the allowed options
        $allowedStatus = array('Available', 'Reserved', 'Borrowed');
        if (!in_array($Status, $allowedStatus)) {
            echo "Error: Invalid status value.";
            return;
        }

        $sql = "INSERT INTO Copy (DID, BID, Position, Status) VALUES ('$DID', '$BID', '$Position', '$Status')";
        if ($conn->query($sql) === TRUE) {
            // Display success message and branch information in a fancy way
            echo '<div style="background-color: #dff0d8; border: 1px solid #d0e9c6; color: #3c763d; padding: 15px; margin-bottom: 20px; border-radius: 4px;">';
            echo '<p>Document copy added successfully.</p>';
            echo '</div>';

            // Query to retrieve branch information
            $branchSql = "SELECT Name, Location FROM Branch WHERE BId = '$BID'";
            $branchResult = $conn->query($branchSql);
            if ($branchResult->num_rows > 0) {
                $branchRow = $branchResult->fetch_assoc();
                echo '<div style="background-color: #f0f0f0; border: 1px solid #ccc; padding: 15px; margin-bottom: 20px; border-radius: 4px;">';
                echo '<p><strong>Branch Name:</strong> ' . $branchRow["Name"] . '</p>';
                echo '<p><strong>Location:</strong> ' . $branchRow["Location"] . '</p>';
                echo '</div>';
            } else {
                echo "Error: Branch information not found.";
            }
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}



function searchDocumentCopy($documentId, $branchId) {
    global $conn;

    // Query to retrieve document copies based on document ID and branch ID, along with branch information
    $sql = "SELECT c.CopyId, c.Position, c.Status, b.Name AS BranchName, b.Location AS BranchLocation
            FROM Copy c
            INNER JOIN Branch b ON c.BID = b.BId
            WHERE c.DID = '$documentId' AND c.BID = '$branchId'";
    $result = $conn->query($sql);

    // Check if any document copies are found
    if ($result->num_rows > 0) {
        // Loop through each document copy and display its information
        while ($row = $result->fetch_assoc()) {
            $copyId = $row['CopyId'];
            $position = $row['Position'];
            $status = $row['Status'];
            $branchName = $row['BranchName'];
            $branchLocation = $row['BranchLocation'];

            // Display document copy information
            echo '<div style="background-color: #f0f0f0; border: 1px solid #ccc; padding: 15px; margin-bottom: 20px; border-radius: 4px;">';
            echo '<p><strong>Copy ID:</strong> ' . $copyId . '</p>';
            echo '<p><strong>Position:</strong> ' . $position . '</p>';
            echo '<p><strong>Status:</strong> ' . $status . '</p>';
            echo '<p><strong>Branch Name:</strong> ' . $branchName . '</p>';
            echo '<p><strong>Branch Location:</strong> ' . $branchLocation . '</p>';
            echo '</div>';
        }
    } else {
        echo "No document copies found for the given criteria.";
    }
}

// Check if form is submitted for searching document copies
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["DId"]) && isset($_POST["BId"])) {
    // Get the document ID and branch ID from the form submission
    $searchDocumentId = $_POST["DId"];
    $searchBranchId = $_POST["BId"];

    // Call the searchDocumentCopy function with the provided arguments
    searchDocumentCopy($searchDocumentId, $searchBranchId);
}


// Function to edit document copy details
function EditDocumentCopy($CopyId, $DId, $BId, $Position, $Status) {
    global $conn;

    // SQL to update the details of a document copy
    $sql = "UPDATE Copy SET DId='$DId', BId='$BId', Position='$Position', Status='$Status' WHERE CopyId='$CopyId'";

    if ($conn->query($sql) === TRUE) {
        echo "Document copy details updated successfully.";
    } else {
        echo "Error updating document copy details: " . $conn->error;
    }
}

// Function to delete document copy
function DeleteDocumentCopy($CopyId) {
    global $conn;

    // SQL to delete a document copy
    $sql = "DELETE FROM Copy WHERE CopyId='$CopyId'";

    if ($conn->query($sql) === TRUE) {
        echo "Document copy deleted successfully.";
    } else {
        echo "Error deleting document copy: " . $conn->error;
    }
}
function addbookcopy() {
    global $conn;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $Title = $_POST["Title"];
        $PublisherId = $_POST["PublisherId"];
        $PublicationDate = $_POST["PublicationDate"];
        $Type = $_POST["Type"];
        $ISBN = $_POST["ISBN"];


        $sql = "INSERT INTO Document (Title, PublisherId, PublicationDate, Type, ISBN) VALUES ('$Title', '$PublisherId', '$PublicationDate', '$Type', '$ISBN')";
        if ($conn->query($sql) === TRUE) {
            // Display success message and branch information in a fancy way
            echo '<div style="background-color: #dff0d8; border: 1px solid #d0e9c6; color: #3c763d; padding: 15px; margin-bottom: 20px; border-radius: 4px;">';
            echo '<p>Document added successfully.</p>';
            echo '</div>';

            // Query to retrieve branch information

        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Function to add a new reader
function addNewReader() {
    // Implement SQL query to add a new reader
    // Example: INSERT INTO Reader (name, email, ...) VALUES (...);
}

// Function to print branch information (name and location)
function printBranchInformation() {
    // Implement SQL query to print branch information
    // Example: SELECT branchId, branchName, location FROM Branch;
}

// Function to print the top N most frequent borrowers in branch I and the number of books each has borrowed
function topNBorrowersInBranch($N, $branchId) {
    // Implement SQL query to get top N most frequent borrowers in branch I
    // Example: SELECT Rid, name, COUNT(*) AS num_books_borrowed FROM Borrower WHERE branchId = $branchId GROUP BY Rid, name ORDER BY num_books_borrowed DESC LIMIT $N;
}

// Function to print the top N most frequent borrowers in the library and the number of books each has borrowed
function topNBorrowersInLibrary($N) {
    // Implement SQL query to get top N most frequent borrowers in the library
    // Example: SELECT Rid, name, COUNT(*) AS num_books_borrowed FROM Borrower GROUP BY Rid, name ORDER BY num_books_borrowed DESC LIMIT $N;
}

// Function to print the N most borrowed books in branch I
function mostBorrowedBooksInBranch($N, $branchId) {
    // Implement SQL query to get N most borrowed books in branch I
    // Example: SELECT BookId, COUNT(*) AS num_borrowed FROM BorrowedBooks WHERE branchId = $branchId GROUP BY BookId ORDER BY num_borrowed DESC LIMIT $N;
}

// Function to print the N most borrowed books in the library
function mostBorrowedBooksInLibrary($N) {
    // Implement SQL query to get N most borrowed books in the library
    // Example: SELECT BookId, COUNT(*) AS num_borrowed FROM BorrowedBooks GROUP BY BookId ORDER BY num_borrowed DESC LIMIT $N;
}

// Function to print the 10 most popular books of a given year in the library
function mostPopularBooksByYear($year) {
    // Implement SQL query to get 10 most popular books of a given year in the library
    // Example: SELECT BookId, COUNT(*) AS num_borrowed FROM BorrowedBooks WHERE YEAR(date_borrowed) = $year GROUP BY BookId ORDER BY num_borrowed DESC LIMIT 10;
}

// Function to print branch Id, name, and average fine paid by borrowers for documents borrowed from this branch during a given period
function printBranchFineInformation($startDate, $endDate) {
    // Implement SQL query to get branch Id, name, and average fine paid by borrowers
    // Example: SELECT Branch.branchId, branchName, AVG(fineAmount) AS avg_fine FROM BorrowedBooks INNER JOIN Branch ON BorrowedBooks.branchId = Branch.branchId WHERE date_borrowed BETWEEN $startDate AND $endDate GROUP BY Branch.branchId, branchName;
}

// Check if a function is selected from the menu
if (isset($_GET['function'])) {
    $function = $_GET['function'];

    switch ($function) {
        case 'addbookcopy':
            addDocumentCopy();
            break;

        case 'addDocumentCopy':
            addDocumentCopy();
            break;
        case 'searchDocumentCopy':
            if (isset($_GET['documentId']) && isset($_GET['branchId'])) {
                // Call the function with the provided parameters
                searchDocumentCopy($_GET['documentId'], $_GET['branchId']);
            } else {
                echo "Error: Missing parameters for searching document copy.";
            }
            break;
        case 'EditDocumentCopy':
            if (isset($_POST['CopyId'], $_POST['DID'], $_POST['BID'], $_POST['Position'], $_POST['Status'])) {
                editDocumentCopy($_POST['CopyId'], $_POST['DID'], $_POST['BID'], $_POST['Position'], $_POST['Status']);
            } else {
                echo "Error: Missing parameters for editing document copy.";
            }
            break;
        case 'DeleteDocumentCopy':
            if (isset($_POST['CopyId'])) {
                DeleteDocumentCopy($_POST['CopyId']);
            } else {
                echo "Error: Missing Copy ID for deleting document copy.";
            }
            break;
        case 'addNewReader':
            addNewReader();
            break;
        case 'printBranchInformation':
            printBranchInformation();
            break;
        case 'topNBorrowersInBranch':
            if (isset($_GET['N']) && isset($_GET['branchId'])) {
                topNBorrowersInBranch($_GET['N'], $_GET['branchId']);
            }
            break;
        case 'topNBorrowersInLibrary':
            if (isset($_GET['N'])) {
                topNBorrowersInLibrary($_GET['N']);
            }
            break;
        case 'mostBorrowedBooksInBranch':
            if (isset($_GET['N']) && isset($_GET['branchId'])) {
                mostBorrowedBooksInBranch($_GET['N'], $_GET['branchId']);
            }
            break;
        case 'mostBorrowedBooksInLibrary':
            if (isset($_GET['N'])) {
                mostBorrowedBooksInLibrary($_GET['N']);
            }
            break;
        case 'mostPopularBooksByYear':
            if (isset($_GET['year'])) {
                mostPopularBooksByYear($_GET['year']);
            }
            break;
        case 'printBranchFineInformation':
            if (isset($_GET['startDate']) && isset($_GET['endDate'])) {
                printBranchFineInformation($_GET['startDate'], $_GET['endDate']);
            }
            break;
        default:
            echo "Invalid function selected.";
            break;
    }
} else {
    echo "No function selected.";
}

?>
