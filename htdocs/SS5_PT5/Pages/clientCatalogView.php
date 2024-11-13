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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Local Bookstore</title>
    <!-- MDB Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.3.0/mdb.min.css">

    <style>
        /* General Styles */
        html, body {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
            font-family: 'Roboto', sans-serif;
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

        /* Catalog Section */
        .catalog {
            padding: 40px 20px;
            flex-grow: 1; /* Expands to fill remaining space */
        }
        .catalog h2 {
            color: #2c3e50;
            font-size: 1.75rem;
            font-weight: bold;
            text-align: center;
            margin-bottom: 30px;
        }
        .card {
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: scale(1.05); /* Slightly enlarges the card */
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); /* Adds a larger shadow */
        }
        .card-title {
            font-size: 1.25rem;
            color: #2c3e50;
        }
        .card-text {
            font-size: 1rem;
            color: #7f8c8d;
        }

        /* Footer */
        .footer {
            background-color: #34495e;
            color: white;
            padding: 15px;
            text-align: center;
            margin-top: auto; /* Ensures footer sticks to the bottom */
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <a class="navbar-brand" href="#">Local Bookstore</a>
        <span class="navbar-text">
            Logged in as: <strong>
                            <?php if($UserID != ""){echo htmlspecialchars($GetUserInfos_Result['FirstName']) . ' ' . htmlspecialchars($GetUserInfos_Result['LastName']);} ?>
                        </strong>
            <a href="../Functions/mainFunctions/Logout.php" class="btn btn-light btn-sm ms-3">Logout</a>
        </span>
    </nav>

    <!-- Catalog Section -->
    <div class="container catalog">
        <h2>Our Book Collection</h2>
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
                        <a href="client_purchasePage.php?bookISBN=' . htmlspecialchars($Row['ISBN']) .'">
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
                            </div>
                        </a>';
                }
            ?>
        </div>
    </div>

    <footer class="footer">
        <p>&copy; 2023 Local Bookstore</p>
    </footer>

</body>
</html>
