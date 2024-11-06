<?php 
    session_start();
    include '../Connection.php';

    if (isset($_POST)){
        $ISBN = $_POST['isbn'];
        $Title = $_POST['title'];
        $Year = $_POST['year'];
        $Publisher = $_POST['publisher'];

        $InsertBook = "INSERT INTO Books (ISBN, Title, Year, Publisher, Image_Path) VALUES (?,?,?,?,?)";
        $InsertBookQuery = $connection -> prepare($InsertBook);

        $Book_IMG_Path = "";
        
        $InsertBookQuery -> bind_param('sssss', $ISBN, $Title, $Year, $Publisher, $Book_IMG_Path);

        if ($InsertBookQuery -> execute()){
            header('Location: ../../Pages/BooksDisplay.php');
            exit;
        }else{
            echo "Error Occurred";
        }

    }
?>