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
                    <h1 class="display-4 d-flex justify-content-center">Dodawanie przedmiotów</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-3 "></div>
                <div class="col-6 ">
                    <label for="wyborkat">Wybór kategorii: </label>    
                    <select id="cat" class="choose form-select" aria-label="Default select example" onchange="kategorie()">
                    <option>Wybierz kategorie</option>
                        <?php
                            $query_for_kategorie = "SELECT * FROM podkategorie";
                            $result_for_kategorie = $connection->query($query_for_kategorie);
                            if($result_for_kategorie->num_rows > 0){
                                while($row_for_kategorie = $result_for_kategorie->fetch_assoc()){
                                    echo "<option value={$row_for_kategorie["podkategoria_nazwa_tabeli"]}>{$row_for_kategorie["podkategoria_nazwa"]}</option>";
                                }
                            }
                        ?>
                    </select>
                    <div id="formularz">
                    <?php 
                        if(isset($_POST["nazwa"])){

                        
                        $insert_query = "INSERT INTO items (";
                        $query_for_column = "SHOW COLUMNS FROM items";
                        $result_for_column = $connection->query($query_for_column);
                        if($result_for_column->num_rows > 0){
                            for($i = 0; $i < $result_for_column->num_rows; $i++){
                                $row_for_column =  $result_for_column->fetch_assoc();
                                if($i == 0 || $i == 3 || $i == 13){
                                    continue;
                                }
                                if($i == $result_for_column->num_rows - 2 ){
                                    $insert_query .= $row_for_column["Field"].") VALUES (";
                                }else{
                                    $insert_query .= $row_for_column["Field"].", ";
                                }
                                
                            }
                        }
                        $licz = 0;
                        $isfirst = true;
                        foreach( $_POST as $key=>$stuff ) {
                            if($isfirst){
                                $isfirst = false;
                                continue;
                            }
                            if($key == 'cena'){
                                $insert_query .= $stuff.")";
                                break;
                            }
                            $licz++;
                            $insert_query .= "'".$stuff."', ";
                        }
                        if($connection->query($insert_query) === TRUE){
                            echo "<br>
                            <div class='alert alert-success' role='alert'>
                                Dodano nowy przedmiot
                            </div>";
                        }else{
                            echo "<div class='alert alert-danger' role='alert'>";
                            echo "Error: " . $insert_query . "<br>" . $connection->error;
                            echo "</div>";
                        }
                        $query_max_id = "SELECT max(item_id) as id FROM items";
                        $result_max_id = $connection->query($query_max_id);
                        if($result_max_id->num_rows > 0){
                            $row_max_id = $result_max_id->fetch_row();
                            $max_id = $row_max_id[0];
                        }



                        $insert_query = "INSERT INTO {$_POST["kateg"]} (";
                        $query_for_column = "SHOW COLUMNS FROM {$_POST["kateg"]}";
                        $result_for_column = $connection->query($query_for_column);
                        if($result_for_column->num_rows > 0){
                            for($i = 0; $i < $result_for_column->num_rows; $i++){
                                $row_for_column =  $result_for_column->fetch_assoc();
                                if($i == 0){
                                    continue;
                                }
                                if($i == $result_for_column->num_rows - 1 ){
                                    $insert_query .= "`" . $row_for_column["Field"]."`) VALUES (";
                                }else{
                                    $insert_query .= "`" . $row_for_column["Field"]."`, ";
                                }
                                
                            }
                        }
                        $licz2 = -1;
                        $isfirst = true;
                        foreach( $_POST as $key=>$stuff ) {
                            
                            //echo $key;
                            if($isfirst){
                                $isfirst = false;
                                continue;
                            }
                            if($licz2 != $licz){
                                $licz2++;
                                continue;
                            }
                            $insert_query .= "'" . $stuff."', ";
                        }
                        if($row_for_column["Field"] == "czy_bezprzewodowa"){
                            if(!isset($_POST["czy_bezprzewodowa"])){
                                $insert_query .= 0 . ",";
                            }
                        }
                        
                        $insert_query .= $max_id. ")";
                        //echo $insert_query;
                        if($connection->query($insert_query) === TRUE){
                            echo "
                            <div class='alert alert-success' role='alert'>
                                Upewnienie sie :D
                            </div>";
                        }else{
                            echo "<div class='alert alert-danger' role='alert'>";
                            echo "Error: " . $insert_query . "<br>" . $connection->error;
                            echo "</div>";
                        }
                    }
                    if(isset($_FILES["file"])){
                        $query_insert_image = "INSERT INTO images (item_id, status, ext) VALUES ($max_id, 1, 'nofile')";
                        $connection->query($query_insert_image);
                        $file = $_FILES['file'];

                        $fileName = $_FILES['file']['name'];
                        $filetmpName = $_FILES['file']['tmp_name'];
                        $size = $_FILES['file']['size'];
                        $error = $_FILES['file']['error'];
                        $type= $_FILES['file']['type'];

                        $fileExt = explode('.', $fileName);
                        $fileActualExt = strtolower(end($fileExt));
                        $allowed = array('jpg', 'jpeg', 'png', '');
                        if(in_array($fileActualExt, $allowed)){
                            if($error === 0){
                                if($size < 500000){
                                    $fileNameNew = "image".$max_id.".".$fileActualExt;
                                    $fileDestination = '../images/'.$fileNameNew;
                                    move_uploaded_file($filetmpName, $fileDestination);
                                    $query_insert_image = "UPDATE images SET status=0, ext='{$fileActualExt}' WHERE item_id = {$max_id}";
                                    $connection->query($query_insert_image);
                                }else{
                                    // echo "Plik jest za  duży";
                                }
                            }else{
                                // echo "Błąd przy dodawaniu pliku";
                            }
                        }else{
                            // echo "Niedozwolone rozszerzenie pliku";
                        }
                    }
                    

                    ?>
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