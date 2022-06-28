<?php
    session_start();
    $servername = "localhost";
    $username = "root";
    $passworddb = "";
    $dbname = "morelka";

    $connection = new mysqli($servername, $username, $passworddb, $dbname);

    if($connection->connect_error){
        die("Connection failed: " . $connection->connect_error);
    }
?>
<!DOCTYPE HTML>
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
        <article id="articlee" class="article container ">
            <div class="row">
                <div class="col-3">
                    <h2 class="display-5">Rejestracja</h2>
                    
                    <?php            
                        if(isset($_POST['create']) && isset($_POST['login']) && isset($_POST['password']) && isset($_POST['password_check']) && isset($_POST['email']) && isset($_POST['city']) && isset($_POST['postal']) && isset($_POST['address1']) && isset($_POST['address2'])){
                            $login = $_POST["login"];
                            $password = $_POST["password"];
                            $passwordCheck = $_POST["password_check"];
                            $imie = $_POST["imie"];
                            $nazwisko = $_POST["nazwisko"];
                            $email = $_POST["email"];
                            $phone = $_POST["phone"];
                            $city = $_POST["city"];
                            $postal = $_POST["postal"];
                            $address1 = $_POST["address1"];
                            $address2 = $_POST["address2"];
                            $uppercase = preg_match('@[A-Z]@', $password);
                            $lowercase = preg_match('@[a-z]@', $password);
                            $number    = preg_match('@[0-9]@', $password);
                            $specialChars = preg_match('@[^\w]@', $password);
                            if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
                            echo "<div class='alert alert-danger' role='alert'>Hasło powinno mieć conajmniej 8 znaków, zawierać małe i duże litery, oraz znaki specjalne!</div>";
                            }else if($password !== $passwordCheck){
                                echo "<div class='alert alert-danger' role='alert'>Hasła nie są identyczne!</div>";
                            }else{
                                $sql = "SELECT login, haslo FROM users WHERE login='$login'";
                                $result = $connection->query($sql);
                                if($result->num_rows > 0){
                                    $row = $result->fetch_assoc();
                                    $res = $row["login"];
                                } else{
                                    $res = 0;
                                }
                                $sql_insert = "INSERT INTO users (login, haslo, PL) VALUES ('$login', '$password', 0)";
                                if($res === $login){
                                    echo "<div class='alert alert-danger' role='alert'>Login jest zajęty</div>";
                                } else {
                                    if($connection->query($sql_insert) === TRUE){
                                    } else {
                                        echo "Error: " . $sql_insert . "<br>" . $connection->error;
                                    }
                                }
                                $quyer_maxID = "SELECT max(user_id) as maxID FROM users";
                                $result = $connection->query($quyer_maxID);
                                $row = $result->fetch_assoc();
                                $maxID = $row["maxID"];
                                if(isset($_POST['phone'])){
                                    $sql_insert = "INSERT INTO dane_personalne (user_id, imie, nazwisko, email, telefon, miejscowosc, kod_pocztowy, ulica, nr_domu) VALUES ('$maxID', '$imie', '$nazwisko', '$email', '$phone', '$city', '$postal', '$address1', '$address2')";
                                } else {
                                    $sql_insert = "INSERT INTO dane_personalne (user_id, imie, nazwisko, email, miejscowosc, kod_pocztowy, ulica, nr_domu) VALUES ('$maxID', '$imie', '$nazwisko', '$email', '$city', '$postal', '$address1', '$address2')";
                                }
                                if($connection->query($sql_insert) === TRUE){
                                    echo "<script> location.replace('../formularze/loginForm.php'); </script>";
                                } else {
                                    echo "Error: " . $sql_insert . "<br>" . $connection->error;
                                }
                            }
                        }
                    ?>
					<form method="POST" action="../formularze/registration.php">
						<div class="form-group">
							<label for="login">Login</label>
							<input name="login" type="text" class="form-control" id="login" aria-describedby="login" placeholder="Login" required>
						</div>
						<div class="form-group">
							<label for="password">Hasło</label>
							<input name="password" type="password" class="form-control" id="Password" placeholder="Hasło" required>
						</div>
                        <div class="form-group">
							<label for="password_check">Powtórz hasło</label>
							<input name="password_check" type="password" class="form-control" id="password_check" placeholder="Powtórz hasło" required>
						</div>
                        <div class="form-group">
							<label for="imie">Imię</label>
							<input name="imie" type="text" class="form-control" id="imie" placeholder="Podaj imię" required>
						</div>
                        <div class="form-group">
							<label for="nazwisko">Nazwisko</label>
							<input name="nazwisko" type="text" class="form-control" id="nazwisko" placeholder="Podaj nazwisko" required>
						</div>
                        <div class="form-group">
							<label for="email">E-mail</label>
							<input name="email" type="email" class="form-control" id="email" placeholder="E-mail" required>
						</div>
                        <div class="form-group">
							<label for="phone">Telefon</label>
							<input name="phone" type="number" class="form-control" id="phone" placeholder="Telefon">
						</div>
                        <div class="form-group">
							<label for="city">Miejscowość</label>
							<input name="city" type="text" class="form-control" id="city" placeholder="Miejscowość" required>
						</div>
                        <div class="form-group">
							<label for="postal">Kod pocztowy</label>
							<input pattern="^\d{2}-\d{3}$" name="postal" type="text" class="form-control" id="postal" placeholder="Kod pocztowy" required>
						</div>
                        <div class="form-group">
							<label for="address1">Ulica</label>
							<input name="address1" type="text" class="form-control" id="address1" placeholder="Ulica" required>
						</div>
                        <div class="form-group">
							<label for="address2">Numer domu</label>
							<input name="address2" type="text" class="form-control" id="address2" placeholder="Numer domu" required>
						</div>
                        <br>
						<button type="submit" name="create" class="btn btn-primary">Zarejestruj się</button>
						<a href="../formularze/loginForm.php"><button type="button" class="btn btn-outline-primary">Wróć</button></a>
					</form>
                </div>
            </div>
        </article>
        <footer class="footer-login text-end container-fluid text-light bg-secondary">
            @ Cezary Borkowski
        </footer>
		<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    </body> 
</html>
