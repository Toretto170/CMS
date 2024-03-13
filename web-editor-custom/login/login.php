<?php
session_start();

// modulo della connessione al db
include("../scripts/connection_db.php");

// Controllo se l'utente si è autenticato
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {

    // se l'utente è già autenticato, lo reindirizza alla pagina home.php
    header("location: ../pages/home.php");
    exit;
}

// Gestione dei dati del form di login
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Prende i dati dal form di login
    $login_username = $_POST['login_username'];
    $login_password = $_POST['login_password'];

    //Hashing della password
    $login_password = hash('sha256', $login_password);

    // Query per verificare le credenziali presenti nel db
    $sql = "SELECT id, password FROM users WHERE username=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $login_username);
    $stmt->execute();
    $result = $stmt->get_result();

    // check per vedere se la query restituisce un record. Se trova un record -->
    if ($result->num_rows == 1) {

        // Utente trovato, verifica la password
        $row = $result->fetch_assoc();

        // se la password coincide allora definisce la sessione 
        if ($login_password === $row['password']) {
            $_SESSION['loggedin'] = true;
            $_SESSION['user_id'] = $row['id'];

            // Reindirizzamento alla home
            header("location: ../pages/home.php");
            exit;

        // se la password non è corretta, reindirizza alla pagina error_password
        } else {

            // Modulo: pagina html dell'errore con la password (password sbagliata)
            include("./errors/errors_login/error_password.html");
        }
    } else {
        // Modulo: pagina html dell'errore con la mail (email sbagliata)
        include("./errors/errors_login/error_email.html");
    }

    $stmt->close();
}

$conn->close();

