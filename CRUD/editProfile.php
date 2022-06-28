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
    print_r($_POST);
    $query_update_user = "UPDATE dane_personalne SET email='{$_POST["email"]}', telefon={$_POST["phone"]}, miejscowosc='{$_POST["city"]}', kod_pocztowy='{$_POST["postal"]}', ulica='{$_POST["address1"]}', nr_domu='{$_POST["address2"]}' WHERE user_id = {$_POST["id"]}";
    echo $query_update_user;
    $connection->query($query_update_user);
    header("Location: ../formularze/editProfileFrom.php")
?>