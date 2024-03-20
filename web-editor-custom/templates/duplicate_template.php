<?php
session_start();
$_SESSION['success_message'] = "Template successfully duplicated!";
$_SESSION['error_message'] = "Cannot duplicate the template";


include("../modules/authentication_user.php");
include("../modules/connection_db.php");

if(isset($_GET['id'])) {
    $template_id = $_GET['id'];

    // Verifica che il template appartenga all'utente autenticato
    $user_id = $_SESSION['user_id'];
    $check_query = "SELECT * FROM templates WHERE id=? AND user_id=?";
    $check_stmt = $conn->prepare($check_query);
    $check_stmt->bind_param("ii", $template_id, $user_id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if($check_result->num_rows == 1) {
        // Estrai il template originale
        $fetch_query = "SELECT html, css FROM templates WHERE id=?";
        $fetch_stmt = $conn->prepare($fetch_query);
        $fetch_stmt->bind_param("i", $template_id);
        $fetch_stmt->execute();
        $template_result = $fetch_stmt->get_result();

        if ($template_result->num_rows == 1) {
            $template_row = $template_result->fetch_assoc();
            $html_content = $template_row['html'];
            $css_content = $template_row['css'];

            // Inserisci un nuovo record con il contenuto del template originale
            $insert_query = "INSERT INTO templates (user_id, html, css) VALUES (?, ?, ?)";
            $insert_stmt = $conn->prepare($insert_query);
            $insert_stmt->bind_param("iss", $user_id, $html_content, $css_content);
            $insert_stmt->execute();

            if ($insert_stmt->affected_rows == 1) {
                $_SESSION['success_message'] = "Template successfully duplicated!";
                // Alert per la registrazione avvenuta con successo
                echo "<script>alert('Template successfully duplicated');
                    window.location.href = 'collection_templates.php'</script>";
                exit(); // Assicurati di uscire dallo script dopo l'header

            } else {
                $_SESSION['error_message'] = "Cannot duplicate the template";
                // Alert per la registrazione avvenuta con successo
                echo "<script>alert('Cannot duplicate the template');</script>";
            }

        }
    }
}

// Chiudi la connessione con il database
$conn->close();
