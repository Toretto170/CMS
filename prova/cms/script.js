// Pulsante preview
document.getElementById('previewButton').addEventListener('click', function() {
    // Contenuto modificato in CKEditor
    var editedContent = CKEDITOR.instances['editable-content'].getData();
    // Visualizzazione del contenuto modificato
    document.getElementById('previewArea').innerHTML = editedContent;
    // Area di preview
    document.getElementById('previewArea').style.display = 'block';
});

// Inizializzazione di CKEditor per il contenuto
CKEDITOR.inline('editable-content', {
    extraPlugins: 'sourcedialog',
    allowedContent: true
});
// Inizializzazione di CKEditor per il titolo
CKEDITOR.inline('editable-title', {
    extraPlugins: 'sourcedialog',
    allowedContent: true
});

// Attivare/disattivare la dark mode
function toggleDarkMode() {
    var body = document.body;
    body.classList.toggle("dark-mode");
}

//Download del file sorgente come html
function Scarica(){

    var divhtml = document.getElementsByClassName("cke_dialog_ui_input_textarea")[0];
    var testo = divhtml.querySelector("textarea").value;
    var blob = new Blob([testo], { type: 'text/plain' });
            
    var link = document.createElement('a');
    link.href = window.URL.createObjectURL(blob);
    link.download = 'testo_scaricato.html';
    
    document.body.appendChild(link);
    
    link.click();
    
    document.body.removeChild(link);
}