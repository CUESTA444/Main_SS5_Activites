<?php 
    session_start();
    include '../Connection.php';

    function generateTestTIN() {
        // Generate random numbers for each segment
        $part1 = str_pad(rand(1, 899), 3, '0', STR_PAD_LEFT);
        $part2 = str_pad(rand(1, 99), 2, '0', STR_PAD_LEFT);
        $part3 = str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
        
        // Combine into the TIN format XXX-XX-XXXX
        return $part1 . '-' . $part2 . '-' . $part3;
    }

    function CheckSameTPI($ReceivedTaxPayerID){
        global $connection;

        $GetEmployeeInformation = "SELECT * FROM Employees WHERE TaxpayerID = '$ReceivedTaxPayerID'";
        $EmployeeInformationQuery = $connection -> query($GetEmployeeInformation);
        $EmployeeFetchRow = $EmployeeInformationQuery -> fetch_row();

        if ($EmployeeFetchRow > 0){
            return true;
        }else{
            return false;
        }
    }

    if (isset($_POST)){
        $FirstName = $_POST['firstName'];
        $LastName = $_POST['lastName'];
        $DateOfBirth = $_POST['dateOfBirth'];
        $Address = $_POST['address'];
        $Pseudonym = $_POST['pseudonym'];

        $InsertEmployee = "INSERT INTO Employees (TaxpayerID, FirstName, LastName, Pseudonym, Address, DateOfBirth) VALUES (?,?,?,?,?,?)";
        $InsertEmployeeQuery = $connection -> prepare($InsertEmployee);

        $TaxPayerID = generateTestTIN();

        
        while (CheckSameTPI($TaxPayerID) == true){
            $TaxPayerID = generateTestTIN();
        }


        $InsertEmployeeQuery -> bind_param('ssssss', $TaxPayerID, $FirstName, $LastName, $Pseudonym, $Address, $DateOfBirth);

        if ($InsertEmployeeQuery -> execute()){
            header('Location: ../../Pages/EmployeeDisplay.php');
            exit;
        }else{
            echo "Error Occurred";
        }

    }
?>