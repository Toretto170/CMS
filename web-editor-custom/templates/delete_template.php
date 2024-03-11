<?php
session_start();

// Check per vedere se l'utente si è autenticato
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: ../main.php");
    exit;
}

include("../scripts/connection_db.php");

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
<style>
body{
    background-color: #444;
}
.container{
    background-color: white;
}
</style>
<body>
    <div class="container">
        <h1>Template successfully deleted</h1>
</body>
</html>';
header("refresh:2;url=collection_templates.php");
    } else {
        echo "Errore durante l'eliminazione del template: " . $conn->error;
    }
} else {
    echo "ID del template non fornito.";
}

// Chiudi la connessione
$conn->close();

