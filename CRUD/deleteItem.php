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
    $delete_item = "UPDATE items SET usuniety = 1 WHERE item_id = {$_GET["item_ID"]}";
    $connection->query( $delete_item);
    header("Location: ../content/editDeleteItem.php");
?>