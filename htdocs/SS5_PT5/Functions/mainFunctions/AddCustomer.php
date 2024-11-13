<?php 
    session_start();
    include '../Connection.php';

    if (isset($_POST)){
        $FirstName = $_POST['firstName'];
        $LastName = $_POST['lastName'];
        $DateOfBirth = $_POST['dateOfBirth'];
        $Phone = $_POST['phone'];
        $Address = $_POST['Address'];
        $Password = $_POST['password'];
        $username = $_POST['username'];

        $InsertCustomer = "";

        // We check first if theres any Same username
        $CheckSameUsername = "SELECT * FROM Customers WHERE Username = '$username'";
        $CheckSameUsername_Query = $connection -> query($CheckSameUsername);

        if ($CheckSameUsername_Query -> num_rows > 0){
            $_SESSION['ServerMessage'] = "Username Already Taken, Choose Different One!";
            header('Location: ../../Pages/RegisterPage.php');
            exit;
        }

        if (isset($Password)){
            if ($Password != null && $Password != ""){
                if (isset($username)){
                    if ($username != null && $username != ""){
                        $InsertCustomer = "INSERT INTO Customers (FirstName, LastName, Phone, Address, DateOfBirth, password, Username) VALUES (?,?,?,?,?,?,?)";
                    }else{
                        $InsertCustomer = "INSERT INTO Customers (FirstName, LastName, Phone, Address, DateOfBirth, password) VALUES (?,?,?,?,?,?)";
                    }
                }else{
                    $InsertCustomer = "INSERT INTO Customers (FirstName, LastName, Phone, Address, DateOfBirth, password) VALUES (?,?,?,?,?,?)";
                }
            }else{
                $InsertCustomer = "INSERT INTO Customers (FirstName, LastName, Phone, Address, DateOfBirth) VALUES (?,?,?,?,?)";
            }
        }else{
            if (isset($username)){
                if ($username != null && $username != ""){
                    $InsertCustomer = "INSERT INTO Customers (FirstName, LastName, Phone, Address, DateOfBirth, Username) VALUES (?,?,?,?,?,?)";
                }else{
                    $InsertCustomer = "INSERT INTO Customers (FirstName, LastName, Phone, Address, DateOfBirth) VALUES (?,?,?,?,?)";
                }
            }else{
                $InsertCustomer = "INSERT INTO Customers (FirstName, LastName, Phone, Address, DateOfBirth) VALUES (?,?,?,?,?)";
            }
        }

        $InsertCustomerQuery = $connection -> prepare($InsertCustomer);
       
        if (isset($Password)){
            if ($Password != null && $Password != ""){
                if (isset($username)){
                    if ($username != null && $username != ""){
                        $InsertCustomerQuery -> bind_param('sssssss',$FirstName, $LastName, $Phone, $Address, $DateOfBirth, $Password, $username);
                    }else{
                        $InsertCustomerQuery -> bind_param('ssssss',$FirstName, $LastName, $Phone, $Address, $DateOfBirth, $Password);
                    }
                }else{
                    $InsertCustomerQuery -> bind_param('ssssss',$FirstName, $LastName, $Phone, $Address, $DateOfBirth, $Password);
                }
            }else{
                $InsertCustomerQuery -> bind_param('sssss',$FirstName, $LastName, $Phone, $Address, $DateOfBirth);
            }
        }else{
            if (isset($username)){
                if ($username != null && $username != ""){
                    $InsertCustomerQuery -> bind_param('sssss',$FirstName, $LastName, $Phone, $Address, $DateOfBirth, $username);
                }else{
                    $InsertCustomerQuery -> bind_param('sssss',$FirstName, $LastName, $Phone, $Address, $DateOfBirth);
                }
            }else{
                $InsertCustomerQuery -> bind_param('sssss',$FirstName, $LastName, $Phone, $Address, $DateOfBirth);
            }
        }

        if ($InsertCustomerQuery -> execute()){
            if (isset($Password)){
                if ($Password != "" && $Password != null){
                    $_SESSION['ServerMessage'] = "Created the account successfully!";
                    header('Location: ../../Pages/LoginPage.php');
                    exit;
                }else{
                    header('Location: ../../Pages/CustomerDisplay.php');
                    exit;
                }
            }else{
                header('Location: ../../Pages/CustomerDisplay.php');
                exit;
            }
        }else{
            echo "Error Occurred";
        }

    }
?>