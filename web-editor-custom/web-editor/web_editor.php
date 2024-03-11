<?php
session_start();

// Check per vedere se l'utente si è autenticato
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: ../main.php");
    exit;
}

include("../scripts/connection_db.php");

// Se l'ID del template non è fornito, crea un nuovo template e ottieni l'ID
if (!isset($_GET['id'])) {
    // Verifica se esiste già un template con HTML e CSS vuoti per l'utente corrente
    $user_id = $_SESSION['user_id'];
    $sql_check_template = "SELECT id FROM templates WHERE html='' AND css='' AND user_id='$user_id'";
    $result_check_template = $conn->query($sql_check_template);
    if ($result_check_template && $result_check_template->num_rows > 0) {
        // Se esiste già un template con HTML e CSS vuoti, ottieni il suo ID
        $row = $result_check_template->fetch_assoc();
        $template_id = $row['id'];
    } else {
        // Altrimenti, inserisci un nuovo template con HTML e CSS vuoti
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
$sql = "SELECT html, css FROM templates WHERE id=?";
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
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['html']) && isset($_POST['css']) && !empty($_POST['html']) && !empty($_POST['css'])) {
    // Assicurati che i dati siano stati inviati correttamente
    $html = $_POST['html'];
    $css = $_POST['css'];

    // Escape dei dati prima dell'inserimento nel database per evitare SQL injection
    $html = mysqli_real_escape_string($conn, $html);
    $css = mysqli_real_escape_string($conn, $css);

    // Esegui un'operazione di aggiornamento del template nel database
    $sql_update_data = "UPDATE templates SET html=?, css=?, reg_date=NOW() WHERE id=? AND user_id=?";
    $stmt = $conn->prepare($sql_update_data);
    $stmt->bind_param("ssii", $html, $css, $template_id, $_SESSION['user_id']);
    if ($stmt->execute()) {
        echo "Template aggiornato con successo. \r\n";
    } else {
        echo 'Errore: ' . $conn->error;
    }
    exit;
}

// Chiudi la connessione
$stmt->close();
$conn->close();
?>

<!-- EDITOR DI GRAPESJS -->

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
<div id="top-bar">
    <a href="../pages/home.php"><img src="../img/home.png" id="home"></a>
    <img src="../img/save.png" id="save">
    <div class="user">
    <img src="../img/user.png" id="user">
    <div class="user-menu">
        <ul class="hover-menu">
            <li><a href="../pages/logout.php">Logout</a></li>
        </ul>
    </div>
    </div>

    <!-- BLOCCO PER L'UPLOAD
    <button id="load">Load your Code</button>
        <div id="code-input">
            <textarea id="html-input" placeholder="paste your html here"></textarea>
            <textarea id="css-input" placeholder="paste your css here"></textarea>
            <button id="apply-code"> Apply code</button>
        </div> -->
</div>
<div id="gjs">
    <h1 id="title">Web Editor</h1>
</div>

<div id="blocks"></div>

<script src="web_editor_script.js"> </script>
    <!--
    const editor = grapesjs.init ({
        container: "#gjs",
        fromElement: true,
        height: '689px',
        width: 'auto',

        // storage
        storageManager: {
            type: 'remote',
            autosave: false,
            urlStore: 'local'
        },

        // nessun pannello di default
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

     -->
<script>
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
            url: 'web_editor.php?id=<?php echo $template_id; ?>',
            method: 'POST',
            data: { html: html, css: css },
            success: function (response) {
                alert(response);
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });

    /*
        CODICE PER L'UPLOAD
    $('#load').on('click', function () {
        $('#code-input').show();
    });

    // Aggiungi l'evento click al pulsante "Apply Code"
    $('#apply-code').on('click', function () {
        var htmlCode = $('#html-input').val();
        var cssCode = $('#css-input').val();

        // Applica il codice HTML e CSS al web editor
        editor.setComponents(htmlCode);
        editor.setStyle(cssCode);

        // Nascondi l'area di inserimento del codice
        $('#code-input').hide();
    });

     */
</script>
</body>
</html>