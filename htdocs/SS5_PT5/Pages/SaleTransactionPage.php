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

    $CustomerID = $_GET['customer_id'];
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
    <div class="container mt-4">
        <h3 class="text-center mb-4"> Sales Transaction </h3>

        <form action="../Functions/mainFunctions/AddSales.php" method="POST" class="p-4 shadow-sm rounded" style="background-color: #f9f9f9;">
            <div class="mb-3">
                <label for="isbn" class="form-label">Choose Book</label>
                <select class="form-control" id="isbn" name="isbn" required>
                    <option value="">Choose a Book</option>
                        <?php
                            // Fetch employees from the database
                            $BooksQuery = "SELECT * FROM Books JOIN EmployeeBooks ON Books.ISBN = EmployeeBooks.ISBN ORDER BY Books.Title DESC";
                            $BooksResult = $connection->query($BooksQuery);

                            // Loop through each employee and create an option for the select dropdown
                            while ($Row = $BooksResult->fetch_assoc()) {
                                // Display the employee name in the dropdown
                                echo '<option value="' . htmlspecialchars($Row['ISBN']) . '">'
                                    . htmlspecialchars($Row['Title']) . '</option>';
                            }
                        ?>
                </select>
            </div>
            
            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity</label>
                <input type="number" class="form-control" id="quantity" name="quantity" min="1" max="9999" placeholder="amount" required>
            </div>

            <input type="hidden" class="form-control" id="customerID" name="customerID" value="<?php echo $CustomerID; ?>">

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-success">Place Order</button>
            </div>
        </form>
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
