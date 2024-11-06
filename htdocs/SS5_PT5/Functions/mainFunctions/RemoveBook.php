<?php 
    session_start();
    include '../Connection.php';

    if (isset($_GET['isbn'])){
        $ISBN = $_GET['isbn'];

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