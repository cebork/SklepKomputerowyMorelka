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
    
    echo "<table class='table table-striped'>
        <tbody>";
        if(isset($_GET["phrase"])){
            $query_item = "SELECT * FROM podkategorie p, items it, images im WHERE it.item_id = im.item_id AND it.podkategoria_id = p.podkategoria_id AND (nazwa LIKE '%$phrase%' OR p.podkategoria_nazwa LIKE '%$phrase%') AND usuniety = 0";
        }else{
            $query_item = "SELECT * FROM podkategorie p, items it, images im WHERE it.item_id = im.item_id AND it.podkategoria_id = p.podkategoria_id  AND usuniety = 0";
        }
        
        $result_item = $connection->query($query_item);
        if($result_item->num_rows > 0){
            while($row_item = $result_item->fetch_assoc()){
                echo "<tr>";
                echo "<td>";
                if($row_item["status"] == 0){
                    echo "<td><a href='../content/szczegoly.php?tabela={$row_item["podkategoria_nazwa_tabeli"]}&item_id={$row_item["item_id"]}'><img style='width: 100px;' src='../images/image{$row_item["item_id"]}.{$row_item["ext"]}' class='card-img-top' alt='...'></a> <b style='font-size: 35px'>{$row_item["nazwa"]}</b></td>";
                }else{
                    echo "<td><a href='../content/szczegoly.php?tabela={$row_item["podkategoria_nazwa_tabeli"]}&item_id={$row_item["item_id"]}'><img style='width: 100px;' src='../images/placeholder.jpg' class='card-img-top' alt='...'></a> <b style='font-size: 35px'>{$row_item["nazwa"]}</b></td>";
                }
                echo "</td>";
                echo "<td>Podkategoria: {$row_item["podkategoria_nazwa"]}</td>"; 
                echo "<td><a href='../formularze/editForm.php?item_ID={$row_item["item_id"]}&kategoria={$row_item["podkategoria_nazwa_tabeli"]}'>Edytuj</a></td>"; 
                echo "<td><a href='../CRUD/deleteItem.php?item_ID={$row_item["item_id"]}&kategoria={$row_item["podkategoria_nazwa_tabeli"]}'>Usun</a></td>"; 
                echo "</tr>";
            }
        }
    echo "</tbody>
    </table>";
?>