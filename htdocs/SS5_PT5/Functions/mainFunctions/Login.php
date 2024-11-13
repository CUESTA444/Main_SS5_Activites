<?php 
    session_start();
    include '../Connection.php';

    if (isset($_POST)){
        $username = $_POST['username'];
        $Password = $_POST['password'];

        // Check First Administrator
        $GetAdminInformation = "SELECT * FROM admins WHERE adminUsername = '$username' AND adminPass = '$Password'";
        $GetAdminInformation_Query = $connection -> query($GetAdminInformation);
        $GetAdminInformation_Result = $GetAdminInformation_Query -> fetch_assoc();

        if ($GetAdminInformation_Query -> num_rows > 0){
            $_SESSION['UserID'] = $GetAdminInformation_Result['adminID'];
            $_SESSION['UserType'] = "Admin";

            // Send Back
            header('Location: ../../Pages/BooksDisplay.php');
            exit;
        }

        $GetCustomersInformation = "SELECT * FROM Customers WHERE Username = '$username' AND password = '$Password'";
        $GetCustomersInformation_Query = $connection -> query($GetCustomersInformation);
        $GetCustomersInformation_Result = $GetCustomersInformation_Query -> fetch_assoc();

        if ($GetCustomersInformation_Query -> num_rows > 0){
            $_SESSION['UserID'] = $GetCustomersInformation_Result['CustomerID'];
            $_SESSION['UserType'] = "Client";

            // Send Back
            header('Location: ../../Pages/clientCatalogView.php');
            exit;
        }else{
            // Add here some notifying message that will be shown on client..
            $_SESSION['ServerMessage'] = "Password or Username is incorrect!";
            header('Location: ../../Pages/LoginPage.php');
            exit;
        }
    }
?>