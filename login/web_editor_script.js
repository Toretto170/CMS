
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

//non sembra funzionare quando chiamo la funzione

/* console.log("alo");
var save = document.getElementById("save");
save.addEventListener("click", function(){
  var html = editor.getHtml();
  var css = editor.getCss();


// Effettuare una richiesta AJAX per inviare i testi al server PHP
var xhr = new XMLHttpRequest();
xhr.open('POST', 'db.php', true);
xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
        // Visualizzare la risposta del server (puoi gestire la risposta come preferisci)
        alert(xhr.responseText);
    }
};
xhr.send('html=' + encodeURIComponent(html) + '&css=' + encodeURIComponent(css));
}); */
