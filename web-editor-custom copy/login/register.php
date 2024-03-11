<?php

include("../scripts/connection_db.php");

// Gestione dei dati del form di registrazione
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Preleva i dati inviati dal form
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    //Hash sulla password
    $password = hash('sha256', $password);
    // Controlla se l'username  è già presente nel database
    $sql_check_username = "SELECT * FROM users WHERE username='$username'";
    $result_username = $conn->query($sql_check_username);
    if ($result_username->num_rows > 0) {
        include("./errors/errors_register/taken_username.html");
    } else {
        // Controlla se l'email è già presente nel database
        $sql_check_email = "SELECT * FROM users WHERE email='$email'";
        $result_email = $conn->query($sql_check_email);
        if ($result_email->num_rows > 0) {
            include("./errors/errors_register/taken_email.html");
        } else {
            // Query per inserire i dati nel database
            $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";

            if ($conn->query($sql) === TRUE) {
                include ("account_created.html");
            } else {
                echo "Errore durante la registrazione: " . $conn->error;
            }
        }
    }
}

// Chiusura della connessione con il db
$conn->close();

