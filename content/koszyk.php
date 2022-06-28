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
?>
<!DOCTYPE html>
<html> 
    <head>
        <meta charset="UTF-8">
        <title>morelka</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <link rel="stylesheet" href="../style/style.css">
        <script src="../skrypty/script.js"></script>
    </head> 
    <body>
        <header class="header container-fluid position-fixed bg-primary">
            <div class="row">
                <div class="col-2">
                    <a class="text-decoration-none link-dark" href="../main.php"><h1 class="display-4">morelka</h2></a>
                </div>
                <div class="col-8 ">
                    <ul class="nav nav-pills ">
                        <li class="nav-item ">
                            <a class="nav-link text-dark display-6 mask" style="" aria-current="page" href="../content/kategorie.php?tabela=komputery&page=1">Komputery</a>
                        </li>
                        <li class="nav-item dropdown ">
                            <a class="nav-link dropdown-toggle text-dark display-6 mask" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Podzespoły</a>
                            <ul class="dropdown-menu">
                                <?php
                                    $query_for_kategorie = "SELECT * FROM podkategorie p, kategorie k WHERE p.kategoria_id = k.kategoria_id AND k.nazwa = 'Podzespoły'";
                                    $result_for_kategorie = $connection->query($query_for_kategorie);
                                    if($result_for_kategorie->num_rows > 0){
                                        while($row_for_kategorie = $result_for_kategorie->fetch_assoc()){
                                            echo "<li><a class='dropdown-item' href='../content/kategorie.php?tabela={$row_for_kategorie["podkategoria_nazwa_tabeli"]}&page=1'>{$row_for_kategorie["podkategoria_nazwa"]}</a></li>";
                                        }
                                    }
                                ?>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-dark display-6 mask" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Peryferia</a>
                            <ul class="dropdown-menu">
                            <?php
                                    $query_for_kategorie = "SELECT * FROM podkategorie p, kategorie k WHERE p.kategoria_id = k.kategoria_id AND k.nazwa = 'Peryferia'";

                                    $result_for_kategorie = $connection->query($query_for_kategorie);
                                    if($result_for_kategorie->num_rows > 0){
                                        while($row_for_kategorie = $result_for_kategorie->fetch_assoc()){
                                            echo "<li><a class='dropdown-item' href='../content/kategorie.php?tabela={$row_for_kategorie["podkategoria_nazwa_tabeli"]}&page=1'>{$row_for_kategorie["podkategoria_nazwa"]}</a></li>";
                                        }
                                    }
                                ?>
                            </ul>
                        </li>
                        <li id="ranking" class="nav-item ">
                            <a class="nav-link text-dark display-6 mask" style="" aria-current="page" href="../content/ranking.php">Ranking</a>
                        </li>
                    </ul>
                </div>
                <div class="col-2 text-end koszyk_profil">
                    <ul class="nav nav-pills ">
                        <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-dark mask koszyk_profil" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false"><img src="../images/person.svg" width="50" height="50"/></a>
                            <ul class="dropdown-menu">
                                <?php
                                   
                                    if(isset($_SESSION["nazwa"])){
                                        if($_SESSION["nazwa"] == 'user'){
                                            echo "
                                            <li><a class='dropdown-item' href='../formularze/editProfileFrom.php'>Edytuj profil</a></li>
                                            <li><a class='dropdown-item' href='../content/historia.php'>Historia zamówienia</a></li>
                                            <li><a class='dropdown-item' href='../CRUD/logout.php' >Wyloguj się</a></li>
                                            ";
                                        }else if($_SESSION["nazwa"] == 'pracownik'){
                                            echo "
                                            <li><a class='dropdown-item' href='../formularze/editProfileFrom.php'>Edytuj profil</a></li>
                                            <li><a class='dropdown-item' href='../content/historia.php'>Historia zamówienia</a></li>
                                            <li><a class='dropdown-item' href='../CRUD/itemadd.php'>Dodaj przedmiot</a></li>
                                            <li><a class='dropdown-item' href='../content/editDeleteItem.php'>Edycja i usuwanie przedmiotów</a></li>
                                            <li><a class='dropdown-item' href='../content/orderUpdate.php'>Aktualizacja zamówień</a></li>
                                            <li><a class='dropdown-item' href='../CRUD/logout.php'>Wyloguj się</a></li>
                                            ";
                                        }else if($_SESSION["nazwa"] == 'szef'){
                                            echo "
                                            <li><a class='dropdown-item' href='../formularze/editProfileFrom.php'>Edytuj profil</a></li>
                                            <li><a class='dropdown-item' href='../content/historia.php'>Historia zamówienia</a></li>
                                            <li><a class='dropdown-item' href='../CRUD/itemadd.php'>Dodaj przedmiot</a></li>
                                            <li><a class='dropdown-item' href='../content/editDeleteItem.php'>Edycja i usuwanie przedmiotów</a></li>
                                            <li><a class='dropdown-item' href='../content/orderUpdate.php'>Aktualizacja zamówień</a></li>
                                            <li><a class='dropdown-item' href='../content/pracownicy.php'>Pracownicy</a></li>
                                            <li><a class='dropdown-item' href='../content/raporty.php'>Raporty</a></li>
                                            <li><a class='dropdown-item' href='../CRUD/logout.php'>Wyloguj się</a></li>
                                            ";
                                        }
                                    }else{
                                        echo "<li><a class='dropdown-item' href='../formularze/loginForm.php'>Zaloguj się</a></li>";
                                    }
                                ?>

                            </ul>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link text-dark mask koszyk_profil" aria-current="page" href="../content/koszyk.php">
                                <img src="../images/bag.svg" width="50" height="50"/>
                                <?php
                                    $wartosc = 0;
                                    if(!isset($_SESSION["login"])){
                                        if(isset($_COOKIE["koszyk"])){
                                            $ciastko = unserialize($_COOKIE["koszyk"]);
                                            for($i = 0; $i < count($ciastko); $i++){
                                                $wartosc += $ciastko[$i][1]*$ciastko[$i][2];
                                            }
                                        }
                                    } else {
                                        $query_status = "SELECT * FROM statusy s, zamowienia z, users u WHERE s.status_id = z.status_id AND z.user_id = u.user_id AND s.status = 'koszyk' AND u.login = '{$_SESSION["login"]}'";
                                        $result_status = $connection->query($query_status);
                                        if($result_status->num_rows > 0){
                                            $row_status = $result_status->fetch_assoc();
                                            $wartosc = $row_status["cena"];
                                        }
                                    }
                                    
                                    echo "<b style='font-size: 18px;'>".$wartosc." PLN</b>";
                                ?>
                            </a>
                        </li>
                    </ul>
                    

                </div> 
            </div>
        </header>
        <article id="articlee" class="article container">
            <input id='koszchange' type=hidden>
            <div class="row">
                <div class="col-2 ">
                </div> 
                <div class="col-8 ">
                    <h2 class='display-5 d-flex justify-content-center'>Koszyk</h2>
                    <table class="table table-striped">
                        <tbody>
                            <?php
                                $wartosc = 0;
                                if(!isset($_SESSION["login"])){
                                    if(!isset($_COOKIE["koszyk"])){
                                        echo "<p class='text-justify text-center'>Koszyk jest pusty</p>";
                                    }else{
                                        $ciastko = unserialize($_COOKIE["koszyk"]);
                                        for($i = 0; $i < count($ciastko); $i++){
                                            $wartosc += $ciastko[$i][1]*$ciastko[$i][2];
                                            $item_id = $ciastko[$i][0];
                                            $query_cookie_cart = "SELECT * FROM podkategorie p, items it, images im WHERE it.item_id = im.item_id AND it.podkategoria_id = p.podkategoria_id AND it.item_id = {$item_id}";
                                            $result_cookie_cart = $connection->query($query_cookie_cart);
                                            echo "<tr>";
                                            if($result_cookie_cart->num_rows > 0){
                                                while($row_cookie_cart = $result_cookie_cart->fetch_assoc()){
                                                    if($row_cookie_cart["status"] == 0){
                                                        echo "<td><a href='../content/szczegoly.php?tabela={$row_cookie_cart["podkategoria_nazwa_tabeli"]}&item_id={$row_cookie_cart["item_id"]}'><img style='width: 100px;' src='../images/image{$_GET["item_id"]}.{$row_cookie_cart["ext"]}' class='card-img-top' alt='...'></a> <b style='font-size: 35px'>{$row_cookie_cart["nazwa"]}</b></td>";
                                                    }else{
                                                        echo "<td><a href='../content/szczegoly.php?tabela={$row_cookie_cart["podkategoria_nazwa_tabeli"]}&item_id={$row_cookie_cart["item_id"]}'><img style='width: 100px;' src='../images/placeholder.jpg' class='card-img-top' alt='...'></a> <b style='font-size: 35px'>{$row_cookie_cart["nazwa"]}</b></td>";
                                                    }
                                                }
                                                echo "<td class='align-middle'>Cena: {$ciastko[$i][1]} PLN";
                                                echo "<td class='align-middle'>Ilosc: {$ciastko[$i][2]} </td>";
                                                echo "<td class='align-middle'><a href='../CRUD/koszykUsunItem.php?item_id={$item_id}'> Usuń </a></td>";
                                                echo "</tr>";
                                                
                                            }
                                            
                                        }
                                    }
                                }else{
                                    $query_database_cart = "SELECT z.zamowienia_id, zz.cena, zz.zawartosc_item_id, zz.ilosc, it.item_id, it.nazwa, im.* FROM ((((users u JOIN zamowienia z ON u.user_id = z.user_id) JOIN zawartosczamowienia zz ON z.zamowienia_id=zz.zamówienie_id) JOIN items it ON zz.item_id = it.item_id) JOIN images im ON it.item_id = im.item_id) WHERE status_id = (SELECT status_id FROM statusy WHERE status = 'koszyk') AND u.login = '{$_SESSION["login"]}'";
                                    $result_database_cart = $connection->query($query_database_cart);
                                    if($result_database_cart->num_rows > 0){
                                        while($row_database_cart = $result_database_cart->fetch_assoc()){
                                            $wartosc += $row_database_cart["cena"]*$row_database_cart["ilosc"];
                                            $query_tabela = "SELECT * FROM items i, podkategorie p WHERE i.podkategoria_id = p.podkategoria_id AND i.item_id = {$row_database_cart["item_id"]}";
                                            $result_tabela = $connection->query($query_tabela);
                                            echo $connection->error;
                                            $row_tabela = $result_tabela->fetch_assoc();
                                            echo "<tr>";
                                            if($row_database_cart["status"] == 0){
                                                echo "<td><a href='../content/szczegoly.php?tabela={$row_tabela["podkategoria_nazwa_tabeli"]}&item_id={$row_database_cart["item_id"]}'><img style='width: 100px;' src='../images/image{$row_database_cart["item_id"]}.{$row_database_cart["ext"]}' class='card-img-top' alt='...'></a> <b style='font-size: 35px'>{$row_database_cart["nazwa"]}</b></td>";
                                            }else{
                                                echo "<td><a href='../content/szczegoly.php?tabela={$row_tabela["podkategoria_nazwa_tabeli"]}&item_id={$row_database_cart["item_id"]}'><img style='width: 100px;' src='../images/placeholder.jpg' class='card-img-top' alt='...'></a> <b style='font-size: 35px'>{$row_database_cart["nazwa"]}</b></td>";
                                            }
                                            echo "<td class='align-middle'>Cena: {$row_database_cart["cena"]} PLN";
                                            echo "<td class='align-middle'>Ilosc: {$row_database_cart["ilosc"]} </td>";
                                            echo "<td class='align-middle'><a href='../CRUD/koszykUsunItem.php?zawartosc_id={$row_database_cart["zawartosc_item_id"]}&cena={$row_database_cart["cena"]}&zam_id={$row_database_cart["zamowienia_id"]}'> Usuń </a></td>";
                                            echo "</tr>";
                                        }
                                    }else{
                                        echo "<p class='text-justify text-center'>Koszyk jest pusty</p>";
                                    }
                                   
                                }
                            
                        echo "</tbody>";
                    echo "</table>";
                    echo "<p style='font-size: 20px;'>Cena całkowita: {$wartosc} PLN</p>";
                    ?>
                    <hr>
                    <h2>Płatność i dostawa</h2>
                    <br>
                    <h3> Płatność </h3>
                    <form action="../CRUD/zamawiamplace.php" method="POST">
                        <?php
                            $query_platnosc = "SELECT * FROM sposoby_platnosci";
                            $result_platnosci = $connection->query($query_platnosc);
                            if($result_platnosci->num_rows > 0){
                                while($row_platnosci = $result_platnosci->fetch_assoc()){
                                    echo "
                                    <div class='form-check'>
                                        <input class='form-check-input' value='{$row_platnosci["sposob_platnosci_id"]}' type='radio' name='platnosc' id='flexRadioDefault1' checked>
                                        <label class='form-check-label' for='flexRadioDefault1'>
                                        {$row_platnosci["nazwa"]} --- {$row_platnosci["cena"]} PLN
                                        </label>
                                    </div>
                                    ";
                                }
                            }
                        ?>
                        <br>
                        <h3> Dostawa </h3>
                        <?php
                            $query_dostawcy = "SELECT * FROM dostawcy";
                            $result_dostawcy = $connection->query($query_dostawcy);
                            if($result_dostawcy->num_rows > 0){
                                while($row_dostawcy = $result_dostawcy->fetch_assoc()){
                                    echo "
                                    <div class='form-check'>
                                        <input class='form-check-input' value='{$row_dostawcy["dostawca_id"]}' type='radio' name='dostawcy' id='flexRadioDefault1' checked>
                                        <label class='form-check-label' for='flexRadioDefault1'>
                                        {$row_dostawcy["nazwa"]} --- {$row_dostawcy["cena"]} PLN
                                        </label>
                                    </div>
                                    ";
                                }
                            }
                            if(isset($_SESSION["login"])){
                                $query_disabling = "SELECT z.zamowienia_id, zz.cena, zz.zawartosc_item_id, zz.ilosc, it.item_id, it.nazwa, im.* FROM ((((users u JOIN zamowienia z ON u.user_id = z.user_id) JOIN zawartosczamowienia zz ON z.zamowienia_id=zz.zamówienie_id) JOIN items it ON zz.item_id = it.item_id) JOIN images im ON it.item_id = im.item_id) WHERE status_id = (SELECT status_id FROM statusy WHERE status = 'koszyk') AND u.login = '{$_SESSION["login"]}'";
                                $result_disabling = $connection->query($query_disabling);
                                if($result_disabling->num_rows == 0){
                                    echo "<br> <input type='submit' name='done' value='Zamawiam i płacę' class='btn btn-primary' disabled>";
                                }else{
                                    echo "<br> <button type='submit' name='done' class='btn btn-primary'>Zamawiam i płacę</button>";
                                }  
                            }else{
                                echo "<br> <a href='../formularze/loginForm.php' <button type='submit' name='done' class='btn btn-primary'>Zaloguj się</button></a>";
                            }
                            
                        ?>
                    </from>
                </div>
                <div class="col-2 ">
                </div>  
            </div>
        </article>
        <footer class="footer text-end container-fluid text-light bg-secondary">
            @ Cezary Borkowski
        </footer>
        <script src="script.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    </body>
</html>