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
    
    $zwolnij = "DELETE FROM employees WHERE user_id={$_GET["user_id"]}";
    $connection->query($zwolnij);
    echo $connection->error;
    header("Location: ../content/pracownicy.php");
?>