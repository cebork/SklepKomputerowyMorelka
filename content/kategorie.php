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
            <div class="row">
                <div class="szukanie col-3">
                    <?php
                        echo "<form method='GET' action='../content/kategorie.php?tabela={$_GET["tabela"]}'>";
                    ?>
                    <h2 class="display-5">Sortowanie</h2>
                    <select class="form-select" name='sort'aria-label="Default select example">
                        <?php
                            
                            if(isset($_POST["sort"])){
                                if($_POST["sort"] == 1){
                                    echo "
                                        <option value='1' selected>Domyślne</option>
                                        <option value='2'>Sortowanie A-Z</option>
                                        <option value='3'>Sortowanie Z-A</option>
                                        <option value='4'>Sortowanie od najtańszego</option>
                                        <option value='5'>Sortowanie od najdroższego</option>
                                    ";
                                }else if($_POST["sort"] == 2){
                                    echo "
                                        <option value='1'>Domyślne</option>
                                        <option value='2' selected>Sortowanie A-Z</option>
                                        <option value='3'>Sortowanie Z-A</option>
                                        <option value='4'>Sortowanie od najtańszego</option>
                                        <option value='5'>Sortowanie od najdroższego</option>
                                    ";
                                }else if($_POST["sort"] == 3){
                                    echo "
                                        <option value='1'>Domyślne</option>
                                        <option value='2'>Sortowanie A-Z</option>
                                        <option value='3' selected>Sortowanie Z-A</option>
                                        <option value='4'>Sortowanie od najtańszego</option>
                                        <option value='5'>Sortowanie od najdroższego</option>
                                    ";
                                }else if($_POST["sort"] == 4){
                                    echo "
                                        <option value='1'>Domyślne</option>
                                        <option value='2'>Sortowanie A-Z</option>
                                        <option value='3'>Sortowanie Z-A</option>
                                        <option value='4' selected>Sortowanie od najtańszego</option>
                                        <option value='5'>Sortowanie od najdroższego</option>
                                    ";
                                }else if($_POST["sort"] == 5){
                                    echo "
                                        <option value='1'>Domyślne</option>
                                        <option value='2'>Sortowanie A-Z</option>
                                        <option value='3'>Sortowanie Z-A</option>
                                        <option value='4'>Sortowanie od najtańszego</option>
                                        <option value='5' selected>Sortowanie od najdroższego</option>
                                    ";
                                }
                            } else if(isset($_GET["sort"])){
                                if($_GET["sort"] == 1){
                                    echo "
                                        <option value='1' selected>Domyślne</option>
                                        <option value='2'>Sortowanie A-Z</option>
                                        <option value='3'>Sortowanie Z-A</option>
                                        <option value='4'>Sortowanie od najtańszego</option>
                                        <option value='5'>Sortowanie od najdroższego</option>
                                    ";
                                }else if($_GET["sort"] == 2){
                                    echo "
                                        <option value='1'>Domyślne</option>
                                        <option value='2' selected>Sortowanie A-Z</option>
                                        <option value='3'>Sortowanie Z-A</option>
                                        <option value='4'>Sortowanie od najtańszego</option>
                                        <option value='5'>Sortowanie od najdroższego</option>
                                    ";
                                }else if($_GET["sort"] == 3){
                                    echo "
                                        <option value='1'>Domyślne</option>
                                        <option value='2'>Sortowanie A-Z</option>
                                        <option value='3' selected>Sortowanie Z-A</option>
                                        <option value='4'>Sortowanie od najtańszego</option>
                                        <option value='5'>Sortowanie od najdroższego</option>
                                    ";
                                }else if($_GET["sort"] == 4){
                                    echo "
                                        <option value='1'>Domyślne</option>
                                        <option value='2'>Sortowanie A-Z</option>
                                        <option value='3'>Sortowanie Z-A</option>
                                        <option value='4' selected>Sortowanie od najtańszego</option>
                                        <option value='5'>Sortowanie od najdroższego</option>
                                    ";
                                }else if($_GET["sort"] == 5){
                                    echo "
                                        <option value='1'>Domyślne</option>
                                        <option value='2'>Sortowanie A-Z</option>
                                        <option value='3'>Sortowanie Z-A</option>
                                        <option value='4'>Sortowanie od najtańszego</option>
                                        <option value='5' selected>Sortowanie od najdroższego</option>
                                    ";
                                }
                            }else{
                                echo "
                                    <option value='1' selected>Domyślne</option>
                                    <option value='2'>Sortowanie A-Z</option>
                                    <option value='3'>Sortowanie Z-A</option>
                                    <option value='4'>Sortowanie od najtańszego</option>
                                    <option value='5'>Sortowanie od najdroższego</option>
                                ";
                            }
                        ?>
                        
                    </select>
                    <br>
                    <h2 class="display-5">Filtrowanie</h2>
                    <label for="minPrice" class="form-label"><b>Cena</b></label>
                    <div class="input-group mb-3">
                        <?php
                            echo "<input type='hidden' name='tabela' value='{$_GET["tabela"]}'>";
                            $query_min_max = "SELECT max(cena) as max, min(cena) as min FROM komputery k, items i";
                            $result_min_max = $connection->query($query_min_max);
                            if($result_min_max->num_rows > 0){
                                $row_min_max = $result_min_max->fetch_assoc();
                                $max_value = $row_min_max['max'];
                                $min_value = $row_min_max['min'];  
                            }
                        
                                    
                            if(isset($_POST["minPrice"]) && isset($_POST["minPrice"])){
                                echo "<input type='number' class='form-control float-start' name='minPrice' value='{$_POST["minPrice"]}' id='minPrice' aria-describedby='minPrice'>
                                <pre> - </pre>
                                <input type='number' class='form-control float-start' name='maxPrice' value='{$_POST["maxPrice"]}' id='maxPrice' aria-describedby='maxPrice'>
                                <pre> PLN </pre>";
                            }else if(isset($_POST["minPrice"])){
                                echo "<input type='number' class='form-control float-start' name='minPrice' value='{$_POST["minPrice"]}' id='minPrice' aria-describedby='minPrice'>
                                <pre> - </pre>
                                <input type='number' class='form-control float-start' name='maxPrice' value='{$max_value}' id='maxPrice' aria-describedby='maxPrice'>
                                <pre> PLN </pre>";
                            }else if(isset($_POST["maxPrice"])){
                                echo "<input type='number' class='form-control float-start' name='minPrice' value='{$min_value}' id='minPrice' aria-describedby='minPrice'>
                                <pre> - </pre>
                                <input type='number' class='form-control float-start' name='maxPrice' value='{$_POST["maxPrice"]}' id='maxPrice' aria-describedby='maxPrice'>
                                <pre> PLN </pre>";
                            }else if(isset($_GET["minPrice"]) && isset($_GET["minPrice"])){
                                echo "<input type='number' class='form-control float-start' name='minPrice' value='{$_GET["minPrice"]}' id='minPrice' aria-describedby='minPrice'>
                                <pre> - </pre>
                                <input type='number' class='form-control float-start' name='maxPrice' value='{$_GET["maxPrice"]}' id='maxPrice' aria-describedby='maxPrice'>
                                <pre> PLN </pre>";
                            }else{
                                echo "<input type='number' class='form-control float-start' name='minPrice' value='{$min_value}' id='minPrice' aria-describedby='minPrice'>
                                <pre> - </pre>
                                <input type='number' class='form-control float-start' name='maxPrice' value='{$max_value}' id='maxPrice' aria-describedby='maxPrice'>
                                <pre> PLN </pre>";
                            }
                            
                        ?>
                    </div>
                        <?php
                            $query_kategorie = "SHOW COLUMNS FROM {$_GET["tabela"]}";
                            $result_query_kategorie = $connection->query($query_kategorie);
                            $licznik = 0;
                            if($result_query_kategorie->num_rows > 0){
                                for($i = 0; $i < $result_query_kategorie->num_rows; $i++){
                                    $row_for_kategorie = $result_query_kategorie->fetch_assoc();
                                    if($i == 0 ||  $i == $result_query_kategorie->num_rows - 1){
                                        continue;
                                    }
                                    $changed = str_replace("_", " ", $row_for_kategorie["Field"]);
                                    $changed = mb_convert_case($changed, MB_CASE_TITLE );
                                    echo "<h5 class='card-title'>{$changed}</h5>";
                                    $query_for_kategorie2 = "SELECT * FROM {$_GET["tabela"]} k, items i WHERE i.item_id = k.item_id GROUP BY k.{$row_for_kategorie["Field"]}";
                                    $result_query_for_kategorie2 = $connection->query($query_for_kategorie2);
                                    if($result_query_for_kategorie2->num_rows > 0){
                                        while($row_for_kategorie2 = $result_query_for_kategorie2->fetch_assoc()){
                                            echo "<div class='form-check'>";
                                                    if(isset($_POST[$row_for_kategorie['Field'].$licznik]) || isset($_GET[$row_for_kategorie['Field'].$licznik])){
                                                        echo "<input class='form-check-input' type='checkbox' value='".$row_for_kategorie2["{$row_for_kategorie["Field"]}"]."' name='".$row_for_kategorie['Field'].$licznik."' id='flexCheckDefault' checked>";
                                                    } else {
                                                        echo "<input class='form-check-input' type='checkbox' value='".$row_for_kategorie2["{$row_for_kategorie["Field"]}"]."' name='".$row_for_kategorie['Field'].$licznik."' id='flexCheckDefault'>";
                                                    }
                                                    echo "<label class='form-check-label' for='flexCheckDefault'>";
                                                        if($row_for_kategorie["Field"] == 'czy_bezprzewodowa'){
                                                            if($row_for_kategorie2["{$row_for_kategorie["Field"]}"] == 1){
                                                                echo "TAK";
                                                            }else{
                                                                echo "NIE";
                                                            }
                                                        }else{
                                                            echo $row_for_kategorie2["{$row_for_kategorie["Field"]}"];
                                                        }
                                                    echo "</label>
                                                </div>";
                                            $licznik++;
                                        }
                                    }
                                    $licznik = 0;
                                }
                            }
                        ?>
                        <button type="submit" class="btn btn-primary">Filtruj</button>
                    </form>
                    
                </div>
                <div class="col-9">
                    <?php
                        function t1($val, $min, $max){
                            return ($val >= $min & $val <= $max );
                        }
                        
                        $page = isset($_GET['page']) ? intval($_GET['page'] - 1) : 0;
                        $limit = 15;
                        $from = $page * $limit;
                        $condition = array();
                        $condition2 = array();
                        $query_filtr = "SHOW COLUMNS FROM {$_GET["tabela"]}";
                            $result_query_filtr = $connection->query($query_filtr);
                            $licznik = 0;
                            $licznik_query_rows = 0;
                            if(isset($_POST['minPrice'])){
                                $condition[$licznik_query_rows][0] = "cena >= ";
                                $condition[$licznik_query_rows][1] = $_POST["minPrice"];
                                $condition2[$licznik_query_rows][0] = "minPrice=";
                                $condition2[$licznik_query_rows][1] = $_POST["minPrice"];
                                $licznik_query_rows++;
                            }
                            if(isset($_POST['maxPrice'])){
                                $condition[$licznik_query_rows][0] = "cena <= ";
                                $condition[$licznik_query_rows][1] = $_POST["maxPrice"];
                                $condition2[$licznik_query_rows][0] = "maxPrice=";
                                $condition2[$licznik_query_rows][1] = $_POST["maxPrice"];
                                $licznik_query_rows++;
                            }
                            if(isset($_GET['minPrice'])){
                                $condition[$licznik_query_rows][0] = "cena >= ";
                                $condition[$licznik_query_rows][1] = $_GET["minPrice"];
                                $condition2[$licznik_query_rows][0] = "minPrice=";
                                $condition2[$licznik_query_rows][1] = $_GET["minPrice"];
                                $licznik_query_rows++;
                            }
                            if(isset($_GET['maxPrice'])){
                                $condition[$licznik_query_rows][0] = "cena <= ";
                                $condition[$licznik_query_rows][1] = $_GET["maxPrice"];
                                $condition2[$licznik_query_rows][0] = "maxPrice=";
                                $condition2[$licznik_query_rows][1] = $_GET["maxPrice"];
                                $licznik_query_rows++;
                            }
                            if($result_query_filtr->num_rows > 0){
                                for($i = 0; $i < $result_query_filtr->num_rows; $i++){
                                    $row_for_filtr = $result_query_filtr->fetch_assoc();
                                    if($i == 0 ||  $i == $result_query_filtr->num_rows - 1){
                                        continue;
                                    }
                                    
                                    $query_for_filtr2 = "SELECT * FROM {$_GET["tabela"]} k, items i WHERE i.item_id = k.item_id GROUP BY k.{$row_for_filtr["Field"]}";
                                    $result_query_for_filtr2 = $connection->query($query_for_filtr2);
                                    if($result_query_for_filtr2->num_rows > 0){
                                        while($row_for_filtr2 = $result_query_for_filtr2->fetch_assoc()){
                                            if(isset($_POST[$row_for_filtr["Field"].$licznik])){
                                                $condition[$licznik_query_rows][0] = $row_for_filtr["Field"]."='"; 
                                                $condition[$licznik_query_rows][1] = $_POST[$row_for_filtr["Field"].$licznik]."'";
                                                $condition2[$licznik_query_rows][0] = $row_for_filtr["Field"].$licznik."='"; 
                                                $condition2[$licznik_query_rows][1] = $_POST[$row_for_filtr["Field"].$licznik]."'";
                                                $licznik_query_rows++;
                                            }else if(isset($_GET[$row_for_filtr['Field'].$licznik])){
                                                $condition[$licznik_query_rows][0] = $row_for_filtr["Field"]."='"; 
                                                $condition[$licznik_query_rows][1] = $_GET[$row_for_filtr["Field"].$licznik]."'";
                                                $condition2[$licznik_query_rows][0] = $row_for_filtr["Field"].$licznik."='"; 
                                                $condition2[$licznik_query_rows][1] = $_GET[$row_for_filtr["Field"].$licznik]."'";
                                                $licznik_query_rows++;
                                            }
                                            $licznik++;
                                        }
                                    }
                                    $licznik = 0;
                                }
                            }
                            if(isset($_POST["sort"])){
                                if($_POST["sort"] == 1){
                                    $condition[$licznik_query_rows][0] = ""; 
                                    $condition[$licznik_query_rows][1] = "";
                                    $condition2[$licznik_query_rows][0] = "sort="; 
                                    $condition2[$licznik_query_rows][1] = $_POST["sort"];
                                }else if($_POST["sort"] == 2){
                                    $condition[$licznik_query_rows][0] = "ORDER BY "; 
                                    $condition[$licznik_query_rows][1] = "nazwa ";
                                    $condition2[$licznik_query_rows][0] = "sort="; 
                                    $condition2[$licznik_query_rows][1] = $_POST["sort"];
                                }else if($_POST["sort"] == 3){
                                    $condition[$licznik_query_rows][0] = "ORDER BY "; 
                                    $condition[$licznik_query_rows][1] = "nazwa DESC ";
                                    $condition2[$licznik_query_rows][0] = "sort="; 
                                    $condition2[$licznik_query_rows][1] = $_POST["sort"];
                                }else if($_POST["sort"] == 4){
                                    $condition[$licznik_query_rows][0] = "ORDER BY "; 
                                    $condition[$licznik_query_rows][1] = "cena ";
                                    $condition2[$licznik_query_rows][0] = "sort="; 
                                    $condition2[$licznik_query_rows][1] = $_POST["sort"];
                                }else if($_POST["sort"] == 5){
                                    $condition[$licznik_query_rows][0] = "ORDER BY "; 
                                    $condition[$licznik_query_rows][1] = "cena DESC ";
                                    $condition2[$licznik_query_rows][0] = "sort="; 
                                    $condition2[$licznik_query_rows][1] = $_POST["sort"];
                                }
                            }
                            if(isset($_GET["sort"])){
                                if($_GET["sort"] == 1){
                                    $condition[$licznik_query_rows][0] = ""; 
                                    $condition[$licznik_query_rows][1] = "";
                                    $condition2[$licznik_query_rows][0] = "sort="; 
                                    $condition2[$licznik_query_rows][1] = $_GET["sort"];
                                }elseif($_GET["sort"] == 2){
                                    $condition[$licznik_query_rows][0] = "ORDER BY "; 
                                    $condition[$licznik_query_rows][1] = "nazwa ";
                                    $condition2[$licznik_query_rows][0] = "sort="; 
                                    $condition2[$licznik_query_rows][1] = $_GET["sort"];
                                }else if($_GET["sort"] == 3){
                                    $condition[$licznik_query_rows][0] = "ORDER BY "; 
                                    $condition[$licznik_query_rows][1] = "nazwa DESC ";
                                    $condition2[$licznik_query_rows][0] = "sort="; 
                                    $condition2[$licznik_query_rows][1] = $_GET["sort"];
                                }else if($_GET["sort"] == 4){
                                    $condition[$licznik_query_rows][0] = "ORDER BY "; 
                                    $condition[$licznik_query_rows][1] = "cena ";
                                    $condition2[$licznik_query_rows][0] = "sort="; 
                                    $condition2[$licznik_query_rows][1] = $_GET["sort"];
                                }else if($_GET["sort"] == 5){
                                    $condition[$licznik_query_rows][0] = "ORDER BY "; 
                                    $condition[$licznik_query_rows][1] = "cena DESC ";
                                    $condition2[$licznik_query_rows][0] = "sort="; 
                                    $condition2[$licznik_query_rows][1] = $_GET["sort"];
                                }
                            }
                        if(!empty($condition)){
                            $query_for_items = "SELECT * FROM {$_GET["tabela"]} k, items i WHERE i.item_id = k.item_id AND usuniety = 0 AND (";
                            for($i = 0; $i < $licznik_query_rows; $i++){
                                if($i == 0){
                                    $query_for_items .= $condition[$i][0]."".$condition[$i][1];
                                }else{
                                    if($condition[$i][0] != $condition[$i - 1][0]){
                                        $query_for_items .= ") AND (".$condition[$i][0]."".$condition[$i][1];
                                    }else{
                                        $query_for_items .= " OR ".$condition[$i][0]."".$condition[$i][1];
                                    }
                                }
                                if($i == $licznik_query_rows - 1){
                                    $query_for_items .= ") ";
                                }
                            }
                            $query_for_items .= $condition[$i][0]."".$condition[$i][1];
                            $query_for_items .= "LIMIT {$from}, {$limit}";
                        } else{
                            $query_for_items = "SELECT * FROM {$_GET["tabela"]} k, items i WHERE i.item_id = k.item_id AND usuniety = 0 LIMIT {$from}, {$limit}";
                        }
                        $result_query_for_items = $connection->query($query_for_items);
                        if($result_query_for_items->num_rows > 0){
                            while($row_for_items = $result_query_for_items->fetch_assoc()){
                                echo "<div class='card float-start' style='width: 18rem; height: 35rem;'>
                                        <a href='../content/szczegoly.php?tabela={$_GET["tabela"]}&item_id={$row_for_items["item_id"]}'>";
                                        $query_image = "SELECT * FROM images WHERE item_id = {$row_for_items["item_id"]}";
                                        $result_image = $connection->query($query_image);
                                        if($result_image->num_rows > 0){
                                            while($row_images = $result_image->fetch_assoc()){
                                                if($row_images["status"] == 0){
                                                    echo "<img src='../images/image{$row_for_items["item_id"]}.{$row_images["ext"]}' class='card-img-top' alt='...'>";
                                                }else{
                                                    echo "<img src='../images/placeholder.jpg' class='card-img-top' alt='...'>";
                                                }
                                            }
                                        }
                                        echo "</a>
                                        <div class='card-body'>
                                            <h5 class='card-title'>{$row_for_items["nazwa"]}</h5>
                                            <p class='card-text'><b>Model:</b> {$row_for_items["model"]}<br>
                                            <b>Producent:</b> {$row_for_items["producent"]}<br></p>
                                            <p class='card-text'>
                                            <i>Dostępne:</i> <b>{$row_for_items["ilosc"]}</b> <i>Kupione:</i> <b>{$row_for_items["kupione"]}</b>
                                            </p>
                                            <p class='cena card-text'><b>Cena:</b> {$row_for_items["cena"]} <b>PLN</b></p>
                                            <form method='POST' action='../CRUD/toCart.php'>
                                                <input type='hidden' name='item_id' value='{$row_for_items["item_id"]}'>
                                                <input type='hidden' name='cena' value='{$row_for_items["cena"]}'>
                                                <input type='hidden' name='ilosc' value='1'>";
                                                if($row_for_items["ilosc"] == 0){
                                                    echo "<input class='btn btn-primary disabled' type='submit' name='subm' value='Dodaj do koszyka'>";
                                                } else {
                                                    echo "<input class='btn btn-primary' type='submit' name='subm' value='Dodaj do koszyka'>";
                                                }
                                            echo "</form>
                                        </div>
                                </div>";
                            }
                        } else {
                            echo "<h2 class='display-5 d-flex justify-content-center'>Brak przedmiotów spełniających kryteria</h2>";
                        }
                if(!empty($condition)){
                    $query_for_pages = "SELECT * FROM {$_GET["tabela"]} k, items i WHERE i.item_id = k.item_id AND (";
                    for($i = 0; $i < $licznik_query_rows; $i++){
                        if($i == 0){
                            $query_for_pages .= $condition[$i][0]."".$condition[$i][1];
                        }else{
                            if($condition[$i][0] != $condition[$i - 1][0]){
                                $query_for_pages .= ") AND (".$condition[$i][0]."".$condition[$i][1];
                            }else{
                                $query_for_pages .= " OR ".$condition[$i][0]."".$condition[$i][1];
                            }
                        }
                        if($i == $licznik_query_rows - 1){
                            $query_for_pages .= ")";
                        }
                    }
                } else{
                    $query_for_pages = "SELECT * FROM {$_GET["tabela"]} k, items i WHERE i.item_id = k.item_id";
                }
                $result_query_for_pages = $connection->query($query_for_pages);
                $paginacja = $result_query_for_pages->num_rows / $limit;
                $paginacja_int = intval($paginacja);
                
                if($paginacja > $paginacja_int){
                    $paginacja = $paginacja_int + 1;
                }
                echo "</div>";
                echo "<nav class='d-flex justify-content-center' aria-label='Page navigation example'>
                        <ul class='pagination'>
                            <li class='page-item'>";
                                $paginacja_link = "<a class='page-link' href='../content/kategorie.php?tabela={$_GET["tabela"]}&page=1";
                                for($i = 0; $i < $licznik_query_rows; $i++){
                                    $pom1 = str_replace("'", "", $condition2[$i][0]);
                                    $pom2 = str_replace("'", "", $condition2[$i][1]);
                                    $paginacja_link .= "&".$pom1."".$pom2;
                                }
                                if($i > 0){
                                    $paginacja_link .= "&".$condition2[$i][0]."".$condition2[$i][1];
                                }
                                $paginacja_link .= "' aria-label='Previous'>";
                                echo $paginacja_link;
                                echo "<span aria-hidden='true'>&laquo;</span>
                                </a>
                            </li>";
                            for($i = 1; $i <= $paginacja; $i++){
                                
                                $bold = ($i == ($page+1)) ? 'style="font-size:24px;"' : '';
                                if(t1($i, ($page - 1), ($page + 3))){
                                    $paginacja_link = "<li class='page-item'><a ".$bold."class='page-link' href='../content/kategorie.php?tabela={$_GET["tabela"]}&page=$i";
                                    for($j = 0; $j < $licznik_query_rows; $j++){
                                        $pom1 = str_replace("'", "", $condition2[$j][0]);
                                        $pom2 = str_replace("'", "", $condition2[$j][1]);
                                        $paginacja_link .= "&".$pom1."".$pom2;
                                    }
                                    if($j > 0){
                                        $paginacja_link .= "&".$condition2[$j][0]."".$condition2[$j][1];
                                    }
                                    $paginacja_link .= "'>$i</a></li>";
                                    echo $paginacja_link;
                                }
                            }
                            echo "<li class='page-item'>";
                                $paginacja_link = "<a class='page-link' href='../content/kategorie.php?tabela={$_GET["tabela"]}&page=$paginacja";
                                for($i = 0; $i < $licznik_query_rows; $i++){
                                    $pom1 = str_replace("'", "", $condition2[$i][0]);
                                    $pom2 = str_replace("'", "", $condition2[$i][1]);
                                    $paginacja_link .= "&".$pom1."".$pom2;
                                }
                                if($i > 0){
                                    $paginacja_link .= "&".$condition2[$i][0]."".$condition2[$i][1];
                                }
                                $paginacja_link .= "' aria-label='Next'>";
                                echo $paginacja_link;
                                echo "<span aria-hidden='true'>&raquo;</span>
                                </a>
                            </li>
                        </ul>
                    </nav>";
                ?>
            </div> 
            
        </article>
        <footer class="footer text-end container-fluid text-light bg-secondary">
            @ Cezary Borkowski
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    </body>
</html>
