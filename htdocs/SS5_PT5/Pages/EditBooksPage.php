<?php 
    session_start();
    include '../Functions/Connection.php';

    $ISBN = $_GET['isbn'];
    $currentAuthorID = $_GET['authorID'];

    $BookInformationResult = null;
    $EmployeeTaxPayerID = null;
    $EmployeeInformation = null;

    if ($ISBN){
        $GetBookInformation = "SELECT * FROM Books JOIN EmployeeBooks eb ON Books.ISBN = eb.ISBN WHERE Books.ISBN = '$ISBN'";
        $BookInformationQuery = $connection -> query($GetBookInformation);
        $BookInformationResult = $BookInformationQuery -> fetch_assoc();

        if ($BookInformationResult == null || $BookInformationResult == ""){
            $GetBookInformation = "SELECT * FROM Books WHERE ISBN = '$ISBN'";
            $BookInformationQuery = $connection -> query($GetBookInformation);
            $BookInformationResult = $BookInformationQuery -> fetch_assoc();
        }else{
            $EmployeeTaxPayerID = $BookInformationResult['TaxpayerID'];

            $GetEmployeeInformation = "SELECT * FROM Employees WHERE TaxpayerID = '$EmployeeTaxPayerID'";
            $EmployeeInformationQuery = $connection -> query($GetEmployeeInformation);
            $EmployeeInformation = $EmployeeInformationQuery -> fetch_assoc(); 
        }
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
                </ul>
            </div>
        </div>
    </nav>  

    <!-- Contents -->
    <div class="container mt-4">
        <h3 class="text-center mb-4"> Update Book </h3>

        <form action="../Functions/mainFunctions/UpdateBook.php" method="POST" enctype="multipart/form-data" class="p-4 shadow-sm rounded" style="background-color: #f9f9f9;">
            <div class="mb-3">
                <label for="isbn" class="form-label">ISBN</label>
                <input type="text" class="form-control" id="isbn" name="isbn" value="<?php echo htmlspecialchars($BookInformationResult['ISBN']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="author" class="form-label">Choose Author <?php if (!empty($EmployeeInformation)){echo  ', Current Author: ( '.$EmployeeInformation['FirstName'] . ' ' . $EmployeeInformation['LastName'] . ' )';} ?></label>
                <select class="form-control" id="author" name="author">
                    <option value="">Choose an Author</option>
                    <?php
                        // Fetch employees from the database
                        $employeeQuery = "SELECT TaxpayerID, FirstName, LastName FROM Employees ORDER BY LastName";
                        $employeeResult = $connection->query($employeeQuery);

                        $currentAuthorID = isset($currentAuthorID) ? $currentAuthorID : ''; // Replace this with the actual value

                        // Loop through each employee and create an option for the select dropdown
                        while ($employee = $employeeResult->fetch_assoc()) {
                            $selected = ($employee['TaxpayerID'] == $currentAuthorID) ? 'selected' : '';

                            // Display the employee name in the dropdown
                            echo '<option value="' . htmlspecialchars($employee['TaxpayerID']) . '">'
                                . htmlspecialchars($employee['FirstName'] . ' ' . $employee['LastName']) . 
                                '</option>';
                        }
                    ?>
                    <option value="Removed"> Removed Author </option>
                </select>
            </div>
            
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($BookInformationResult['Title']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="publisher" class="form-label">Publisher</label>
                <input type="text" class="form-control" id="publisher" name="publisher" value="<?php echo htmlspecialchars($BookInformationResult['Publisher']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="year" class="form-label">Year</label>
                <input type="number" class="form-control" id="year" name="year" min="1000" max="9999" placeholder="YYYY" value="<?php echo htmlspecialchars($BookInformationResult['Year']); ?>" required>
            </div>

            <!-- File Input -->
            <div class="mb-3">
                <label for="bookCover" class="form-label">Book Cover</label>
                <input type="file" class="form-control" id="bookCover" name="bookCover" accept=".png, .jpg, .jpeg">
            </div>

            <input type="hidden" class="form-control" id="isbn" name="isbn" value="<?php echo $ISBN; ?>">

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
