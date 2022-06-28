<br>
<h1 class="display-6 d-flex justify-content-center">Ustaw wartośći</h1>
<form id="formularz" method="POST" action="../CRUD/itemadd.php" enctype="multipart/form-data">
    <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "morelka";

        $connection = new mysqli($servername, $username, $password, $dbname);

        if($connection->connect_error){
            die("Connection faild:".$connection->connect_error);
        }
        echo "<input type='hidden' name='kateg' value='{$_GET["tabela"]}'";

        $quick_cat = "SELECT podkategoria_id FROM podkategorie WHERE podkategoria_nazwa_tabeli='{$_GET["tabela"]}'";
        $result_quick_cat = $connection->query($quick_cat);
        if($result_quick_cat->num_rows > 0){
            $row_quick_cat =  $result_quick_cat->fetch_assoc();
            $nrkat = $row_quick_cat["podkategoria_id"];
        }
        
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
                    echo "<input name='{$row_for_column["Field"]}' type='date' class='form-control' id='{$changed}' aria-describedby='emailHelp' placeholder='' required>";
                }else if($row_for_column["Field"] == "podkategoria_id"){
                    echo "<input type='hidden' name='nrkat' value='{$nrkat}'";
                }else if(preg_match("/int*/", $row_for_column["Type"]) || $row_for_column["Type"] == "float"){
                    echo "<label for='{$changed}'>{$changed}</label>";
                    echo "<input name='{$row_for_column["Field"]}' type='number' class='form-control' id='{$changed}' aria-describedby='emailHelp' placeholder='' required>";
                }else{
                    echo "<label for='{$changed}'>{$changed}</label>";
                    echo "<input name='{$row_for_column["Field"]}' type='text' class='form-control' id='{$changed}' aria-describedby='emailHelp' placeholder='' required>";
                }     
                
                echo "</div>";
            }
        }
        
        $query_for_column = "SHOW COLUMNS FROM {$_GET["tabela"]}";
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
                    echo "<label for='{$changed}'>{$changed} </label><br>";
                    echo "<input class='form-check-input' type='checkbox' value='1' name='".$row_for_column["Field"]."' id='flexCheckDefault'> TAK";
                }else{
                    echo "<label for='{$changed}'>{$changed}</label>";
                    echo "<input name='{$row_for_column["Field"]}' type='text' class='form-control' id='{$changed}' aria-describedby='emailHelp' placeholder='' required>";
                }
                echo "</div>";
            }
        }
    ?>
    <label class="form-label" for="customFile">Zdjęcie</label>
    <input type="file" class="form-control" name="file" id="customFile" />  
    <br><button type='submit' class='btn btn-primary'>Dodaj przedmiot</button>
</form>