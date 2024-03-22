<?php
include ("connection_db.php");

// Se l'ID del template non è fornito, crea un nuovo template e ottieni l'ID
if (!isset ($_GET['id'])) {
    $user_id = $_SESSION['user_id'];
    $sql_check_template = "SELECT id FROM templates WHERE html='' AND css='' AND user_id='$user_id'";
    $result_check_template = $conn->query($sql_check_template);

    if ($result_check_template && $result_check_template->num_rows > 0) {
        $row = $result_check_template->fetch_assoc();
        $template_id = $row['id'];
    } else {
        $sql = "INSERT INTO templates (html, css, user_id, reg_date) VALUES ('', '', ?, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $_SESSION['user_id']);
        $stmt->execute();
        $template_id = $stmt->insert_id;
        $stmt->close();
    }
} else {
    $template_id = $_GET['id'];
}

// Preleva il template corrispondente dall'ID fornito
$sql = "SELECT html, css, name FROM templates WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $template_id);
$stmt->execute();
$result = $stmt->get_result();

// Verifica se il template esiste
if ($result->num_rows != 1) {
    echo '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Template not found</title>
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
        <h1>Seems like the template you are looking for is vanished!</h1>
        <p> Please create a new one <a href="web_editor.php">here</a> or choose another one of yours <a href="../templates/collection_templates.php">!</p>
    </div>
    </body>
    </html>';
    exit;
}

$template_data = $result->fetch_assoc();

// Se i dati del form sono stati inviati, esegui l'aggiornamento del template
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset ($_POST) && isset ($_POST['html']) && isset ($_POST['css']) && isset ($_POST['name']) && !empty ($_POST['html']) && !empty ($_POST['css'])) {
    // Condizione per controllare se è stato fornito un nome per il template
    if (empty ($_POST['name'])) {
        // Se non è stato fornito un nome, allora manda un alert che chiede di inserire un nome per il template prima del salvataggio e non lo inserisce nel db
        echo "Please enter a name for the template";
        exit;
    }

    // Check per vedere che i dati siano stati inseriti correttamente
    $html = $_POST['html'];
    $css = $_POST['css'];
    $templateName = $_POST['name'];

    // Escape dei dati prima dell'inserimento nel database per evitare SQL injection
    $html = mysqli_real_escape_string($conn, $html);
    $css = mysqli_real_escape_string($conn, $css);
    $templateName = mysqli_real_escape_string($conn, $templateName);

    // Aggiornamento dei template sul db
    $sql_update_data = "UPDATE templates SET html=?, css=?, name=?, reg_date=NOW() WHERE id=? AND user_id=?";
    $stmt = $conn->prepare($sql_update_data);
    $stmt->bind_param("sssii", $html, $css, $templateName, $template_id, $_SESSION['user_id']);
    if ($stmt->execute()) {
        echo "Template successfully saved. \r\n";
    } else {
        echo 'Errore: ' . $conn->error;
    }
    exit;
}
