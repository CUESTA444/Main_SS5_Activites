<?php 
    session_start();
    include '../Connection.php';

    if (isset($_POST)){
        $ISBN = $_POST['isbn'];
        $Title = $_POST['title'];
        $Year = $_POST['year'];
        $Publisher = $_POST['publisher'];
        $FinalizedAuthor = null;

        if ($_POST['author'] != ""){
            $FinalizedAuthor = $_POST['author'];
        }else{
            $FinalizedAuthor = null;
        }

        $Book_IMG_Path = "";

        $UpdateBook = "UPDATE Books SET ISBN = ?, Title = ?, Year = ?, Publisher = ?, Image_Path = ? WHERE ISBN = '$ISBN'";
        $UpdateBookQuery = $connection -> prepare($UpdateBook);
        $UpdateBookQuery -> bind_param('sssss', $ISBN, $Title, $Year, $Publisher, $Book_IMG_Path);

        // If this is not null means they want to update the Author
        if ($FinalizedAuthor != null){
            // We Check first if it exist in EmployeeBooks
            $EmployeeBooksInfo = "SELECT * FROM EmployeeBooks WHERE ISBN = '$ISBN'";
            $EmployeeBooksInfoQuery = $connection -> query($EmployeeBooksInfo);
            $EmployeeBooksInfoResult = $EmployeeBooksInfoQuery -> fetch_assoc();
     
            if ($EmployeeBooksInfoQuery -> num_rows > 0){
                if ($EmployeeBooksInfoResult['ISBN'] != "" && $EmployeeBooksInfoResult['TaxpayerID'] != ""){
                    if ($FinalizedAuthor == "Removed"){
                        // We Removed
                        $Removed_EB = "DELETE FROM EmployeeBooks WHERE ISBN = '$ISBN'";
                        $Removed_EB_query = $connection -> query($Removed_EB);
                    }else{
                        // We Update Only
                        $Update_EB = "UPDATE EmployeeBooks SET TaxpayerID = ? WHERE ISBN = '$ISBN'";
                        $UPDATE_EB_QUERY = $connection -> prepare($Update_EB);
                        $UPDATE_EB_QUERY -> bind_param('s', $FinalizedAuthor);
                        //Execute query
                        $UPDATE_EB_QUERY -> execute();
                    }
                }else{
                    // If has rows but The content is missing then we update
                    $Update_EB = "UPDATE EmployeeBooks SET TaxpayerID = ? WHERE ISBN = '$ISBN'";
                    $UPDATE_EB_QUERY = $connection -> prepare($Update_EB);
                    $UPDATE_EB_QUERY -> bind_param('s', $FinalizedAuthor);
                    //Execute query
                    $UPDATE_EB_QUERY -> execute();
                }
            }else{
                // We Insert If Not Found
                $INSERT_EB = "INSERT INTO EmployeeBooks (ISBN, TaxpayerID) VALUES (?,?)";
                $INSERT_EB_QUERY = $connection -> prepare($INSERT_EB);
                $INSERT_EB_QUERY -> bind_param('ss', $ISBN ,$FinalizedAuthor);
                //Execute query
                $INSERT_EB_QUERY -> execute();
            }
        }else{
            echo "SOMETHING WRONG";
        }

    

        if ($UpdateBookQuery -> execute()){
            header('Location: ../../Pages/BooksDisplay.php');
            exit;
        }else{
            echo "Error Occurred";
        }
    }
?>