<?php
    //manca da mettere la validazione della connessione
            
    //Database info
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'prova';

    // Create connection
    $conn = new mysqli($host, $username, $password, $database);
    if ($conn->connect_error) {
        die('Connection failed : ' . $conn->connect_error);
    }
    echo "Connected successfully. \r\n";
    
    // Select the created database
    $conn->select_db($database);

    $html = $_POST['html'];
    $css = $_POST['css'];

    // SQL to create table
    $sql_create_table = "CREATE TABLE IF NOT EXISTS htmlcss (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            html LONGTEXT NOT NULL,
            css LONGTEXT NOT NULL,
            reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )";


    if ($conn->query($sql_create_table) === TRUE) {
        echo "Table created successfully. \r\n";
    } else {
        echo 'Error creating table: ' . $conn->error;
    }


    // Data escape before insertion
    $html = mysqli_real_escape_string($conn, $html);
    $css = mysqli_real_escape_string($conn, $css);


    //Inserting data into the database

    $sql_insert_data = "INSERT INTO htmlcss (html, css, reg_date) VALUES ('$html', '$css', NOW())";

    if ($conn->query($sql_insert_data) === TRUE) {
        echo "New record created successfully. \r\n";
    } else {
        echo 'Error: ' . $sql_insert_data . '<br>' . $conn->error;
    }

    $conn->close();
    

    echo "Upload successful.";
    

?>
