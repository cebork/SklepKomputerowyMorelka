<?php
    session_start();
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "morelka";

    $connection = new mysqli($servername, $username, $password, $dbname);

    if($connection->connect_error){
        die("Connection faild:".$connection->connect_error);
    }
    if(isset($_GET["phrase"])){
        $phrase = $_GET["phrase"];
    }
    
    $new_employee = "INSERT INTO employees (user_id, pobory, data_zatrudnienia, stanowisko_id) VALUES ({$_POST["user_id"]}, {$_POST["pobory"]}, curdate(), 1)";
    $connection->query($new_employee);
    echo $connection->error;
    header("Location: ../content/pracownicy.php");
?>
                        
                        
            