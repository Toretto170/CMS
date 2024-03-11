// SCRIPT PER L'INIZIALIZZAZIONE DI GRAPESJS

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