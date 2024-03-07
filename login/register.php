<?php

// Connessione al db
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "login";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check della connessione
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

// Gestione dei dati del form di registrazione
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Preleva i dati inviati dal form
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Controlla se l'username è già presente nel database
    $sql_check_username = "SELECT * FROM users WHERE username='$username'";
    $result_username = $conn->query($sql_check_username);
    if ($result_username->num_rows > 0) {
        echo '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email already taken</title>
    
  <link rel="stylesheet" href="template_style.css">
</head>
<body>
    <div class="container">
        <h1>Cannot complete the registration</h1>
        <p>Your registration was unsuccessful. Please retry <a href="main.php">here</a> with a valid username/email.</p>
    </div>
</body>
</html>';
    } else {
        // Controlla se l'email è già presente nel database
        $sql_check_email = "SELECT * FROM users WHERE email='$email'";
        $result_email = $conn->query($sql_check_email);
        if ($result_email->num_rows > 0) {
            echo '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email already taken</title>
  <link rel="stylesheet" href="template_style.css">
</head>
<body>
    <div class="container">
        <h1>Cannot complete the registration</h1>
        <p>Your registration was unsuccessful. Please retry <a href="main.php">here</a> with a valid username/email.</p>
    </div>
</body>
</html>';
        } else {
            // Query per inserire i dati nel database
            $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";

            if ($conn->query($sql) === TRUE) {
                echo '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Successful</title>
  <link rel="stylesheet" href="template_style.css">
</head>
<body>
    <div class="container">
        <h1>Registration Successful</h1>
        <p>Your registration was successful. You can now <a href="main.php">login</a> using your credentials.</p>
    </div>
</body>
</html>
';
            } else {
                echo "Errore durante la registrazione: " . $conn->error;
            }
        }
    }
}

// Chiusura della connessione
$conn->close();

