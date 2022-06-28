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
    if(isset($_GET["phrase"])){
        $phrase = $_GET["phrase"];
    }
        if(isset($_GET["phrase"])){
            $query_for_users = "SELECT * FROM users u, dane_personalne d WHERE d.user_id = u.user_id AND u.user_id <> ALL (SELECT e.user_id FROM employees e) AND (d.imie LIKE '%$phrase%' OR d.nazwisko LIKE '%$phrase%')";
        }else{
            $query_for_users = "SELECT * FROM users u, dane_personalne d WHERE d.user_id = u.user_id AND u.user_id <> ALL (SELECT e.user_id FROM employees e)";
        }
        
        $result_for_users = $connection->query($query_for_users);
        if($result_for_users->num_rows > 0){
            echo "<table class='table table-striped'>
                    <thead>
                        <th>Imię</th>
                        <th>Nazwisko</th>
                        <th>Pobory</th>
                    </thead>
                    <tbody>";
            while($row_for_users = $result_for_users->fetch_assoc()){
                echo "<tr>";
                echo "<td>";
                echo $row_for_users["imie"];
                echo "</td>";
                echo "<td>";
                echo $row_for_users["nazwisko"];
                echo "</td>";
                echo "<td>
                    <form method='POST' action='../CRUD/zatrudnij.php'>
                        <input style='width: 150px;' class='form-control' type='number' name='pobory' required>
                        <input style='float: right;' type='hidden' name='user_id' value='{$row_for_users["user_id"]}'>
                        <input value='Zatrudnij' class='btn btn-primary' type='submit' name='sbmt'>
                    </form>";
                echo "</tr>";
            }
        }else{
            echo "<h3 class='display-6 d-flex justify-content-center'>Brak użytkowników</h3>";
        }
    echo "</tbody>
    </table>";
?>
                        
                        
            