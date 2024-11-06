<?php 
    session_start();
    include '../Connection.php';

    if (isset($_POST)){
        $CustomerID = $_POST['customer_id'];
        $FirstName = $_POST['firstName'];
        $LastName = $_POST['lastName'];
        $DateOfBirth = $_POST['dateOfBirth'];
        $Address = $_POST['Address'];
        $Phone = $_POST['phone'];

        $UpdateCustomer = "UPDATE Customers SET FirstName = ?, LastName = ?, Phone = ?, Address = ?, DateOfBirth = ? WHERE CustomerID = '$CustomerID'";
        $UpdateCustomerQuery = $connection -> prepare($UpdateCustomer);
        
        $UpdateCustomerQuery -> bind_param('sssss', $FirstName, $LastName, $Phone, $Address, $DateOfBirth,);

        if ($UpdateCustomerQuery -> execute()){
            header('Location: ../../Pages/CustomerDisplay.php');
            exit;
        }else{
            echo "Error Occurred";
        }

    }
?>