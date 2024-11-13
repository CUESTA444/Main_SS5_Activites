<?php
    session_start();
    include '../Functions/Connection.php';

    $UserID = "";
    if (isset($_SESSION['UserID'])){
        if ($_SESSION['UserID'] != "" && $_SESSION['UserID'] != null){
            if ($_SESSION['UserType'] != "Admin"){
                $UserID = $_SESSION['UserID'];
            }else{
                header('Location: BooksDisplay.php');
                exit; 
            }
        }else{
            header('Location: LoginPage.php');
            exit;
        }
    }else{
        header('Location: LoginPage.php');
        exit;
    }

    // Get UserInfo
    $GetUserInfos = "SELECT * FROM Customers WHERE CustomerID = '$UserID'";
    $GetUserInfos_Query = $connection -> query($GetUserInfos);
    $GetUserInfos_Result = $GetUserInfos_Query -> fetch_assoc();

    $RequestedISBN = $_GET['bookISBN'];

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
                WHERE b.ISBN = '$RequestedISBN'
                ";

    $GetBooksList_Query = $connection -> query($GetBooksList);
    $GetBooksList_Result = $GetBooksList_Query -> fetch_assoc();

    $FinalizedBookCoverPngPath = null;

    if ($GetBooksList_Result['Image_Path'] != null){
        $BookCoverPngPathFile = htmlspecialchars($GetBooksList_Result['Image_Path']);
        $FinalizedBookCoverPngPath = "../Books_Cover/" . basename($BookCoverPngPathFile);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Details - Local Bookstore</title>
    <!-- MDB Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.3.0/mdb.min.css">

    <style>
        /* General Styles */
        body {
            background-color: #f4f4f4;
            font-family: 'Roboto', sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }

        /* Navbar */
        .navbar {
            background-color: #34495e;
            padding: 10px 20px;
        }
        .navbar-brand {
            color: white !important;
            font-size: 2rem;
            font-weight: bold;
        }
        .navbar-text {
            color: white !important;
            font-size: 1rem;
            margin-left: auto;
        }
        /* Book Details Section */
        .book-details {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .book-image {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }
        .book-title {
            font-size: 1.75rem;
            color: #2c3e50;
            font-weight: bold;
            margin-top: 20px;
        }
        .book-author {
            font-size: 1.25rem;
            color: #7f8c8d;
            margin-bottom: 15px;
        }
        .book-description {
            font-size: 1rem;
            color: #7f8c8d;
            margin-bottom: 20px;
        }

        /* Purchase Section */
        .purchase-section {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .quantity-input {
            width: 80px;
            padding: 5px;
            text-align: center;
            font-size: 1rem;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .purchase-button {
            background-color: #34495e;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
        }
        .purchase-button:hover {
            background-color: #2c3e50;
        }

        /* Footer */
        .footer {
            background-color: #34495e;
            color: white;
            padding: 15px;
            text-align: center;
            margin-top: auto;
        }
    </style>

</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg">
    <a class="navbar-brand" href="#">Local Bookstore</a>
    <span class="navbar-text">
        Logged in as: <strong>
                <?php if($UserID != ""){echo htmlspecialchars($GetUserInfos_Result['FirstName']) . ' ' . htmlspecialchars($GetUserInfos_Result['LastName']);} ?>
            </strong>
        <a href="logout.php" class="btn btn-light btn-sm ms-3">Logout</a>
    </span>
</nav>

<!-- Book Details Section -->
<div class="container book-details">
    <?php 
        echo '<img src="'. (!empty($FinalizedBookCoverPngPath) ? $FinalizedBookCoverPngPath : 'https://via.placeholder.com/150') .'" class="card-img-top img-fluid" alt="Book Image" style="object-fit: contain; max-height: 250px;">';
    ?>
    <h2 class="book-title"><?php echo htmlspecialchars($GetBooksList_Result['Title']) ?></h2>
    <p class="book-author">by: <?php echo htmlspecialchars($GetBooksList_Result['FirstName'] . ' ' . $GetBooksList_Result['LastName']) ?></p>
    <p class="book-description">Publisher: <?php echo htmlspecialchars($GetBooksList_Result['Publisher']) ?></p>
    
    <!-- Purchase Section -->
    <div class="purchase-section">
        <form action="AddSales.php" method="post">
            <label for="quantity" class="quantity-label">Quantity:</label>
            <input type="number" id="quantity" name="quantity" value="1" min="1" class="quantity-input">

            <input type="hidden" name="customerID" value="<?php echo $UserID; ?>">
            <input type="hidden" name="isbn" value="<?php echo $GetBooksList_Result['ISBN']; ?>">
            
            <button class="purchase-button" type="submit">Purchase</button>
        </form>
    </div>
</div>

<!-- Footer -->
<footer class="footer">
    <p>&copy; 2023 Local Bookstore</p>
</footer>

<script>
    var QuantityInput = document.getElementById('quantity');

    QuantityInput.addEventListener('input', function(event){
        if (QuantityInput.value == 0 || QuantityInput.value <= 0){
            QuantityInput.value = 1;
        }else{
            if (QuantityInput.value > 999){
                QuantityInput.value = 999;
            }
        }
    })
</script>

</body>
</html>
