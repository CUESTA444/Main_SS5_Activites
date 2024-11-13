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

    $EmployeeID = $_GET['employee_id'];

    $GetEmployeeInformation = "SELECT * FROM Employees WHERE EmployeeID = '$EmployeeID'";
    $EmployeeInformationQuery = $connection -> query($GetEmployeeInformation);
    $EmployeeInfoResult = $EmployeeInformationQuery -> fetch_assoc();
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
        <h3 class="text-center mb-4">Update Employee</h3>

        <form action="../Functions/mainFunctions/UpdateEmployee.php" method="POST" class="p-4 shadow-sm rounded" style="background-color: #f9f9f9;">
            <div class="mb-3">
                <label for="Taxpayer_ID" class="form-label">Taxpayer ID</label>
                <input type="text" class="form-control" id="Taxpayer_ID" name="Taxpayer_ID" value="<?php echo $EmployeeInfoResult['TaxpayerID']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="firstName" class="form-label">First Name</label>
                <input type="text" class="form-control" id="firstName" name="firstName" value="<?php echo $EmployeeInfoResult['FirstName']; ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="lastName" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="lastName" name="lastName" value="<?php echo $EmployeeInfoResult['LastName']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="pseudonym" class="form-label">Pseudonym</label>
                <input type="text" class="form-control" id="pseudonym" name="pseudonym" value="<?php echo $EmployeeInfoResult['Pseudonym']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="dateOfBirth" class="form-label">Date of Birth</label>
                <input type="date" class="form-control" id="dateOfBirth" value="<?php echo $EmployeeInfoResult['DateOfBirth']; ?>" name="dateOfBirth" required>
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" name="address" rows="3" value="<?php echo $EmployeeInfoResult['Address']; ?>" required></input>
            </div>

            <input type="hidden" class="form-control" id="employee_id" name="employee_id" value="<?php echo $EmployeeID; ?>">

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-success">Update</button>
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
