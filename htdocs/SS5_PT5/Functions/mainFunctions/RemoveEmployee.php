<?php 
    session_start();
    include '../Connection.php';

    if (isset($_GET['employee_id'])){
        $EmployeeID = $_GET['employee_id'];

        $DeleteEmployee = "DELETE FROM Employees WHERE EmployeeID = '$EmployeeID'";
        $DeleteEmployeeQuery = $connection -> query($DeleteEmployee);

        if ($DeleteEmployeeQuery){
            header('Location: ../../Pages/EmployeeDisplay.php');
            exit;
        }else{
            echo ("Error Occurred");
        }
    }
?>