<?php 
    session_start();
    include '../Connection.php';

    if (isset($_GET['customer_id'])){
        $CustomerID = $_GET['customer_id'];

        $DeleteCustomer = "DELETE FROM Customers WHERE CustomerID = '$CustomerID'";
        $DeleteCustomerQuery = $connection -> query($DeleteCustomer);

        if ($DeleteCustomerQuery){
            header('Location: ../../Pages/CustomerDisplay.php');
            exit;
        }else{
            echo ("Error Occurred");
        }
    }
?>