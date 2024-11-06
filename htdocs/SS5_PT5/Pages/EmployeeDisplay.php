<?php 
    session_start();
    include '../Functions/Connection.php';

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
    <link rel="stylesheet" href="../CSS/EmployeesDisplay.css">
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

    <!-- Container for displaying employees in a table -->
    <div class="container mt-4">
        <h3 class="text-center">Employees List</h3>
        <div class="d-flex justify-content-end align-items-center mb-3">
            <!-- Add New Customer Button -->
            <a href="AddEmployeePage.php" class="add-button">Add Employee</a>
        </div>

        <!-- Scrollable Table Container -->
        <div class="table-container">
            <!-- Table for displaying employees -->
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Employee Name</th>
                        <th scope="col">Pseudonym</th>
                        <th scope="col">Date of Birth</th>
                        <th scope="col">Assigned Book</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Contents -->
                    <?php
                        $EmployeeList = "SELECT 
                            e.FirstName, 
                            e.LastName,
                            e.Pseudonym,
                            e.DateOfBirth,
                            e.EmployeeID,
                            COUNT(CASE WHEN eb.ISBN IS NOT NULL THEN 1 END) AS BookCount
                        FROM Employees e
                        LEFT JOIN EmployeeBooks eb ON e.TaxpayerID = eb.TaxpayerID
                        LEFT JOIN Books b ON eb.ISBN = b.ISBN
                        GROUP BY e.TaxpayerID
                        ORDER BY e.LastName ASC";

                        $EmployeeListQuery = $connection -> query($EmployeeList);

                        while ($Row = $EmployeeListQuery -> fetch_assoc()){
                            $FinalizedBookCounts = "";
                            if ($Row['BookCount'] != null && $Row['BookCount'] != "" && $Row['BookCount'] != 0){
                                $FinalizedBookCounts = htmlspecialchars($Row['BookCount']);
                            }else{
                                $FinalizedBookCounts = "0";
                            }

                            echo '<tr>
                                    <td>'. htmlspecialchars($Row['FirstName']) . ' ' . htmlspecialchars($Row['LastName']) .'</td>
                                    <td>'. htmlspecialchars($Row['Pseudonym']) .'</td>
                                    <td>'. htmlspecialchars($Row['DateOfBirth'] ).'</td>
                                    <td>'. $FinalizedBookCounts .'</td>
                                     <td>
                                        <a href="EditEmployeePage.php?employee_id='. $Row['EmployeeID'] .'" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="../Functions/mainFunctions/RemoveEmployee.php?employee_id='. $Row['EmployeeID'] .'" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure?\')">Delete</a>
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
