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
    <title>Employees - Local Bookstore</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- MDB Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/mdb-ui-kit@5.3.0/dist/css/mdb.min.css" rel="stylesheet">

    <!-- Custom Styles -->
    <link rel="stylesheet" href="../CSS/SaleTransactionDisplayDesign.css">
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

    <!-- Contents -->
    <div class="container mt-5">
    <h3 class="text-center mb-5">Transaction List</h3>
        <!-- Scrollable Table Container -->
        <div class="table-container">
            <!-- Table for displaying employees -->
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Transaction ID</th>
                        <th scope="col">Customer</th>
                        <th scope="col">Purchase Date</th>
                        <th scope="col">Books Purchased</th>
                        <th scope="col">Total Books Purchased</th>
                        <th scope="col">Employee ID</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $GetSalesRecord = "SELECT
                            c.FirstName,
                            c.LastName,
                            sb.SaleID,
                            st.EmployeeTaxpayerID,
                            st.DateTime,
                            st.TotalBooks,
                            st.Receipt,
                            e.EmployeeID,
                            sb.ISBN
                        FROM
                            SalesTransaction st
                        JOIN Customers c ON st.CustomerID = c.CustomerID
                        JOIN SaleBooks sb on st.SaleID = sb.SaleID
                        JOIN Employees e on st.EmployeeTaxpayerID = e.TaxpayerID
                        ORDER BY st.DateTime DESC
                        ";

                        $GetSalesRecord_Query = $connection -> query($GetSalesRecord);
                        
                        if ($GetSalesRecord_Query -> num_rows > 0){
                            while ($Row = $GetSalesRecord_Query -> fetch_assoc()){
                                $row_ISBN = $Row['ISBN'];
                                $Book_Purchased = "SELECT Title FROM Books WHERE ISBN = '$row_ISBN'";
                                $Book_Purchased_query = $connection -> query($Book_Purchased);
                                $Book_Purchased_Result = $Book_Purchased_query -> fetch_assoc();
                                echo '<tr>
                                        <td>'. htmlspecialchars($Row['SaleID']) .'</td>
                                        <td>'. htmlspecialchars($Row['FirstName']) . ' ' . htmlspecialchars($Row['LastName']) .'</td>
                                        <td>'. htmlspecialchars($Row['DateTime']).'</td>
                                        <td>'. htmlspecialchars($Book_Purchased_Result['Title']).'</td>
                                        <td>'. htmlspecialchars($Row['TotalBooks']) .'</td>
                                        <td>'. htmlspecialchars($Row['EmployeeID']) .'</td>
                                    </tr>';
                            }
                        }else{
                            //echo "Empty: No Sales";
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
