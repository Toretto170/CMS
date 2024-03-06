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
$sql = "SELECT id, reg_date FROM templates WHERE user_id=?";
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
        /* Stili CSS per la tabella */
        /* Questo è solo un esempio, puoi personalizzare i tuoi stili */
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
<h1>Template Collection</h1>
<table>
    <tr>
        <th>ID</th>
        <th>Last Save</th>
        <th>Actions</th>
    </tr>
    <?php
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['reg_date'] . "</td>";
        echo "<td><a href='web_editor.php?id=" . $row['id'] . "'>Edit</a></td>";
        echo "</tr>";
    }
    ?>
</table>
<p><a href="home.php">Back to Home</a></p>
</body>
</html>
