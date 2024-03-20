<?php
session_start();

// Cancella tutte le variabili di sessione, impostando la sessione come array vuoto
$_SESSION = array();

// Se la sessione utilizza i cookie, 
if (ini_get("session.use_cookies")) {
    // ottiene i parametri dei cookies e li inserisce nella variabile params
    $params = session_get_cookie_params();
    // setcookie per impostare il cookie di sessione vuoto con una scadenza nel passato
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Cancella la sessione
session_destroy();

// Reindirizza l'utente alla pagina principale
header("location: ../main.php");
exit;