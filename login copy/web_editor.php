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

// Se l'ID del template non è fornito, crea un nuovo template e ottieni l'ID
if (!isset($_GET['id'])) {
    $sql = "INSERT INTO templates (html, css, user_id) VALUES ('', '', ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $template_id = $stmt->insert_id;
    $stmt->close();
} else {
    $template_id = $_GET['id'];
}

// Preleva il template corrispondente dall'ID fornito
$sql = "SELECT html, css FROM templates WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $template_id);
$stmt->execute();
$result = $stmt->get_result();

// Verifica se il template esiste
if ($result->num_rows != 1) {
    echo "Template non trovato.";
    exit;
}

$template_data = $result->fetch_assoc();

// Chiudi la connessione
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Editor</title>
    <link rel="stylesheet" href="//unpkg.com/grapesjs/dist/css/grapes.min.css">
    <link rel="stylesheet" type="text/css" href="web_editor_style.css">
    <script src="//unpkg.com/grapesjs"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<button id="save">Save your work</button>

<div id="gjs">
    <h1 id="title">Web Editor</h1>
</div>

<div id="blocks"></div>

<script>
    const editor = grapesjs.init ({
        container: "#gjs",
        fromElement: true,
        height: '689px',
        width: 'auto',

        // storage
        storageManager: {
            type: 'remote',
            autosave: true,
            urlStore: 'local'
        },

        //nessun pannello di default
        panels:{default: [] },

        // editor di blocchi
        blockManager: {
            appendTo: '#blocks',
            blocks: [
                {
                    id: 'section',
                    label: '<b> Section </b>',
                    attributes: {class: 'gjs-block-section'},
                    content: `<section>
                <h1> This is a simple title </h1>
                <div> This is just an example text </div>
                </section>`,
                }, {
                    id: 'text',
                    label: 'Text',
                    content: '<div data-gjs-type = "text"> Insert your text here </div>',
                }, {
                    id: 'image',
                    label: 'Image',
                    // seleziona il componente una volta che è stato droppato
                    select: true,
                    // definizione del component-type
                    content: {type: 'image'},
                    activate: true,
                }
            ]
        }
    });

    // Carica il template nel GrapesJS
    var html = `<?php echo $template_data['html']; ?>`;
    var css = `<?php echo $template_data['css']; ?>`;
    editor.setComponents(html);
    editor.setStyle(css);

    // Aggiungi l'evento click al pulsante "Save"
    $('#save').on('click', function () {
        var html = editor.getHtml();
        var css = editor.getCss();

        // Effettua una richiesta AJAX per salvare o aggiornare il template nel database
        $.ajax({
            url: 'db.php',
            method: 'POST',
            data: { id: <?php echo $template_id; ?>, html: html, css: css },
            success: function (response) {
                alert(response);
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });
</script>
</body>
</html>
