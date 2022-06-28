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
    
    $zmien_pobory = "UPDATE employees SET pobory={$_POST["pobory"]} WHERE user_id = {$_POST["user_id"]}";
    $connection->query($zmien_pobory);
    header("Location: ../content/pracownicy.php");
?>