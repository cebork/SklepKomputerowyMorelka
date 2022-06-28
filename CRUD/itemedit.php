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

    $licz = 0;

    $update_query = "UPDATE items SET ";
    $query_items_columns = "SHOW COLUMNS FROM items";
    $result_items_columns = $connection->query($query_items_columns);
    if($result_items_columns->num_rows > 0){
        for($i = 0; $i < $result_items_columns->num_rows; $i++){
            $row_items_columns = $result_items_columns->fetch_assoc();
            if($i == 0 || $i == 3 || $i == 11 || $i == 13){
                continue;
            }
            $update_query .= $row_items_columns["Field"] . " = ";
            $licznik_lokalny = 0;
            foreach( $_POST as $key=>$stuff ) {
                if($key == "kateg" || $key == "nrkat"){
                    continue;
                }

                if($licznik_lokalny != $licz){
                    $licznik_lokalny += 1;
                    continue;
                }
                echo $stuff;
                if($key == "cena"){
                    $update_query .= "'" . $stuff . "' WHERE item_id = " . $_POST["item_id"];
                    $licz += 1;           
                    break;
                }else{
                    $update_query .= "'" . $stuff . "', ";
                    $licz += 1;           
                    break;
                }
                
            }
            echo $row_items_columns["Field"];
            echo "<br>";
        }
            

    }
    $connection->query($update_query);


    $update_query = "UPDATE {$_POST["kateg"]} SET ";
    $query_items_columns = "SHOW COLUMNS FROM {$_POST["kateg"]}";
    $result_items_columns = $connection->query($query_items_columns);
    if($result_items_columns->num_rows > 0){
        for($i = 0; $i < $result_items_columns->num_rows - 1; $i++){
            $row_items_columns = $result_items_columns->fetch_assoc();
            if($i == 0 || $i == 3 || $i == 11 || $i == 11){
                continue;
            }
            $update_query .= $row_items_columns["Field"] . " = ";
            $licznik_lokalny = 0;
            foreach( $_POST as $key=>$stuff ) {
                if($key == "kateg" || $key == "nrkat" || $key == "item_id"){
                    continue;
                }

                if($licznik_lokalny != $licz){
                    $licznik_lokalny += 1;
                    continue;
                }
                if($key == "cena"){
                    $update_query .= "'" . $stuff . "' WHERE item_id = " . $_POST["item_id"];
                    $licz += 1;           
                    break;
                }else{
                    $update_query .= "'" . $stuff . "', ";
                    $licz += 1;           
                    break;
                }
                
            }
            
            echo $row_items_columns["Field"];
            echo "<br>";
        }
        if(!isset($_POST["czy_bezprzewodowa"])){
            $update_query .= 0;
        }
        $update_query .= " WHERE item_id = " . $_POST["item_id"];

    }
    $connection->query($update_query);

    if(isset($_FILES["file"])){
        $file = $_FILES['file'];

        $fileName = $_FILES['file']['name'];
        $filetmpName = $_FILES['file']['tmp_name'];
        $size = $_FILES['file']['size'];
        $error = $_FILES['file']['error'];
        $type= $_FILES['file']['type'];

        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));
        $allowed = array('jpg', 'jpeg', 'png');
        if(in_array($fileActualExt, $allowed)){
            if($error === 0){
                if($size < 5000000){
                    $fileNameNew = "image".$_POST["item_id"].".".$fileActualExt;
                    $fileDestination = '../images/'.$fileNameNew;
                    move_uploaded_file($filetmpName, $fileDestination);
                    $query_insert_image = "UPDATE images SET status=0, ext='{$fileActualExt}' WHERE item_id = {$_POST["item_id"]}";
                    echo $query_insert_image;
                    $connection->query($query_insert_image);
                }else{
                    echo "Plik jest za  duży";
                }
            }else{
                echo "Błąd przy dodawaniu pliku";
            }
        }else{
            echo "Niedozwolone rozszerzenie pliku";
        }
        echo $connection->error;
    }
    header("Location: ../content/editDeleteItem.php");
?>
