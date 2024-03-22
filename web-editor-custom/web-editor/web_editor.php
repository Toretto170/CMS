<?php
session_start();

// =================================================================================
//Moduli:

// Autenticazione utente
include("../modules/authentication_user.php");
// Connessione con il db
include("../modules/connection_db.php");
// Logica che gestisce l'inserimento, la modifica e la cancellazione del template
include("../modules/template_manager.php");

// =================================================================================

?>
<!-- EDITOR DI GRAPESJS -->
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Per modificare l'icona nella tab del browser -->
    <link rel="icon" href="../img/editor.png" type="image/png">
    <!-- --------------------------------------------- -->
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
    <input type="text" id="template-name" placeholder="Enter template name">
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
<script>
    // Carica il template nel GrapesJS
    var html = `<?php echo $template_data['html']; ?>`;
    var css = `<?php echo $template_data['css']; ?>`;
    editor.setComponents(html);
    editor.setStyle(css);

    // Aggiunge l'evento click al pulsante "Save"
    $('#save').on('click', function () {
        var html = editor.getHtml();
        var css = editor.getCss();
        var templateName = $('#template-name').val(); // Ottieni il nome del template dall'input

        // Effettua una richiesta AJAX per salvare o aggiornare il template nel database
        $.ajax({
            url: 'web_editor.php?id=<?php echo $template_id; ?>',
            method: 'POST',
            data: { html: html, css: css, name: templateName }, // Includi il nome del template nella richiesta
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

    // Aggiunge l'evento click al pulsante "Apply Code"
    $('#apply-code').on('click', function () {
        var htmlCode = $('#html-input').val();
        var cssCode = $('#css-input').val();

        // Applica il codice HTML e CSS al web editor
        editor.setComponents(htmlCode);
        editor.setStyle(cssCode);

        // Nasconde l'area di inserimento del codice
        $('#code-input').hide();
    });

     */
</script>
</body>

</html>