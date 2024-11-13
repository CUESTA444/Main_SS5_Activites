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
    <title>Customers - Local Bookstore</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- MDB Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/mdb-ui-kit@5.3.0/dist/css/mdb.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="../CSS/CustomerDisplayDesign.css">
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

    <!-- Container for displaying customers in a table -->
    <div class="container mt-4">
        <h3 class="text-center">Customers List</h3>
        <div class="d-flex justify-content-end align-items-center mb-3">
            <!-- Add New Customer Button -->
            <a href="AddCustomerPage.php" class="add-button">Add Customer</a>
        </div>

        <!-- Scrollable Table Container -->
        <div class="table-container">
            <!-- Table for displaying customers -->
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Customer Name</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Address</th>
                        <th scope="col">Date of Birth</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $GetCustomerInformation = "SELECT * FROM Customers ORDER BY LastName ASC";
                        $GetCustomerInfoQuery = $connection -> query($GetCustomerInformation);

                        while ($Row = $GetCustomerInfoQuery -> fetch_assoc()){
                            echo '<tr>
                                    <td>'. htmlspecialchars($Row['FirstName']) . ' ' . htmlspecialchars($Row['LastName']) .'</td>
                                    <td>'. htmlspecialchars($Row['Phone']) .'</td>
                                    <td>'. htmlspecialchars($Row['Address']) .'</td>
                                    <td>'. htmlspecialchars($Row['DateOfBirth']) .'</td>
                                    <td>
                                        <a href="EditCustomerPage.php?customer_id='. $Row['CustomerID'] .'" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="../Functions/mainFunctions/RemoveCustomer.php?customer_id='. $Row['CustomerID'] .'" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure?\')">Delete</a>
                                        <a href="SaleTransactionPage.php?customer_id='. $Row['CustomerID'] .'" class="btn btn-success btn-sm" >Place Order</a>
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