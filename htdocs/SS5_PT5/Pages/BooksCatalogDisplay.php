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

    <!-- Container for displaying books -->
    <div class="container">
        <div class="row row-cols-1 row-cols-md-3 g-4">
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
                    b.Image_Path
                FROM
                    Employees e
                JOIN EmployeeBooks eb ON e.TaxpayerID = eb.TaxpayerID
                JOIN Books b ON eb.ISBN = b.ISBN
                ORDER BY b.Title DESC
                ";

                $GetBooksListQuery = $connection -> query($GetBooksList);

                while ($Row = $GetBooksListQuery -> fetch_assoc()){
                    $FinalizedBookCoverPngPath = null;

                    if ($Row['Image_Path'] != null){
                        $BookCoverPngPathFile = htmlspecialchars($Row['Image_Path']);
                        $FinalizedBookCoverPngPath = "../Books_Cover/" . basename($BookCoverPngPathFile);
                    }
                    echo '
                        <div class="col">
                            <div class="card">
                                <img src="'. (!empty($FinalizedBookCoverPngPath) ? $FinalizedBookCoverPngPath : 'https://via.placeholder.com/150') .'" class="card-img-top img-fluid" alt="Book Image" style="object-fit: contain; max-height: 250px;">
                                <div class="card-body">
                                    <h5 class="card-title">'. $Row['Title'] .'</h5>
                                    <p class="card-text">Author: '. $Row['Pseudonym'] .'</p>
                                    <p class="card-text">Year: '. $Row['Year'] .'</p>
                                    <p class="card-text">Publisher: '. $Row['Publisher'] .'</p>
                                </div>
                            </div>
                        </div>';
                }
            ?>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer mt-5">
        <p>&copy; 2024 Local Bookstore. All Rights Reserved.</p>
    </div>

    <!-- Bootstrap 5 JS and MDB JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/mdb-ui-kit@5.3.0/dist/js/mdb.min.js"></script>
</body>

</html>
