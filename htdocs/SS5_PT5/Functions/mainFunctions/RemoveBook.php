<?php 
    session_start();
    include '../Connection.php';

    if (isset($_GET['isbn'])){
        $ISBN = $_GET['isbn'];

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

        $DeleteBook = "DELETE FROM Books WHERE ISBN = '$ISBN'";
        $DeleteBookQuery = $connection -> query($DeleteBook);

        if ($DeleteBookQuery){
            header('Location: ../../Pages/BooksDisplay.php');
            exit;
        }else{
            echo ("Error Occurred");
        }
    }
?>