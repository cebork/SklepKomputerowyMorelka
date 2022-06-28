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

        <link rel="stylesheet" href="style/style.css">
        <script src="script.js"></script>
    </head> 
    <body>
        <header class="header container-fluid position-fixed bg-primary">
            <div class="row">
                <div class="col-2">
                    <a class="text-decoration-none link-dark" href="main.php"><h1 class="display-4">morelka</h2></a>
                </div>
                <div class="col-8 ">
                    <ul class="nav nav-pills ">
                        <li class="nav-item ">
                            <a class="nav-link text-dark display-6 mask" style="" aria-current="page" href="content/kategorie.php?tabela=komputery&page=1">Komputery</a>
                        </li>
                        <li class="nav-item dropdown ">
                            <a class="nav-link dropdown-toggle text-dark display-6 mask" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Podzespoły</a>
                            <ul class="dropdown-menu">
                                <?php
                                    $query_for_kategorie = "SELECT * FROM podkategorie p, kategorie k WHERE p.kategoria_id = k.kategoria_id AND k.nazwa = 'Podzespoły'";
                                    $result_for_kategorie = $connection->query($query_for_kategorie);
                                    if($result_for_kategorie->num_rows > 0){
                                        while($row_for_kategorie = $result_for_kategorie->fetch_assoc()){
                                            echo "<li><a class='dropdown-item' href='content/kategorie.php?tabela={$row_for_kategorie["podkategoria_nazwa_tabeli"]}&page=1'>{$row_for_kategorie["podkategoria_nazwa"]}</a></li>";
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
                                            echo "<li><a class='dropdown-item' href='content/kategorie.php?tabela={$row_for_kategorie["podkategoria_nazwa_tabeli"]}&page=1'>{$row_for_kategorie["podkategoria_nazwa"]}</a></li>";
                                        }
                                    }
                                ?>
                            </ul>
                        </li>
                        <li id="ranking" class="nav-item ">
                            <a class="nav-link text-dark display-6 mask" style="" aria-current="page" href="content/ranking.php">Ranking</a>
                        </li>
                    </ul>
                </div>
                <div class="col-2 text-end koszyk_profil">
                    <ul class="nav nav-pills ">
                        <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-dark mask koszyk_profil" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false"><img src="images/person.svg" width="50" height="50"/></a>
                            <ul class="dropdown-menu">
                                <?php
                                   
                                    if(isset($_SESSION["nazwa"])){
                                        if($_SESSION["nazwa"] == 'user'){
                                            echo "
                                            <li><a class='dropdown-item' href='formularze/editProfileFrom.php'>Edytuj profil</a></li>
                                            <li><a class='dropdown-item' href='content/historia.php'>Historia zamówienia</a></li>
                                            <li><a class='dropdown-item' href='CRUD/logout.php' >Wyloguj się</a></li>
                                            ";
                                        }else if($_SESSION["nazwa"] == 'pracownik'){
                                            echo "
                                            <li><a class='dropdown-item' href='formularze/editProfileFrom.php'>Edytuj profil</a></li>
                                            <li><a class='dropdown-item' href='content/historia.php'>Historia zamówienia</a></li>
                                            <li><a class='dropdown-item' href='CRUD/itemadd.php'>Dodaj przedmiot</a></li>
                                            <li><a class='dropdown-item' href='content/editDeleteItem.php'>Edycja i usuwanie przedmiotów</a></li>
                                            <li><a class='dropdown-item' href='content/orderUpdate.php'>Aktualizacja zamówień</a></li>
                                            <li><a class='dropdown-item' href='CRUD/logout.php'>Wyloguj się</a></li>
                                            ";
                                        }else if($_SESSION["nazwa"] == 'szef'){
                                            echo "
                                            <li><a class='dropdown-item' href='formularze/editProfileFrom.php'>Edytuj profil</a></li>
                                            <li><a class='dropdown-item' href='content/historia.php'>Historia zamówienia</a></li>
                                            <li><a class='dropdown-item' href='CRUD/itemadd.php'>Dodaj przedmiot</a></li>
                                            <li><a class='dropdown-item' href='content/editDeleteItem.php'>Edycja i usuwanie przedmiotów</a></li>
                                            <li><a class='dropdown-item' href='content/orderUpdate.php'>Aktualizacja zamówień</a></li>
                                            <li><a class='dropdown-item' href='content/pracownicy.php'>Pracownicy</a></li>
                                            <li><a class='dropdown-item' href='content/raporty.php'>Raporty</a></li>
                                            <li><a class='dropdown-item' href='CRUD/logout.php'>Wyloguj się</a></li>
                                            ";
                                        }
                                    }else{
                                        echo "<li><a class='dropdown-item' href='formularze/loginForm.php'>Zaloguj się</a></li>";
                                    }
                                ?>

                            </ul>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link text-dark mask koszyk_profil" aria-current="page" href="content/koszyk.php">
                                <img src="images/bag.svg" width="50" height="50"/>
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
                <div class="col-12">
                    <h1 class="display-4 d-flex justify-content-center">Bestsellery</h1>
                    <hr>
                    <div id="carouselExampleCaptions" class="carousel bg-secondary slide d-flex justify-content-center" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
                            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="3" aria-label="Slide 4"></button>
                            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="4" aria-label="Slide 5"></button>
                        </div>
                        <div class="carousel-inner" style="width: 700px;">
                            <?php
                                $x = 0;
                                $query_for_carusel = "select * FROM items i, podkategorie p WHERE i.podkategoria_id = p.podkategoria_id ORDER BY kupione DESC LIMIT 5";

                                $result_for_carusel = $connection->query($query_for_carusel);
                                if($result_for_carusel->num_rows > 0){
                                    while($row_for_carusel = $result_for_carusel->fetch_assoc()){
                                        echo "<div class='carousel-item"; 
                                        if($x == 0){
                                            echo " active'>";
                                            $x = 1;
                                        }else{
                                            echo " '>";
                                        }

                                        echo "<a href='content/szczegoly.php?tabela={$row_for_carusel["podkategoria_nazwa_tabeli"]}&item_id={$row_for_carusel["item_id"]}'>";
                                            $query_image = "SELECT * FROM images WHERE item_id = {$row_for_carusel["item_id"]}";
                                            $result_image = $connection->query($query_image);
                                            if($result_image->num_rows > 0){
                                                while($row_images = $result_image->fetch_assoc()){
                                                    if($row_images["status"] == 0){
                                                        echo "<img src='images/image{$row_for_carusel["item_id"]}.{$row_images["ext"]}' class='card-img-top' alt='...'>";
                                                    }else{
                                                        echo "<img src='images/placeholder.jpg' class='card-img-top' alt='...'>";
                                                    }
                                                }
                                            }
                                        echo "</a>
                                            <div class='carousel-caption d-none d-md-block'>
                                                <h5>{$row_for_carusel["nazwa"]}</h5>
                                                <p>{$row_for_carusel["cena"]} PLN</p>
                                            </div>
                                        </div>";
                                    }
                                }
                            ?>
                        </div>
                        <button class="caruselpom carousel-control-prev bg-dark" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="caruselpom carousel-control-next bg-dark" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>
        </article>
        <footer class="footer text-end container-fluid text-light bg-secondary">
            @ Cezary Borkowski
        </footer>
        <script src="skrypty/script.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    </body>
</html>