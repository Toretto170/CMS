<?php
session_start();

// Verifica se l'utente è loggato
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: main.php");
    exit;
}

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

// Preleva i template dell'utente corrente dal database
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM templates WHERE user_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Chiudi la connessione
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Template Collection</title>
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
        a {
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Template Collection</h1>

    <p> This is your template collection </p>
    <?php
    // Controlla se ci sono template dell'utente
    if ($result->num_rows > 0) {
        // Mostra i template dell'utente
        while ($row = $result->fetch_assoc()) {
            echo "<p>Template ID: " . $row['id'] . "</p>";
            // Aggiungi un link o un pulsante per modificare il template
            echo '<p><a href="edit_template.php?id=' . $row['id'] . '">Edit Template</a></p>';
        }
    } else {
        echo "<p>No templates found.</p>";
    }
    ?>
    <p>If you want to create a new template, click <a href="web_editor.php">here</a>.</p>
    <p>If you want to explore your profile, please do so  <a href="home.php">here</a>.</p>
    <p>Logout <a href="logout.php">here</a>.</p>
</div>
</body>
</html>
