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
// Function to print the top N most frequent borrowers in branch I and the number of books each has borrowed
function topNBorrowersInBranch($N, $branchId) {
    global $conn;

    $sql = "SELECT Reader.RId, Reader.Name, COUNT(Borrowing.BNum) AS num_books_borrowed
            FROM Borrowing
            INNER JOIN Reader ON Borrowing.RId = Reader.RId
            INNER JOIN Copy ON Borrowing.CopyId = Copy.CopyId
            WHERE Copy.BId = $branchId
            GROUP BY Reader.RId, Reader.Name
            ORDER BY num_books_borrowed DESC
            LIMIT $N";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "Reader ID: " . $row["RId"] . ", Name: " . $row["Name"] . ", Books Borrowed: " . $row["num_books_borrowed"] . "<br>";
        }
    } else {
        echo "No results found";
    }
}

// Function to print the top N most frequent borrowers in the library and the number of books each has borrowed
function topNBorrowersInLibrary($N) {
    global $conn;

    $sql = "SELECT Reader.RId, Reader.Name, COUNT(Borrowing.BNum) AS num_books_borrowed
            FROM Borrowing
            INNER JOIN Reader ON Borrowing.RId = Reader.RId
            GROUP BY Reader.RId, Reader.Name
            ORDER BY num_books_borrowed DESC
            LIMIT $N";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "Reader ID: " . $row["RId"] . ", Name: " . $row["Name"] . ", Books Borrowed: " . $row["num_books_borrowed"] . "<br>";
        }
    } else {
        echo "No results found";
    }
}

// Function to print the N most borrowed books in branch I
function mostBorrowedBooksInBranch($N, $branchId) {
    global $conn;

    // SQL query to get the N most borrowed books in the specified branch
    $sql = "SELECT Document.Title, COUNT(Borrowing.BNum) AS num_borrowed
            FROM Borrowing
            INNER JOIN Copy ON Borrowing.CopyId = Copy.CopyId
            INNER JOIN Document ON Copy.DId = Document.DId
            WHERE Copy.BId = $branchId
            GROUP BY Document.Title
            ORDER BY num_borrowed DESC
            LIMIT $N";

    // Execute the query
    $result = $conn->query($sql);

    // Check if the query executed successfully
    if ($result === FALSE) {
        // If there was an error in the query, handle it
        echo "Error: " . $conn->error;
    } else {
        // If the query was successful, check if any rows were returned
        if ($result->num_rows > 0) {
            // If rows were returned, display the results
            while ($row = $result->fetch_assoc()) {
                echo "Book Title: " . $row["Title"] . ", Borrowed Count: " . $row["num_borrowed"] . "<br>";
            }
        } else {
            // If no rows were returned, display a message indicating no results found
            echo "No results found";
        }
    }
}

// Function to print the N most borrowed books in the library
function mostBorrowedBooksInLibrary($N) {
    global $conn;

    $sql = "SELECT Document.Title, COUNT(Borrowing.BNum) AS num_borrowed
            FROM Borrowing
            INNER JOIN Copy ON Borrowing.CopyId = Copy.CopyId
            INNER JOIN Document ON Copy.DId = Document.DId
            GROUP BY Document.Title
            ORDER BY num_borrowed DESC
            LIMIT $N";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "Book Title: " . $row["Title"] . ", Borrowed Count: " . $row["num_borrowed"] . "<br>";
        }
    } else {
        echo "No results found";
    }
}

// Function to print the 10 most popular books of a given year in the library
function mostPopularBooksByYear($year) {
    global $conn;

    $sql = "SELECT Document.Title, COUNT(Borrowing.BNum) AS num_borrowed
            FROM Borrowing
            INNER JOIN Copy ON Borrowing.CopyId = Copy.CopyId
            INNER JOIN Document ON Copy.DId = Document.DId
            WHERE YEAR(Borrowing.BorrowDate) = $year
            GROUP BY Document.Title
            ORDER BY num_borrowed DESC
            LIMIT 10";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "Book Title: " . $row["Title"] . ", Borrowed Count: " . $row["num_borrowed"] . "<br>";
        }
    } else {
        echo "No results found";
    }
}

// Function to print branch Id, name, and average fine paid by borrowers for documents borrowed from this branch during a given period
function printBranchFineInformation($startDate, $endDate) {
    global $conn;

    $sql = "SELECT Branch.BId, Branch.Name, AVG(Fine.FineAmount) AS avg_fine
            FROM Fine
            INNER JOIN Borrowing ON Fine.BNum = Borrowing.BNum
            INNER JOIN Copy ON Borrowing.CopyId = Copy.CopyId
            INNER JOIN Branch ON Copy.BId = Branch.BId
            WHERE Borrowing.BorrowDate BETWEEN '$startDate' AND '$endDate'
            GROUP BY Branch.BId, Branch.Name";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "Branch ID: " . $row["BId"] . ", Branch Name: " . $row["Name"] . ", Average Fine: " . $row["avg_fine"] . "<br>";
        }
    } else {
        echo "No results found";
    }
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
                editDocumentCopy($_POST['CopyId'], $_POST['DId'], $_POST['BId'], $_POST['Position'], $_POST['Status']);
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
