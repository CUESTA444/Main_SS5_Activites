<?php 
    session_start();
    include '../Connection.php';

    if (isset($_POST)){
        $FirstName = $_POST['firstName'];
        $LastName = $_POST['lastName'];
        $DateOfBirth = $_POST['dateOfBirth'];
        $Phone = $_POST['phone'];
        $Address = $_POST['Address'];

        $InsertCustomer = "INSERT INTO Customers (FirstName, LastName, Phone, Address, DateOfBirth) VALUES (?,?,?,?,?)";
        $InsertCustomerQuery = $connection -> prepare($InsertCustomer);

        $InsertCustomerQuery -> bind_param('sssss',$FirstName, $LastName, $Phone, $Address, $DateOfBirth);

        if ($InsertCustomerQuery -> execute()){
            header('Location: ../../Pages/CustomerDisplay.php');
            exit;
        }else{
            echo "Error Occurred";
        }

    }
?>