<?php 
    session_start();
    include '../Connection.php';

    if (isset($_POST)){
        $ISBN = $_POST['isbn'];
        $CustomerID = $_POST['customerID'];
        $Amount = $_POST['quantity'];

        //-- We Insert a Sales Transaction Details First --\\
        //-- We Get the ISBN Information
        $EB_Information = "SELECT * FROM EmployeeBooks WHERE ISBN ='$ISBN'";
        $EB_Info_Query = $connection -> query($EB_Information);
        $EB_Info_Query_Results = $EB_Info_Query -> fetch_assoc();

        // We Get the TaxPayerID from ISBN
        $ISBN_TaxpayerID = $EB_Info_Query_Results['TaxpayerID'];

        date_default_timezone_set('Asia/Manila');

        $connection->query("SET time_zone = 'Asia/Manila';"); 

        // Format DateTime
        $currentDateTime = new DateTime();
        $formattedDateTime = $currentDateTime->format('Y-m-d H:i:s');

        // We Add Sales Transaction
        $insertSaleQuery = "INSERT INTO SalesTransaction (CustomerID, EmployeeTaxpayerID, DateTime, TotalBooks) VALUES (?, ?, ?, ?)";
        $insertSaleStmt = $connection->prepare($insertSaleQuery);
        $insertSaleStmt->bind_param("issi", $CustomerID, $ISBN_TaxpayerID, $formattedDateTime, $Amount);
        $insertSaleStmt->execute();

        // We Get Previous SaleID
        $SaleID = $connection->insert_id;
        $Receipt = "TXN" . date("Ymd-His") . "-" . $SaleID;
   
        // Insert the Receipt
        $updateReceiptQuery = "UPDATE SalesTransaction SET Receipt = ? WHERE SaleID = ?";
        $updateReceiptStmt = $connection->prepare($updateReceiptQuery);
        $updateReceiptStmt->bind_param("si", $Receipt, $SaleID);
        $updateReceiptStmt->execute();


        //-- After that, We Insert on SalesBooks --\\
        $SaleBooks_Insert = "INSERT INTO SaleBooks (SaleID, ISBN, Quantity) VALUES (?,?,?)";
        $SaleBooks_Insert_Query = $connection->prepare($SaleBooks_Insert);
        $SaleBooks_Insert_Query -> bind_param('isi', $SaleID, $ISBN, $Amount);
        $SaleBooks_Insert_Query -> execute();



        header('Location: ../../Pages/SaleTransactionDisplay.php');
        exit;
    }
?>