<?php
session_start();

// Database info
$host = '127.0.0.1';
$username = 'root';
$password = '';
$database = 'login';

// Connessione al database e validazione
$conn = new mysqli($host, $username, $password);
if ($conn->connect_error) {
    die('Connessione fallita : ' . $conn->connect_error);
}

// Creazione del database
$sql_create_database = "CREATE DATABASE IF NOT EXISTS $database";
if ($conn->query($sql_create_database) === TRUE) {
    echo "Database '$database' creato con successo.\r\n";
} else {
    echo "Errore nella creazione del database '$database': " . $conn->error;
}

// Selezione del database
$conn->select_db($database);

// Creazione della tabella users
$sql_create_users_table = "CREATE TABLE IF NOT EXISTS users (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            password VARCHAR(255) NOT NULL
            )";

if ($conn->query($sql_create_users_table) === TRUE) {
    echo "Tabella 'users' creata con successo.\r\n";
} else {
    echo "Errore nella creazione della tabella 'users': " . $conn->error;
}

// Creazione della tabella templates
$sql_create_templates_table = "CREATE TABLE IF NOT EXISTS templates (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            html LONGTEXT NOT NULL,
            css LONGTEXT NOT NULL,
            reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            user_id INT(6) UNSIGNED,
            FOREIGN KEY (user_id) REFERENCES users(id)
            )";

if ($conn->query($sql_create_templates_table) === TRUE) {
    echo "Tabella 'templates' creata con successo.\r\n";
} else {
    echo "Errore nella creazione della tabella 'templates': " . $conn->error;
}

$conn->close();
