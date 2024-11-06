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
        <h3 class="text-center mb-4">Add New Book</h3>

        <form action="../Functions/mainFunctions/AddBook.php" method="POST" enctype="multipart/form-data" class="p-4 shadow-sm rounded" style="background-color: #f9f9f9;">
            <div class="mb-3">
                <label for="isbn" class="form-label">ISBN</label>
                <input type="text" class="form-control" id="isbn" name="isbn" required>
            </div>
            
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>

            <div class="mb-3">
                <label for="year" class="form-label">Year</label>
                <input type="number" class="form-control" id="year" name="year" min="1000" max="9999" placeholder="YYYY" required>
            </div>

            <div class="mb-3">
                <label for="publisher" class="form-label">Publisher</label>
                <input type="text" class="form-control" id="publisher" name="publisher" required>
            </div>

            <!-- File Input -->
            <div class="mb-3">
                <label for="bookCover" class="form-label">Book Cover</label>
                <input type="file" class="form-control" id="bookCover" name="bookCover" accept=".png, .jpg, .jpeg">
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-success">Update</button>
            </div>
        </form>
    </div>

    <!-- Footer -->
    <div class="footer mt-5">
        <p class="text-center">&copy; 2024 Local Bookstore. All Rights Reserved.</p>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- Bootstrap 5 JS and MDB JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/mdb-ui-kit@5.3.0/dist/js/mdb.min.js"></script>

    <script>
        const MAX_FILE_SIZE = 2 * 1024 * 1024;

        $('#bookCover').on('change', function(event){
            const file = event.target.files[0];

            if (file){
                if (file.size > MAX_FILE_SIZE){
                    alert("The file size is too large. Please select a file smaller than 2 MB.");
                }
            }
        })
    </script>
</body>
</html>
