<?php 
    session_start();
    include '../Connection.php';

    if (isset($_POST)){
        $ISBN = $_POST['isbn'];
        $Title = $_POST['title'];
        $Year = $_POST['year'];
        $Publisher = $_POST['publisher'];

        $InsertBook = "INSERT INTO Books (ISBN, Title, Year, Publisher) VALUES (?,?,?,?)";
        $InsertBookQuery = $connection -> prepare($InsertBook);
        
        $InsertBookQuery -> bind_param('ssss', $ISBN, $Title, $Year, $Publisher);

        if (isset($_FILES['bookCover'])){
            if ($_FILES['bookCover']['size'] != 0){
                $FileName = $_FILES['bookCover']['name'];
                $FileType = $_FILES['bookCover']['type'];
                $File_tmpName = $_FILES['bookCover']['tmp_name'];
                $FileSize = $_FILES['bookCover']['size'];

                // Add Png Book Cover
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


        if ($InsertBookQuery -> execute()){
            header('Location: ../../Pages/BooksDisplay.php');
            exit;
        }else{
            echo "Error Occurred";
        }

    }
?>