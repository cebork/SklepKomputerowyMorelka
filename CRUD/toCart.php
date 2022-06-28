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
    $check = 0;
    if(!isset($_SESSION["login"])){
        if(!isset($_COOKIE["koszyk"])){
            $ciastko = array();
            $ciastko_element = array($_POST["item_id"], $_POST["cena"], $_POST["ilosc"]);
            array_push($ciastko, $ciastko_element);
            $ciastko = serialize($ciastko);
            setcookie("koszyk", $ciastko, time() + 3600, "/");
        }else{
            $ciastko = unserialize($_COOKIE["koszyk"]);
            for($i = 0; $i < count($ciastko); $i++){
                if($_POST["item_id"] == $ciastko[$i][0]){
                    $ciastko[$i][2] += $_POST["ilosc"];
                    $check = 1;
                    break;
                }
            }
            if($check == 0){
                $ciastko_element = array($_POST["item_id"], $_POST["cena"], $_POST["ilosc"]);
                array_push($ciastko, $ciastko_element);
            }
            $check = 0;
            $ciastko = serialize($ciastko);
            setcookie("koszyk", $ciastko, time() + 3600, "/");
            
        }
    }else{
        $query_status = "SELECT * FROM statusy s, zamowienia z, users u WHERE s.status_id = z.status_id AND z.user_id = u.user_id AND s.status = 'koszyk' AND u.login = '{$_SESSION["login"]}'";
        $result_status = $connection->query($query_status);
        $row_status = $result_status->fetch_assoc();
        $wartosc = $row_status["cena"];
        $wartosc += ($_POST["cena"] * $_POST["ilosc"]);
        $check = 0;
        $query_zawartosc_check = "SELECT * FROM zawartosczamowienia WHERE zamówienie_id = {$row_status["zamowienia_id"]}";
        $result_zawartosc_check = $connection->query($query_zawartosc_check);
        if($result_zawartosc_check->num_rows > 0){
            while($row_zawartosc_check = $result_zawartosc_check->fetch_assoc()){
                if($row_zawartosc_check["item_id"] == $_POST["item_id"]){
                    $check = 1;      
                }
            }
            if($check == 1){
                $query_zawartosc = "UPDATE zawartosczamowienia SET ilosc=ilosc+{$_POST["ilosc"]} WHERE item_id = {$_POST["item_id"]}";
            }else{
                $query_zawartosc = "INSERT INTO zawartosczamowienia (zamówienie_id, item_id, ilosc, cena) VALUES ({$row_status["zamowienia_id"]}, {$_POST["item_id"]}, {$_POST["ilosc"]}, {$_POST["cena"]})";
            }
        }else{
            $query_zawartosc = "INSERT INTO zawartosczamowienia (zamówienie_id, item_id, ilosc, cena) VALUES ({$row_status["zamowienia_id"]}, {$_POST["item_id"]}, {$_POST["ilosc"]}, {$_POST["cena"]})";
        }
        
        $connection->query($query_zawartosc);
        $query_update_cena = "UPDATE zamowienia SET cena={$wartosc} WHERE zamowienia_id={$row_status["zamowienia_id"]}";
        $connection->query($query_update_cena);
    }


    header("Location: ../content/koszyk.php");
?>