<?php 
    session_start();
    include '../Connection.php';

    if (isset($_POST)){
        $ISBN = $_POST['isbn'];
        $Title = $_POST['title'];
        $Year = $_POST['year'];
        $Publisher = $_POST['publisher'];
        $FinalizedAuthor = "";

        if ($_POST['author'] != ""){
            $FinalizedAuthor = $_POST['author'];
        }else{
            $FinalizedAuthor = null;
        }

        $UpdateBook = "UPDATE Books SET ISBN = ?, Title = ?, Year = ?, Publisher = ? WHERE ISBN = '$ISBN'";
        $UpdateBookQuery = $connection -> prepare($UpdateBook);
        $UpdateBookQuery -> bind_param('ssss', $ISBN, $Title, $Year, $Publisher);

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
            //echo "SOMETHING WRONG";
        }

        if (isset($_FILES['bookCover'])){
            if ($_FILES['bookCover']['size'] != 0){
                $FileName = $_FILES['bookCover']['name'];
                $FileType = $_FILES['bookCover']['type'];
                $File_tmpName = $_FILES['bookCover']['tmp_name'];
                $FileSize = $_FILES['bookCover']['size'];

                // We Delete the previous picture First (If Exist Only)
                $GetUserInfo = "SELECT * FROM Books WHERE ISBN = '$ISBN'";
                $GetUserInfoQuery = $connection -> query($GetUserInfo);
                $GetUserInfo_Results = $GetUserInfoQuery -> fetch_assoc();
                $BooksInfo_Picture_Path = $GetUserInfo_Results['Image_Path'];

                if ($BooksInfo_Picture_Path != null || $BooksInfo_Picture_Path != ""){
                    if (file_exists($BooksInfo_Picture_Path)){
                        unlink($BooksInfo_Picture_Path);
                    }
                }

                // After Deleting previous picture We Add new one
                $Sanitized_FileName = uniqid(). "_" . basename($FileName);
                $TARGET_UPLOAD_DIRECTORY ="/workspaces/Main_SS5_Activites/htdocs/SS5_PT5/Books_Cover/";
                $pngUpload_Path = $TARGET_UPLOAD_DIRECTORY . $Sanitized_FileName;

                $stmt = $connection -> prepare("UPDATE Books SET Image_Path = ? WHERE ISBN = '$ISBN'");
                $stmt -> bind_param("s", $pngUpload_Path);
                
                if ($stmt -> execute()){
                    move_uploaded_file($File_tmpName, $pngUpload_Path);
                }

                $stmt -> close();
            }
        }


        if ($UpdateBookQuery -> execute()){
            header('Location: ../../Pages/BooksDisplay.php');
            exit;
        }else{
            echo "Error Occurred";
        }
    }
?>