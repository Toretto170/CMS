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
<button id="save" onclick="saveTemplate()">Save your work</button>
<script>
    function saveTemplate(){
        var html = editor.getHtml();
        var css = editor.getCss();


// Effettuare una richiesta AJAX per inviare i testi al server PHP
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'db.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {

                alert(xhr.responseText);
            }
        };
        xhr.send('html=' + encodeURIComponent(html) + '&css=' + encodeURIComponent(css));


        /* editor.setComponents(html);
        editor.setStyle(css); */
    };

</script>
<div id="gjs">
    <h1 id="title">Web Editor</h1>
</div>


<div id="blocks"></div>
<script src="web_editor_script.js"></script>
</body>
</html>
