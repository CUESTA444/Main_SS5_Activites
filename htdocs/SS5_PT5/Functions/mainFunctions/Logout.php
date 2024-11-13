<?php 
    session_start();
    session_unset();
    session_destroy();

    $_SESSION['ServerMessage'] = "Successfully Logout!";
    header('Location: ../../Pages/LoginPage.php');
    exit;
?>