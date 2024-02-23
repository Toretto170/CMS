<?php
$filepath = "../zipProva/grapesjs_template_1708599033792.zip";


/*  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    Verifica che sia stato caricato un file
        if (!empty($_FILES['zipFile']['name'])) {
        $zipFileName = $_FILES['zipFile']['name'];
        $zipTmpName = $_FILES['zipFile']['tmp_name']; */

        // Crea una cartella temporanea per l'estrazione
        $extractFolder = "./cartella_temporanea";
        mkdir($extractFolder);

        // Esegui l'estrazione del file ZIP
        $zip = new ZipArchive;
        if ($zip->open($filepath) === TRUE) {
            $zip->extractTo($extractFolder);
            $zip->close();

            $html = file_get_contents($extractFolder . "/index.html");
            $css = file_get_contents($extractFolder . "/css/style.css");

            //roba su db
            
            
            $host = 'localhost';
            $username = 'root';
            $password = '';
            $database = 'prova';

            // Create connection
            $conn = new mysqli($host, $username, $password, $database);
            if ($conn->connect_error) {
                die('Connection failed : ' . $conn->connect_error);
            }
            echo 'Connected successfully';

            // Select the created database
            $conn->select_db($database);

            // SQL to create table
            $sql_create_table = "CREATE TABLE IF NOT EXISTS zipponi (
                    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    html LONGTEXT NOT NULL,
                    css LONGTEXT NOT NULL,
                    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                    )";


            if ($conn->query($sql_create_table) === TRUE) {
                echo "Table created successfully";
            } else {
                echo 'Error creating table: ' . $conn->error;
            }


            // Escape dei dati prima di inserirli nella query
            $html = mysqli_real_escape_string($conn, $html);
            $css = mysqli_real_escape_string($conn, $css);


            

            $sql_insert_data = "INSERT INTO zipponi (html, css, reg_date) VALUES ('$html', '$css', NOW())";

            if ($conn->query($sql_insert_data) === TRUE) {
                echo 'New record created successfully';
            } else {
                echo 'Error: ' . $sql_insert_data . '<br>' . $conn->error;
            }

            $conn->close();
            
            
            //elimina file all'interno della cartella temporanea
            unlink($extractFolder . "/index.html");
            unlink($extractFolder . "/css/style.css");



            // Elimina la cartella temporanea
            rmdir($extractFolder . "/css");
            rmdir($extractFolder);

            echo "Caricamento completato con successo.";
        } else {
            echo "Errore durante l'estrazione del file ZIP.";
        }
/*     } else {
        echo "Si prega di selezionare un file ZIP.";
    } */
//}

?>