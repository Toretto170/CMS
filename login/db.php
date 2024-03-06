<?php
session_start(); // Avvia la sessione

// Database info
$host = '127.0.0.1';
$username = 'root';
$password = '';
$database = 'login';

// Creazione della connessione al database e validazione
$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die('Connessione fallita : ' . $conn->connect_error);
}

echo "Connessione riuscita. \r\n";

// Seleziona il database
$conn->select_db($database);

// Verifica se l'utente è autenticato
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Se l'utente non è autenticato, reindirizza alla pagina di login
    header("location: login.php");
    exit;
}

// Prendi l'ID dell'utente dalla sessione
$user_id = $_SESSION['user_id'];

// Verifica se i dati del form sono stati inviati
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assicurati che i dati siano stati inviati correttamente
    if(isset($_POST['html']) && isset($_POST['css'])) {
        $html = $_POST['html'];
        $css = $_POST['css'];

        // Escape dei dati prima dell'inserimento nel database per evitare SQL injection
        $html = mysqli_real_escape_string($conn, $html);
        $css = mysqli_real_escape_string($conn, $css);

        // SQL per inserire il template associato all'utente
        $sql_insert_data = "INSERT INTO templates (html, css, reg_date, user_id) VALUES ('$html', '$css', NOW(), '$user_id')";

        if ($conn->query($sql_insert_data) === TRUE) {
            echo "Nuovo record creato con successo. \r\n";
        } else {
            echo 'Errore: ' . $sql_insert_data . '<br>' . $conn->error;
        }
    } else {
        echo "Errore: Dati non inviati correttamente.";
    }
}

$conn->close();

echo "Upload eseguito con successo.";

