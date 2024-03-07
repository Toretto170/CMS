<?php
session_start(); 

// Connessione al db
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "login";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check della connessione con il db
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

// Check per vedere se l'utente si è autenticato
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true){
    // Utente già loggato, reindirizza alla pagina web_editor.php
    header("location: home.php");
    exit;
}

// Gestione dei dati del form di login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Preleva i dati inviati dal login
    $login_username = $_POST['login_username'];
    $login_password = $_POST['login_password'];

    // Query x verificare le credenziali presenti nel db
    $sql = "SELECT id, password FROM users WHERE username=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $login_username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Utente trovato, verifica la password
        $row = $result->fetch_assoc();
        if($login_password === $row['password']) {
            // Password corretta, impostazione delle variabili di sessione
            $_SESSION['loggedin'] = true;
            $_SESSION['user_id'] = $row['id'];
            // Reindirizzamento alla home
            header("location: home.php");
            exit;
        } else {
            // Password non corretta
            echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> OPS! Wrong password</title>
   <link rel="stylesheet" href="template_style.css">
</head>
<body>
    <div class="container">
        <h1> Seems like you fatfingered your password</h1>
        <p> Please insert again your passowrd <a href="main.php">here</a> </p>
    </div>
</body>
</html>';
        }
    } else {
        // Utente non trovato nel database
        echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email already taken</title>
<link rel="stylesheet" href="template_style.css">
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

$conn->close();

