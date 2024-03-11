<?php
session_start();

include("../scripts/connection_db.php");

// Controllo se l'utente si è autenticato
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    // Utente già autenticato, reindirizza alla pagina home.php
    header("location: ../pages/home.php");
    exit;
}

// Gestione dei dati del form di login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Preleva i dati inviati dal login
    $login_username = $_POST['login_username'];
    $login_password = $_POST['login_password'];
    //Hash sulla password
    $login_password = hash('sha256', $login_password);

    // Query per verificare le credenziali presenti nel db
    $sql = "SELECT id, password FROM users WHERE username=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $login_username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Utente trovato, verifica la password
        $row = $result->fetch_assoc();
        if ($login_password === $row['password']) {
            // Password corretta, impostazione delle variabili di sessione
            $_SESSION['loggedin'] = true;
            $_SESSION['user_id'] = $row['id'];
            // Reindirizzamento alla home
            header("location: ../pages/home.php");
            exit;
        } else {
            // Password non corretta
            include("./errors/errors_login/error_password.html");
        }
    } else {
        // Email già presa
        include("./errors/errors_login/error_email.html");
    }

    $stmt->close();
}

$conn->close();

