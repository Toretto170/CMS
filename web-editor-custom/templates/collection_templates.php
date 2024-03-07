<?php
session_start();

// Check per vedere se l'utente si è autenticato
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: ../main.php");
    exit;
}

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


// Query per estrarre i template dell'utente
$user_id = $_SESSION['user_id'];
$sql = "SELECT id, reg_date FROM templates WHERE user_id=? ORDER BY reg_date DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Chiudi la connessione
$stmt->close();
$conn->close();
?>

<!-- Pagina della Collection dei Template -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Template Collection</title>
    <link rel="stylesheet" type="text/css" href="collection_style.css">
</head>
<body>
<a href="../pages/home.php"><img src="../img/home.png" id="home"></a>
<h1 class="title">Template Collection</h1>
<div class="user">
    <img src="../img/user.png" id="user">
    <div class="user-menu">
        <ul class="hover-menu">
            <li><a href="../pages/logout.php">Logout</a></li>
        </ul>
    </div>
    </div>
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
    echo "<td>";
    echo "<a href='../web-editor/web_editor.php?id=" . $row['id'] . "'> Edit</a>";
    echo " | ";
    echo "<a href='../templates/delete_template.php?id=" . $row['id'] . "'>Delete</a>";
    echo "</td>";
    echo "</tr>";

    }
    ?>
</table>
</body>
</html>