<?php 
    session_start();

    if (isset($_SESSION['UserID'])){
        if ($_SESSION['UserID'] != "" && $_SESSION['UserID'] != null){
            if ($_SESSION['UserType'] != "Admin"){
                header('Location: clientCatalogView.php');
                exit; 
            }else{
                header('Location: BooksDisplay.php');
                exit; 
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Local Bookstore</title>
    <!-- MDB Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.3.0/mdb.min.css">

    <style>
        /* General Styles */
        html, body {
            height: 100%;
            margin: 0;
            background-color: #f4f4f4;
            font-family: 'Roboto', sans-serif;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
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

        /* Card Styling */
        .card-body {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .card-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #2c3e50;
        }
        .form-text {
            font-size: 0.9rem;
            color: #7f8c8d;
            text-align: center;
        }

        /* Footer */
        .footer {
            background-color: #34495e;
            color: white;
            padding: 15px;
            text-align: center;
        }

        /* Button Styles */
        .btn-custom {
            background-color: #2c3e50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }
        .btn-custom:hover {
            background-color: #34495e;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg">
    <a class="navbar-brand mx-auto" href="#">Local Bookstore</a>
</nav>

<!-- Registration Form -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center">Create Your Account</h5>
                    <form method="post" action="../Functions/mainFunctions/AddCustomer.php">
                        <div class="mb-3">
                            <label for="firstName" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="firstName" name="firstName" required>
                        </div>
                        <div class="mb-3">
                            <label for="lastName" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="lastName" name="lastName" required>
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="text" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="tel" class="form-control" id="phone" name="phone" required>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" name="Address" required>
                        </div>
                        <div class="mb-3">
                            <label for="dateOfBirth" class="form-label">Date of Birth</label>
                            <input type="date" class="form-control" id="dateOfBirth" name="dateOfBirth" required>
                        </div>
                        <button type="submit" class="btn btn-custom w-100">Register</button>
                    </form>
                    <p class="form-text mt-3">Already have an account? <a href="LoginPage.php" class="text-primary">Sign in</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<footer class="footer">
    <p>&copy; 2023 Local Bookstore</p>
</footer>

<script>
    const ServerMsg = "<?php 
        if (isset($_SESSION['ServerMessage'])){
            if ($_SESSION['ServerMessage'] != "" && $_SESSION['ServerMessage'] != null){
                echo $_SESSION['ServerMessage'];
                unset($_SESSION['ServerMessage']);
            }else{
                echo "";
            }
        }else{
            echo "";
        }
    ?>"

    if (ServerMsg != ""){
        console.warn(ServerMsg);
        alert(ServerMsg);
    }
</script>

</body>
</html>
