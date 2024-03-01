
const editor = grapesjs.init ({
    container: "#gjs",
    plugins: [
      'grapesjs-plugin-export'
    ],
    fromElement: true,
    height: '698px',
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
editor.Panels.addPanel({
    id: 'panel-top',
    el: '.panel__top',
  });
  editor.Panels.addPanel({
    id: 'basic-actions',
    el: '.panel__basic-actions',
    buttons: [
      {
        id: 'visibility',
        active: true, // active by default
        className: 'btn-toggle-borders',
        label: '<u>B</u>',
        command: 'sw-visibility', // Built-in command
      }, {
        id: 'export',
        className: 'btn-open-export',
        label: 'Exp',
        command: 'export-template',
        context: 'export-template', // For grouping context of buttons from the same panel
      }, {
        id: 'show-json',
        className: 'btn-show-json',
        label: 'JSON',
        context: 'show-json',
        command(editor) {
          editor.Modal.setTitle('Components JSON')
            .setContent(`<textarea style="width:100%; height: 250px;">
              ${JSON.stringify(editor.getComponents())}
            </textarea>`)
            .open();
        },
      },{
        id:'Upload',
        className: 'btn-upload',
        label:'Upload',
        command:'upload',
      },{
        id:'Reset',
        className: 'btn-reset',
        label:'Reset',
        command:'reset',
      }
    ],
  });

  var xd=document.getElementById("xd");
  xd.addEventListener("click", function(){
    var html = `<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>
    <body>
        <div id="kek">kekxd</div>
    </body>
    </html>`
    var css = `#kek{
      color: blue;
      background-color: green;
  }`
  
  editor.setComponents(html);
  editor.setStyle(css);
  })
