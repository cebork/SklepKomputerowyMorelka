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
            <div class="row">
                <div class="col-12 ">
                    <h1 class="display-4 d-flex justify-content-center">Edycja przedmiotów</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-3 "></div>
                <div class="col-6 ">
                    <div id="formularzx">
                        <form id="formularz" method="POST" action="../CRUD/itemedit.php" enctype="multipart/form-data">
                            <?php
                                $query_for_item_kat = "SELECT * FROM items i NATURAL JOIN {$_GET["kategoria"]} NATURAL JOIN images WHERE item_id = {$_GET["item_ID"]}";
                                $result_for_item_kat = $connection->query($query_for_item_kat);
                                $row_for_item_kat = $result_for_item_kat->fetch_assoc();

                                echo "<input type='hidden' name='kateg' value='{$_GET["kategoria"]}'";
                                $quick_cat = "SELECT podkategoria_id FROM podkategorie WHERE podkategoria_nazwa_tabeli='{$_GET["kategoria"]}'";
                                $result_quick_cat = $connection->query($quick_cat);
                                if($result_quick_cat->num_rows > 0){
                                    $row_quick_cat =  $result_quick_cat->fetch_assoc();
                                }
                                $nrkat = $row_quick_cat["podkategoria_id"];
                                $query_for_column = "SHOW COLUMNS FROM items";
                                $result_for_column = $connection->query($query_for_column);
                                if($result_for_column->num_rows > 0){
                                    for($i = 0; $i < $result_for_column->num_rows; $i++){
                                        $row_for_column =  $result_for_column->fetch_assoc();
                                        if($i == 0 || $i == 3 || $i == 13){
                                            continue;
                                        }
                                        $changed = str_replace("_", " ", $row_for_column["Field"]);
                                        $changed = mb_convert_case($changed, MB_CASE_TITLE ); 
                                        echo "<div class='form-group'>";
                                        if($row_for_column["Field"] == "data_produkcji"){
                                            echo "<label for='{$changed}'>{$changed}</label>";
                                            echo "<input name='{$row_for_column["Field"]}' type='date' class='form-control' id='{$changed}' value='{$row_for_item_kat["{$row_for_column["Field"]}"]}' aria-describedby='emailHelp' required>";
                                        }else if($row_for_column["Field"] == "podkategoria_id"){
                                            echo "<input type='hidden' name='nrkat' value='{$nrkat}'";
                                        }else if(preg_match("/int*/", $row_for_column["Type"]) || $row_for_column["Type"] == "float"){
                                            echo "<label for='{$changed}'>{$changed}</label>";
                                            echo "<input name='{$row_for_column["Field"]}' type='number' value='{$row_for_item_kat["{$row_for_column["Field"]}"]}' class='form-control' id='{$changed}' aria-describedby='emailHelp' placeholder='' required>";
                                        }else{
                                            echo "<label for='{$changed}'>{$changed}</label>";
                                            echo "<input name='{$row_for_column["Field"]}' type='text' value='{$row_for_item_kat["{$row_for_column["Field"]}"]}' class='form-control' id='{$changed}' aria-describedby='emailHelp' placeholder='' required>";
                                        }     
                                        
                                        echo "</div>";
                                    }
                                }
                                
                                $query_for_column = "SHOW COLUMNS FROM {$_GET["kategoria"]}";
                                $result_for_column = $connection->query($query_for_column);
                                if($result_for_column->num_rows > 0){
                                    for($i = 0; $i < $result_for_column->num_rows; $i++){
                                        $row_for_column =  $result_for_column->fetch_assoc();
                                        if($i == 0 || $i == $result_for_column->num_rows - 1){
                                            continue;
                                        }
                                        $changed = str_replace("_", " ", $row_for_column["Field"]);
                                        $changed = mb_convert_case($changed, MB_CASE_TITLE );
                                        echo "<div class='form-group'>";
                                        if($row_for_column["Field"] == "czy_bezprzewodowa"){
                                            if($row_for_item_kat["{$row_for_column["Field"]}"] == 0){
                                                echo "<label for='{$changed}'>{$changed} </label><br>";
                                                echo "<input class='form-check-input' type='checkbox' value='1' name='".$row_for_column["Field"]."' id='flexCheckDefault'> TAK";
                                            }else{
                                                echo "<label for='{$changed}'>{$changed} </label><br>";
                                                echo "<input class='form-check-input' type='checkbox' value='1' name='".$row_for_column["Field"]."' id='flexCheckDefault' checked> TAK";
                                            }
                                            
                                        }else{
                                            echo "<label for='{$changed}'>{$changed}</label>";
                                            echo "<input name='{$row_for_column["Field"]}' value='{$row_for_item_kat["{$row_for_column["Field"]}"]}' type='text' class='form-control' id='{$changed}' aria-describedby='emailHelp' placeholder='' required>";
                                        }
                                        echo "</div>";
                                    }
                                }
                                echo "<label class='form-label' for='customFile'>Zdjęcie</label><br>";
                                if($row_for_item_kat["status"] == 0){
                                    echo "<img style='width: 100px;' src='../images/image{$row_for_item_kat["item_id"]}.{$row_for_item_kat["ext"]}' class='card-img-top' alt='...'>";
                                }else{
                                    echo "<img style='width: 100px;' src='../images/placeholder.jpg' class='card-img-top' alt='...'>";
                                }
                                echo "<input type='hidden' name='item_id' value='{$_GET["item_ID"]}'>";
                            ?>
                            
                            <input type="file" class="form-control" name="file" id="customFile" />  
                            <br><button type='submit' class='btn btn-primary'>Edytuj przedmiot</button>
                        </form>
                        
                    </div>   
                </div>
                <div class="col-3 ">
                </div>
            </div>  
        </article>
        <footer class="footer text-end container-fluid text-light bg-secondary">
            @ Cezary Borkowski
        </footer>
        <script src="../skrypty/script.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    </body>
</html>