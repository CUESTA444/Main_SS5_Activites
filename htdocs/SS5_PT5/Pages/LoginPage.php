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
    <title>Login - Local Bookstore</title>
    <!-- MDB Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.3.0/mdb.min.css">

    <style>
        /* Reuse styles from the registration page for consistency */
        html, body {
            height: 100%;
            margin: 0;
            background-color: #f4f4f4;
            font-family: 'Roboto', sans-serif;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .navbar {
            background-color: #34495e;
            padding: 10px 20px;
        }
        .navbar-brand {
            color: white !important;
            font-size: 2rem;
            font-weight: bold;
        }
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
        .footer {
            background-color: #34495e;
            color: white;
            padding: 15px;
            text-align: center;
        }
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

<!-- Login Form -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center">Welcome Back!</h5>
                    <form method="post" action="../Functions/mainFunctions/Login.php">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-custom w-100">Login</button>
                    </form>
                    <p class="form-text mt-3">Don’t have an account? <a href="RegisterPage.php" class="text-primary">Sign up</a></p>
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
            if ($_SESSION['ServerMessage'] != ""){
                echo $_SESSION['ServerMessage'];
                unset($_SESSION['ServerMessage']);
            }else{
                //echo "";
            }
        }else{
            //echo "";
        }
    ?>";

    if (ServerMsg != ""){
        console.warn(ServerMsg);
        alert(ServerMsg);
    }
</script>

</body>
</html>
