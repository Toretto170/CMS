<?php
session_start();

include("../scripts/connection_db.php");

// Creazione del db
$sql_create_database = "CREATE DATABASE IF NOT EXISTS $database";
if ($conn->query($sql_create_database) === TRUE) {
    echo "Database '$database' creato con successo.\r\n";
} else {
    echo "Errore nella creazione del database '$database': " . $conn->error;
}

// Selezione del database
$conn->select_db($database);

// Creazione della tabella 'users'
$sql_create_users_table = "CREATE TABLE IF NOT EXISTS users (
            id BIGINT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            password VARCHAR(255) NOT NULL
            )";

// check per vedere se la tabella users è stata creata con successo oppure no
if ($conn->query($sql_create_users_table) === TRUE) {
    echo "Tabella 'users' creata con successo.\r\n";
} else {
    echo "Errore nella creazione della tabella 'users': " . $conn->error;
}

// Creazione della tabella 'templates'
$sql_create_templates_table = "CREATE TABLE IF NOT EXISTS templates (
            id BIGINT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            html LONGTEXT NOT NULL,
            css LONGTEXT NOT NULL,
            reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            user_id INT(6) UNSIGNED,
            FOREIGN KEY (user_id) REFERENCES users(id)
            )";

// check per vedere se la tabella templates è stata creata con successo
if ($conn->query($sql_create_templates_table) === TRUE) {
    echo "Tabella 'templates' creata con successo.\r\n";
} else {
    echo "Errore nella creazione della tabella 'templates': " . $conn->error;
}

// chiusura della connessione
$conn->close();

