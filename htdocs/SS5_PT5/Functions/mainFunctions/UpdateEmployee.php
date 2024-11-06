<?php 
    session_start();
    include '../Connection.php';

    if (isset($_POST)){
        $EmployeeID = $_POST['employee_id'];
        $Taxpayer_ID = $_POST['Taxpayer_ID'];
        $FirstName = $_POST['firstName'];
        $LastName = $_POST['lastName'];
        $DateOfBirth = $_POST['dateOfBirth'];
        $Address = $_POST['address'];
        $Pseudonym = $_POST['pseudonym'];

        $UpdateEmployee = "UPDATE Employees SET TaxpayerID =?, FirstName = ?, LastName = ?, Pseudonym = ?, Address = ?, DateOfBirth = ? WHERE EmployeeID = '$EmployeeID'";
        $UpdateEmployeeQuery = $connection -> prepare($UpdateEmployee);
        
        $UpdateEmployeeQuery -> bind_param('ssssss', $Taxpayer_ID, $FirstName, $LastName, $Pseudonym, $Address, $DateOfBirth);

        if ($UpdateEmployeeQuery -> execute()){
            header('Location: ../../Pages/EmployeeDisplay.php');
            exit;
        }else{
            echo "Error Occurred";
        }

    }
?>