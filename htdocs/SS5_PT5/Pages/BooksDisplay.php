<?php 
    session_start();
    include '../Functions/Connection.php';

    $UserID = "";
    if (isset($_SESSION['UserID'])){
        if ($_SESSION['UserID'] != "" && $_SESSION['UserID'] != null){
            if ($_SESSION['UserType'] != "Admin"){
                header('Location: clientCatalogView.php');
                exit; 
            }else{
                $UserID = $_SESSION['UserID'];
            }
        }else{
            header('Location: LoginPage.php');
            exit;
        }
    }else{
        header('Location: LoginPage.php');
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books - Local Bookstore</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- MDB Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/mdb-ui-kit@5.3.0/dist/css/mdb.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="../CSS/BooksDisplayDesign.css">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="BooksCatalogDisplay.php">Local Bookstore</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="BooksCatalogDisplay.php">Catalog View</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="SaleTransactionDisplay.php">Sales Transaction</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="BooksDisplay.php">Books</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="CustomerDisplay.php">Customers</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="EmployeeDisplay.php">Employees</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../Functions/mainFunctions/Logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Container for displaying books in a table -->
    <div class="container mt-4">
        <h3 class="text-center">Books List</h3>
        <div class="d-flex justify-content-end align-items-center mb-3">
            <!-- Add New Customer Button -->
            <a href="AddBooksPage.php" class="add-button">Add Book</a>
        </div>

        <!-- Scrollable Table Container -->
        <div class="table-container">
            <!-- Table for displaying books -->
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Book Title</th>
                        <th scope="col">Author</th>
                        <th scope="col">Year</th>
                        <th scope="col">Publisher</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Contents -->
                    <?php
                        $GetBooksList = "SELECT
                            e.FirstName,
                            e.LastName,
                            b.Title,
                            b.Year,
                            b.Publisher,
                            e.Pseudonym,
                            b.ISBN,
                            eb.TaxpayerID
                        FROM
                            Books b
                        LEFT JOIN EmployeeBooks eb ON eb.ISBN = b.ISBN
                        LEFT JOIN Employees e ON e.TaxpayerID = eb.TaxpayerID
                        ORDER BY b.Title DESC
                        ";

                        $GetBooksListQuery = $connection -> query($GetBooksList);
                        
                        while ($Row = $GetBooksListQuery -> fetch_assoc()){
                            $FinalizedAuthor = $Row['Pseudonym'];
                            $FinalizeAuthorID = $Row['TaxpayerID'];
                           
                            echo '<tr>
                                    <td>'. htmlspecialchars($Row['Title']) .'</td>
                                    <td>'. $FinalizedAuthor .'</td>
                                    <td>'. htmlspecialchars($Row['Year'] ).'</td>
                                    <td>'. htmlspecialchars($Row['Publisher']) .'</td>
                                    <td>
                                        <a href="EditBooksPage.php?isbn='. urlencode($Row['ISBN']) .'&authorID='. $FinalizeAuthorID .'" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="../Functions/mainFunctions/RemoveBook.php?isbn='. urlencode($Row['ISBN']) .'" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure?\')">Delete</a>
                                    </td>
                                </tr>';
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer mt-5">
        <p class="text-center">&copy; 2024 Local Bookstore. All Rights Reserved.</p>
    </div>

    <!-- Bootstrap 5 JS and MDB JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/mdb-ui-kit@5.3.0/dist/js/mdb.min.js"></script>
</body>

</html>
