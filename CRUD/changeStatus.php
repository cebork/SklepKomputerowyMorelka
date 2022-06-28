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

    $update_query = "UPDATE zamowienia SET status_id = {$_POST["zamowienia_statusy"]} WHERE zamowienia_id = {$_POST["zam_id"]}";
    $connection->query($update_query);
    header("Location: ../content/zawartoscZamPrac.php?zam_id={$_POST["zam_id"]}");
?>