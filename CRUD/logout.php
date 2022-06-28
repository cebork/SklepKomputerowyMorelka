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
    $id_zam = 0;
    $query_zawartosc_zamowienia_users = "SELECT zz.cena, zz.item_id, zz.ilosc, z.zamowienia_id, zz.zamówienie_id FROM items it JOIN zawartosczamowienia zz ON it.item_id = zz.item_id RIGHT JOIN zamowienia z ON zz.zamówienie_id = z.zamowienia_id JOIN users u ON z.user_id = u.user_id WHERE z.status_id = (SELECT status_id FROM statusy WHERE status = 'koszyk') AND u.login = '{$_SESSION["login"]}'";
    $result_zawartosc_zamowienia_users = $connection->query($query_zawartosc_zamowienia_users);
    if($result_zawartosc_zamowienia_users->num_rows > 0){
        $ciastko = array();
        while($row_zawartosc_zamowienia_users = $result_zawartosc_zamowienia_users->fetch_assoc()){
            $ciastko_element = array($row_zawartosc_zamowienia_users["item_id"], $row_zawartosc_zamowienia_users["cena"], $row_zawartosc_zamowienia_users["ilosc"]);
            array_push($ciastko, $ciastko_element);
        }
        $result_zawartosc_zamowienia_users = $connection->query($query_zawartosc_zamowienia_users);
        $row_zawartosc_zamowienia_users = $result_zawartosc_zamowienia_users->fetch_assoc();
        $query_delete_zawartosc = "DELETE FROM zawartosczamowienia WHERE zamówienie_id = {$row_zawartosc_zamowienia_users["zamowienia_id"]}";
        $query_delete_zamowienie = "DELETE FROM zamowienia WHERE zamowienia_id = {$row_zawartosc_zamowienia_users["zamowienia_id"]}";
        $connection->query($query_delete_zawartosc);
        $connection->query($query_delete_zamowienie);
        echo $row_zawartosc_zamowienia_users["item_id"];
        $ciastko = serialize($ciastko);
        if(!is_null($row_zawartosc_zamowienia_users["zamówienie_id"])){
            setcookie("koszyk", $ciastko, time() + 3600,  "/");
        }
        
    }
    session_unset();
    session_destroy();
    header("Location: ../formularze/loginForm.php");
?>