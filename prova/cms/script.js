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

