<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "morelka";

    $connection = new mysqli($servername, $username, $password, $dbname);

    if($connection->connect_error){
        die("Connection faild:".$connection->connect_error);
    }


    if(isset($_GET["item_id"])){
        $ciastko = unserialize($_COOKIE["koszyk"]);
        if(count($ciastko) == 1){
            setcookie("koszyk", "", time() - 3600, "/");
        }else{
            for($i = 0; $i < count($ciastko); $i++){
                if($ciastko[$i][0] == $_GET["item_id"] && $i != count($ciastko) - 1){
                    for($j = $i; $j < count($ciastko) - 1; $j++){
                        $ciastko[$j] = $ciastko[$j + 1];
                    }
                    unset($ciastko[count($ciastko) - 1]);
                }else if($ciastko[$i][0] == $_GET["item_id"] && $i == count($ciastko) - 1){
                    unset($ciastko[$i]);
                }
            }
            $ciastko = serialize($ciastko);
            setcookie("koszyk", $ciastko, time() + 3600, "/");
        }   
    }

    if(isset($_GET["zawartosc_id"])){
        $sql = "DELETE FROM zawartosczamowienia WHERE zawartosc_item_id={$_GET["zawartosc_id"]}";
        $connection->query($sql);
        $sql2 = "UPDATE zamowienia SET cena=cena-{$_GET["cena"]} WHERE zamowienia_id = {$_GET["zam_id"]}";
        $connection->query($sql2);
    }
    header("Location: ../content/koszyk.php");
?>