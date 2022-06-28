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
    $login = 0;
    $login2 = 1;
    $password = 0;
    $password2 = 1;
    if(isset($_POST["loginbutton"])){
        if(isset($_POST["login"]) && $_POST["password"]){
            $login = $_POST["login"];
            $password = $_POST["password"];
            $sql = "SELECT login FROM users WHERE haslo='$password' AND login='$login'";
            $result = $connection->query($sql);
            $sql = "SELECT haslo FROM users WHERE haslo='$password' AND login='$login'";
            $result2 = $connection->query($sql);
            if($result->num_rows >= 1){
                $login2 = $result->fetch_array()[0];
                $password2 = $result2->fetch_row()[0];
            }else{
                $login2 = 0;
                $password2 = 0;
            }
            if($login === $login2 && $password === $password2){
                $query_session = "SELECT u.login, s.nazwa FROM ((users u LEFT JOIN employees e ON  u.user_id = e.user_id) LEFT JOIN stanowiska s ON e.stanowisko_id = s.stanowisko_id) WHERE u.login = '{$login}'";
                $result_session = $connection->query($query_session);
                if($result_session->num_rows > 0){
                    $row_session = $result_session->fetch_assoc();
                    if($row_session['nazwa'] == 'pracownik'){
                        $_SESSION["nazwa"] = 'pracownik';
                    }else if($row_session['nazwa'] == 'szef'){
                        $_SESSION["nazwa"] = 'szef';
                    }else{
                        $_SESSION["nazwa"] = 'user';
                    }
                }
                $_SESSION["login"] = $login;
                $query_status = "SELECT * FROM statusy s, zamowienia z, users u WHERE s.status_id = z.status_id AND z.user_id = u.user_id AND s.status = 'koszyk' AND u.login = '{$_SESSION["login"]}'";
                $result_status = $connection->query($query_status);
                if($result_status->num_rows == 0){
                    $query_koszyk = "INSERT INTO zamowienia (zamowienia.user_id, cena, status_id) VALUES ((SELECT users.user_id FROM users WHERE login = '{$_SESSION["login"]}'), 0, (SELECT status_id FROM statusy WHERE status = 'koszyk'))";
                    $connection->query($query_koszyk);
                    $row_status = $result_status->fetch_assoc();
                    $wartosc = 0;
                    if(isset($_COOKIE["koszyk"])){
                        $ciastko = unserialize($_COOKIE["koszyk"]);
                        $query_for_id_zam = "SELECT zamowienie";
                        for($i = 0; $i < count($ciastko); $i++){
                            $wartosc += $ciastko[$i][1]*$ciastko[$i][2];
                            
                            $query_zawartosc = "INSERT INTO zawartosczamowienia (zamówienie_id, item_id, ilosc, cena) VALUES ((SELECT zamowienia_id FROM statusy s, zamowienia z, users u WHERE s.status_id = z.status_id AND z.user_id = u.user_id AND u.login = '{$_SESSION["login"]}' AND s.status = 'koszyk'), {$ciastko[$i][0]}, {$ciastko[$i][2]}, {$ciastko[$i][1]})";
                            $connection->query($query_zawartosc);
                        }
                        $query_update_cena = "UPDATE zamowienia SET cena=$wartosc WHERE zamowienia_id=(SELECT zamowienia_id FROM statusy s, zamowienia z, users u WHERE s.status_id = z.status_id AND z.user_id = u.user_id AND u.login = '{$_SESSION["login"]}' AND s.status = 'koszyk')";
                        $connection->query($query_update_cena);
                        setcookie("koszyk", "", time() - 3600, "/");
                    }
                }
            }else{
                $errorr = "<div class='alert alert-danger' role='alert'>Login lub hasło jest niepoprawne</div>";
            }
        } else {
            $errorr = "<div class='alert alert-danger' role='alert'>Login lub hasło jest niepoprawne</div>";
        }
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
		<article id="articlee" class="article container ">
			<div class="row">
                <div class="col-3">
					<h2 class="display-5">Logowanie</h2>
					<?php
                        if(isset($_POST["login"]) && isset($_POST["password"])){
                            if($login === $login2 && $password === $password2){
                                echo "<script> location.replace('../main.php'); </script>";
                            }else{
                                echo $errorr;
                            }
                        }
					?>
					<form method="POST" action="../formularze/loginForm.php">
						<div class="form-group">
							<label for="login">Login</label>
							<input name="login" type="text" class="form-control" id="login" aria-describedby="login" placeholder="Login">
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1">Password</label>
							<input name="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
						</div><br>
						<button type="submit" name="loginbutton" class="btn btn-primary">Zaloguj</button>
						<a href="../formularze/registration.php"><button type="button" class="btn btn-outline-primary">Rejestracja</button></a>
					</form>
				</div>
			</div>
		</article>
        <footer class=" footer-login text-end container-fluid text-light bg-secondary">
            @ Cezary Borkowski
        </footer>
		<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
  	</body>
</html>