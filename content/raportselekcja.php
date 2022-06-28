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
    switch($_GET["raport"]){
        case 1:
            if($_GET["date_start"] != "" && $_GET["date_end"]!= ""){
                $query_option1 = "SELECT monthNAME(data) as nazwamiesiaca , count(data) as suma, sum(cena) as zysk FROM
                 zamowienia WHERE data > '{$_GET["date_start"]}' AND data < '{$_GET["date_end"]}' AND status_id != (SELECT status_id from statusy where status = 'koszyk') 
                 GROUP BY monthNAME(data) ORDER BY MONTH(data);";
                $result_option1 = $connection->query($query_option1);
                $suma = 0;
                if($result_option1->num_rows >0){
                    echo "<table class='table table-striped'>";
                    echo "<thead>";
                    echo "<th>Nazwa miesiąca </th>";
                    echo "<th>Sprzedaż miesięczna </th>";
                    echo "<th>Zarobek miesięczny</th>";
                    echo "</thead>";
                    while($row_option1 = $result_option1->fetch_assoc()){
                        $suma = $suma + $row_option1["zysk"];
                        echo "<tr>";
                        echo "<td>{$row_option1["nazwamiesiaca"]}</td>";
                        echo "<td>{$row_option1["suma"]}</td>";
                        echo "<td>{$row_option1["zysk"]}</td>";
                        echo "</tr>";
                    }
                    echo "</table>"; 
                    echo "Całkowity zarobek: " . $suma . " PLN";
                }else{
                    echo "<h1 class='display-4 d-flex justify-content-center'>Brak danych</h1>";
                }
            }
            break;
        case 2:
                $query_option1 = "SELECT d.imie, d.nazwisko, e.data_zatrudnienia, e.pobory FROM
                 dane_personalne d JOIN users u ON d.user_id = u.user_id JOIN employees e ON u.user_id = e.user_id JOIN stanowiska s ON e.stanowisko_id = s.stanowisko_id
                  WHERE s.nazwa = 'pracownik' ORDER BY imie DESC , nazwisko ASC;";
                $result_option1 = $connection->query($query_option1);
                if($result_option1->num_rows >0){
                    echo "<table class='table table-striped'>";
                    echo "<thead>";
                    echo "<th>Imię</th>";
                    echo "<th>Nazwisko</th>";
                    echo "<th>Data zatrudnienia</th>";
                    echo "<th>Zarobki</th>";
                    echo "</thead>";
                    while($row_option1 = $result_option1->fetch_assoc()){
                        echo "<tr>";
                        echo "<td>{$row_option1["imie"]}</td>";
                        echo "<td>{$row_option1["nazwisko"]}</td>";
                        echo "<td>{$row_option1["data_zatrudnienia"]}</td>";
                        echo "<td>{$row_option1["pobory"]}</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                }else{
                    echo "<h1 class='display-4 d-flex justify-content-center'>Brak danych</h1>";
                }
            break;
        case 3:
            if($_GET["date_start"] != "" && $_GET["date_end"]!= ""){
                $query_option1 = "select count(user_id) as ilosc FROM users WHERE data_zalozenia > '{$_GET["date_start"]}' AND data_zalozenia < '{$_GET["date_end"]}';";
                $result_option1 = $connection->query($query_option1);
                if($result_option1->num_rows >0){
                    echo "<table class='table table-striped'>";
                    echo "<thead>";
                    echo "<th>Ilość założonych kont</th>";
                    echo "</thead>";
                    while($row_option1 = $result_option1->fetch_assoc()){
                        echo "<tr>";
                        echo "<td>{$row_option1["ilosc"]}</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                }else{
                    echo "<h1 class='display-4 d-flex justify-content-center'>Brak danych</h1>";
                }
            }
            break;
        case 4:
            $query_option1 = "select nazwa, (CASE WHEN kupione < 10 THEN 'NISKA POPULARNOŚĆ' WHEN kupione >= 10 AND kupione < 40 THEN 'UMIARKOWANA POPULARNOSC' ELSE 'DUŻA POPULARNOŚĆ' END) as popularnosc FROM items;";
            $result_option1 = $connection->query($query_option1);
            if($result_option1->num_rows >0){
                echo "<table class='table table-striped'>";
                echo "<thead>";
                echo "<th>Nazwa produktu</th>";
                echo "<th>Popularność</th>";
                echo "</thead>";
                while($row_option1 = $result_option1->fetch_assoc()){
                    echo "<tr>";
                    echo "<td>{$row_option1["nazwa"]}</td>";
                    echo "<td>{$row_option1["popularnosc"]}</td>";
                    echo "</tr>";
                }
                echo "</table>";
            }else{
                echo "<h1 class='display-4 d-flex justify-content-center'>Brak danych</h1>";
            }
            break;
        case 5:
            if($_GET["date_start"] != "" && $_GET["date_end"]!= ""){
                $query_option1 = "SELECT year(data) as rok , count(data) as suma, sum(cena) as zysk FROM zamowienia WHERE data > '{$_GET["date_start"]}' AND data < '{$_GET["date_end"]}' AND status_id != (SELECT status_id from statusy where status = 'koszyk') GROUP BY year(data) ORDER BY year(data);";
                $result_option1 = $connection->query($query_option1);
                $suma = 0;
                if($result_option1->num_rows >0){
                    echo "<table class='table table-striped'>";
                    echo "<thead>";
                    echo "<th>Rok </th>";
                    echo "<th>Sprzedaż roczna </th>";
                    echo "<th>Zarobek roczny</th>";
                    echo "</thead>";
                    while($row_option1 = $result_option1->fetch_assoc()){
                        $suma = $suma + $row_option1["zysk"];
                        echo "<tr>";
                        echo "<td>{$row_option1["rok"]}</td>";
                        echo "<td>{$row_option1["suma"]}</td>";
                        echo "<td>{$row_option1["zysk"]}</td>";
                        echo "</tr>";
                    }
                    echo "</table>"; 
                    echo "Całkowity zarobek: " . $suma . " PLN";
                }else{
                    echo "<h1 class='display-4 d-flex justify-content-center'>Brak danych</h1>";
                }
            }
            break;
        case 6:
            if($_GET["date_start"] != "" && $_GET["date_end"]!= ""){
                $query_option1 = "SELECT data as dzien , count(zamowienia_id) as suma, sum(cena) as zysk FROM zamowienia WHERE data > '{$_GET["date_start"]}' AND data < '{$_GET["date_end"]}' AND status_id != (SELECT status_id from statusy where status = 'koszyk') GROUP BY data ORDER BY data;";
                $result_option1 = $connection->query($query_option1);
                $suma = 0;
                if($result_option1->num_rows >0){
                    echo "<table class='table table-striped'>";
                    echo "<thead>";
                    echo "<th>Data </th>";
                    echo "<th>Sprzedaż dzienna </th>";
                    echo "<th>Zarobek dzienny</th>";
                    echo "</thead>";
                    while($row_option1 = $result_option1->fetch_assoc()){
                        $suma = $suma + $row_option1["zysk"];
                        echo "<tr>";
                        echo "<td>{$row_option1["dzien"]}</td>";
                        echo "<td>{$row_option1["suma"]}</td>";
                        echo "<td>{$row_option1["zysk"]}</td>";
                        echo "</tr>";
                    }
                    echo "</table>"; 
                    echo "Całkowity zarobek: " . $suma . " PLN";
                }else{
                    echo "<h1 class='display-4 d-flex justify-content-center'>Brak danych</h1>";
                }
            }
            break;
        case 7:
            $query_option1 = "SELECT s.nazwa, count(z.zamowienia_id) as ilosc FROM sposoby_platnosci s , zamowienia z WHERE s.sposob_platnosci_id = z.sposob_platnosci_id group by s.nazwa;";
            $result_option1 = $connection->query($query_option1);
            if($result_option1->num_rows >0){
                echo "<table class='table table-striped'>";
                echo "<thead>";
                echo "<th>Sposób płatności </th>";
                echo "<th>Ilosc </th>";
                echo "</thead>";
                while($row_option1 = $result_option1->fetch_assoc()){
                    echo "<tr>";
                    echo "<td>{$row_option1["nazwa"]}</td>";
                    echo "<td>{$row_option1["ilosc"]}</td>";
                    echo "</tr>";
                }
                echo "</table>"; 
            }else{
                echo "<h1 class='display-4 d-flex justify-content-center'>Brak danych</h1>";
            }
            break;
        case 8:
            $query_option1 = "SELECT d.nazwa, count(z.zamowienia_id) as ilosc FROM dostawcy d , zamowienia z WHERE d.dostawca_id = z.dostawca_id group by d.nazwa;";
            $result_option1 = $connection->query($query_option1);
            if($result_option1->num_rows >0){
                echo "<table class='table table-striped'>";
                echo "<thead>";
                echo "<th>Dostawca </th>";
                echo "<th>Ilosc </th>";
                echo "</thead>";
                while($row_option1 = $result_option1->fetch_assoc()){
                    echo "<tr>";
                    echo "<td>{$row_option1["nazwa"]}</td>";
                    echo "<td>{$row_option1["ilosc"]}</td>";
                    echo "</tr>";
                }
                echo "</table>"; 
            }else{
                echo "<h1 class='display-4 d-flex justify-content-center'>Brak danych</h1>";
            }
            break;
        case 9:
            if($_GET["date_start"] != "" && $_GET["date_end"]!= ""){
                $query_option1 = "select sum(zz.ilosc) as ilosc, sum(zz.ilosc * zz.cena) as cena, z.data from items it,  zawartosczamowienia zz, zamowienia z WHERE it.item_id = zz.item_id AND zz.zamówienie_id = z.zamowienia_id AND data > '{$_GET["date_start"]}' AND data < '{$_GET["date_end"]}' AND status_id != (SELECT status_id from statusy where status = 'koszyk') GROUP by z.data order by z.data;";
                $result_option1 = $connection->query($query_option1);
                $suma = 0;
                if($result_option1->num_rows >0){
                    echo "<table class='table table-striped'>";
                    echo "<thead>";
                    echo "<th>Data </th>";
                    echo "<th>Sprzedaż dzienna - przedmioty</th>";
                    echo "<th>Zarobek dzienny</th>";
                    echo "</thead>";
                    while($row_option1 = $result_option1->fetch_assoc()){
                        $suma = $suma + $row_option1["cena"];
                        echo "<tr>";
                        echo "<td>{$row_option1["data"]}</td>";
                        echo "<td>{$row_option1["ilosc"]}</td>";
                        echo "<td>{$row_option1["cena"]}</td>";
                        echo "</tr>";
                    }
                    echo "</table>"; 
                    echo "Całkowity zarobek: " . $suma . " PLN";
                }else{
                    echo "<h1 class='display-4 d-flex justify-content-center'>Brak danych</h1>";
                }
            }
            break;
        case 10:
            if($_GET["date_start"] != "" && $_GET["date_end"]!= ""){
                $query_option1 = "select sum(zz.ilosc) as ilosc, sum(zz.ilosc * zz.cena) as cena, monthName(z.data) as data from items it,  zawartosczamowienia zz, zamowienia z WHERE it.item_id = zz.item_id AND zz.zamówienie_id = z.zamowienia_id AND data > '{$_GET["date_start"]}' AND data < '{$_GET["date_end"]}' AND status_id != (SELECT status_id from statusy where status = 'koszyk') GROUP by monthname(z.data) order by month(z.data);";
                $result_option1 = $connection->query($query_option1);
                $suma = 0;
                if($result_option1->num_rows >0){
                    echo "<table class='table table-striped'>";
                    echo "<thead>";
                    echo "<th>Data </th>";
                    echo "<th>Sprzedaż miesięczna - przedmioty</th>";
                    echo "<th>Zarobek miesięczny</th>";
                    echo "</thead>";
                    while($row_option1 = $result_option1->fetch_assoc()){
                        $suma = $suma + $row_option1["cena"];
                        echo "<tr>";
                        echo "<td>{$row_option1["data"]}</td>";
                        echo "<td>{$row_option1["ilosc"]}</td>";
                        echo "<td>{$row_option1["cena"]}</td>";
                        echo "</tr>";
                    }
                    echo "</table>"; 
                    echo "Całkowity zarobek: " . $suma . " PLN";
                }else{
                    echo "<h1 class='display-4 d-flex justify-content-center'>Brak danych</h1>";
                }
            }
            break;
        case 11:
            if($_GET["date_start"] != "" && $_GET["date_end"]!= ""){
                $query_option1 = "select sum(zz.ilosc) as ilosc, sum(zz.ilosc * zz.cena) as cena, year(z.data) as data from items it,  zawartosczamowienia zz, zamowienia z WHERE it.item_id = zz.item_id AND zz.zamówienie_id = z.zamowienia_id AND data > '{$_GET["date_start"]}' AND data < '{$_GET["date_end"]}' AND status_id != (SELECT status_id from statusy where status = 'koszyk') GROUP by year(z.data) order by year(z.data);";
                $result_option1 = $connection->query($query_option1);
                $suma = 0;
                if($result_option1->num_rows >0){
                    echo "<table class='table table-striped'>";
                    echo "<thead>";
                    echo "<th>Data </th>";
                    echo "<th>Sprzedaż miesięczna - przedmioty</th>";
                    echo "<th>Zarobek miesięczny</th>";
                    echo "</thead>";
                    while($row_option1 = $result_option1->fetch_assoc()){
                        $suma = $suma + $row_option1["cena"];
                        echo "<tr>";
                        echo "<td>{$row_option1["data"]}</td>";
                        echo "<td>{$row_option1["ilosc"]}</td>";
                        echo "<td>{$row_option1["cena"]}</td>";
                        echo "</tr>";
                    }
                    echo "</table>"; 
                    echo "Całkowity zarobek: " . $suma . " PLN";
                }else{
                    echo "<h1 class='display-4 d-flex justify-content-center'>Brak danych</h1>";
                }
            }
            break;
}
?>

