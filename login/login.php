<?php
// Connessione al database
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "try";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica connessione
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

// Controllo se l'utente è già loggato
session_start();
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true){
    // Utente già loggato, reindirizza alla pagina del web editor
    header("location: home.php");
    exit;
}

// Gestione dei dati del form di login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Preleva i dati inviati dal form
    $login_username = $_POST['login_username'];
    $login_password = $_POST['login_password'];

    // Query preparata per verificare le credenziali nel database
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username=?");
    $stmt->bind_param("s", $login_username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        // Utente trovato, verifica la password
        $stmt->bind_result($user_id, $stored_password);
        $stmt->fetch();

        if($login_password === $stored_password) {
            // Utente autenticato con successo
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['user_id'] = $user_id;
            // Puoi aggiungere qui eventuali altre informazioni sull'utente
            header("location: home.php");
            exit;
        }
    } else {
        // Utente non trovato nel database
        echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email already taken</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            text-align: center;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333;
        }
        p {
            color: #666;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>You shall not pass!</h1>
        <p> Please Sign Up <a href="main.php">here</a> and come join us!</p>
    </div>
</body>
</html>';
    }

    $stmt->close();
}

// Chiudi la connessione
$conn->close();

