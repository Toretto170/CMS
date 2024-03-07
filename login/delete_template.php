<?php
session_start();

// Check per vedere se l'utente si è autenticato
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: main.php");
    exit;
}

// Connessione al database
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "login";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica connessione
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

// Verifica se l'ID del template è stato fornito nella richiesta GET
if (isset($_GET['id'])) {
    // Escape dell'ID del template per evitare SQL injection
    $template_id = mysqli_real_escape_string($conn, $_GET['id']);

    // Query per eliminare il template dal database
    $sql_delete_template = "DELETE FROM templates WHERE id=? AND user_id=?";
    $stmt = $conn->prepare($sql_delete_template);
    $stmt->bind_param("ii", $template_id, $_SESSION['user_id']);

    if ($stmt->execute()) {
        echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Template deleted</title>
<link rel="stylesheet" href="template_style.css">
</head>
<body>
    <div class="container">
        <h1>Template successfully deleted</h1>
        <p> If you want to create a new one, click <a href="web_editor.php">here</a> or if you want to explore your templates click <a href="collection_templates.php">here</a> </p>
    </div>
</body>
</html>';
    } else {
        echo "Errore durante l'eliminazione del template: " . $conn->error;
    }
} else {
    echo "ID del template non fornito.";
}

// Chiudi la connessione
$conn->close();

