<?php
session_start();

// Connessione al db
$host = '127.0.0.1';
$username = 'root';
$password = '';
$database = 'login';

// Check della connessione
$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die('Connessione fallita : ' . $conn->connect_error);
}

// Funzione per aggiornare un template nel database
function saveTemplate($html, $css, $user_id, $template_id = null) {
    global $conn;
    // Escape dei dati prima dell'inserimento nel database per evitare SQL injection
    $html = mysqli_real_escape_string($conn, $html);
    $css = mysqli_real_escape_string($conn, $css);

    // Check per vedere se un template è già presente nel db
    $sql_check_template = "SELECT id FROM templates WHERE html='$html' AND css='$css' AND user_id='$user_id'";
    $result_check_template = $conn->query($sql_check_template);
    if ($result_check_template && $result_check_template->num_rows > 0) {
        return 'Il template esiste già nel database.';
    }

    if ($template_id !== null) {

        // Update del template esistente + check in caso di errore
        $sql = "UPDATE templates SET html='$html', css='$css', reg_date=NOW() WHERE id='$template_id' AND user_id='$user_id'";
        if ($conn->query($sql) === TRUE) {
            return true;
        } else {
            return 'Errore: ' . $sql . '<br>' . $conn->error;
        }
    } else {
        return 'Template non specificato per l\'inserimento.';
    }
}
