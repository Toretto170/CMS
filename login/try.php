<?php
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

// Controllo se l'utente è già loggato
session_start();
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true){
    // Utente già loggato, reindirizza alla homepage
    header("location: home.php");
    exit;
}

// Gestione dei dati del form di login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Preleva i dati inviati dal form
    $login_username = $_POST['login_username'];
    $login_password = $_POST['login_password'];

    // Query preparata per verificare le credenziali nel database
    $stmt = $conn->prepare("SELECT id, username FROM users WHERE username=? AND password=?");
    $stmt->bind_param("ss", $login_username, $login_password);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        // Utente autenticato con successo
        $stmt->bind_result($user_id, $username);
        $stmt->fetch();
        session_start();
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username; // Salva il nome utente nella sessione
        $_SESSION['user_id'] = $user_id; // Salva l'id dell'utente nella sessione
        // Puoi aggiungere qui eventuali altre informazioni sull'utente
        header("location: home.php");
        exit;
    } else {
        // Credenziali non valide
        echo '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Error 401 - Unauthorized</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                text-align: center;
            }
            .error-container {
                margin-top: 100px;
            }
            .error-container h1 {
                font-size: 5rem;
                color: #333;
            }
            .error-container p {
                font-size: 1.2rem;
                color: #666;
            }
        </style>
    </head>
    <body>
        <div class="error-container">
            <h1>401</h1>
            <p>Error: Unauthorized</p>
            <p>Sorry, you are not authorized to access this page.</p>
            <p>Please, Sign up  <a href="main.php">here</a>.</p>
        </div>
    </body>
    </html>';
    }

    $stmt->close();
}

// Chiudi la connessione
$conn->close();

