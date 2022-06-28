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
    if(isset($_POST["done"]) && isset($_POST["platnosc"]) && isset($_POST["dostawcy"])){
        $x = date('Y-m-d');

        $query_update_stan = "SELECT * FROM zawartosczamowienia zz, zamowienia z WHERE zz.zamówienie_id = z.zamowienia_id AND z.zamowienia_id =
        (SELECT z2.zamowienia_id FROM zamowienia z2 WHERE z2.user_id = (SELECT u.user_id FROM users u WHERE u.login = '{$_SESSION["login"]}') AND status_id = 
        (SELECT status_id FROM statusy WHERE status = 'koszyk'))";
        echo $query_update_stan;
        $result_update_stan = $connection->query($query_update_stan);
        if($result_update_stan->num_rows > 0){
            for($i = 0; $i < $result_update_stan->num_rows; $i++){
                $row_update_stan = $result_update_stan->fetch_assoc();
                $query_zmien = "UPDATE items SET ilosc = ilosc - {$row_update_stan["ilosc"]} WHERE item_id = {$row_update_stan["item_id"]}";
                $result_zmien = $connection->query($query_zmien);
                $query_zmien2 = "UPDATE items SET kupione = kupione + {$row_update_stan["ilosc"]} WHERE item_id = {$row_update_stan["item_id"]}";
                $result_zmien2 = $connection->query($query_zmien2);
            }
        }

        $query_PL = "UPDATE users SET PL = PL + (SELECT z.cena from users u, zamowienia z, statusy s WHERE s.status_id = z.status_id AND z.user_id = u.user_id AND u.login = '{$_SESSION["login"]}' AND s.status = 'koszyk') WHERE login = '{$_SESSION["login"]}'";
        $result_PL = $connection->query($query_PL);

        $query_change_zamowienie = "UPDATE zamowienia SET cena = cena + (SELECT cena FROM sposoby_platnosci WHERE sposob_platnosci_id = {$_POST["platnosc"]}) + (SELECT cena FROM dostawcy WHERE dostawca_id = {$_POST["dostawcy"]}),  sposob_platnosci_id = {$_POST["platnosc"]}, dostawca_id = {$_POST["dostawcy"]}, data = '{$x}', status_id = (SELECT status_id FROM statusy WHERE status = 'zamowione') WHERE zamowienia.user_id = (SELECT u.user_id FROM users u WHERE login = '{$_SESSION["login"]}') AND status_id = (SELECT status_id FROM statusy WHERE status = 'koszyk')";
        $result_change_zamowienie = $connection->query($query_change_zamowienie);

        $query_new_cart = "INSERT INTO zamowienia (zamowienia.user_id, cena, status_id) VALUES ((SELECT u.user_id FROM users u WHERE login = '{$_SESSION["login"]}'), 0, (SELECT status_id FROM statusy WHERE status = 'koszyk'))";
        $result_new_cart = $connection->query($query_new_cart);

    }

    header("Location: ../content/thankspage.php");
?>