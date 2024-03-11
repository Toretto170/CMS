<?php
session_start();

// Verifica se utente è già autenticato, altrimenti lo reindirizza alla pagina principale
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
     include("template_deleted");
     
        header("refresh:2;url=collection_templates.php");
    } else {
        echo "Cannot deleted the template: " . $conn->error;
    }
} 

// Chiudi la connessione con il db
$conn->close();