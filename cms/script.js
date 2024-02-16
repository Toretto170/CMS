function whichElement(event) {
    let targ;
    if (!event) {
      let event = window.event;
    }
    if (event.target) {
      targ = event.target;
    } else if (event.srcElement) {
      targ = event.srcElement;
    }
    let tagName = targ.tagName.toLowerCase();
    
   
    let newText = prompt("Modifica il contenuto:", targ.innerText);
    if (newText !== null) {
      targ.innerText = newText;
    }
    
   
    let addElementChoice = prompt("Vuoi aggiungere un elemento? (y/n)");
    if (addElementChoice && addElementChoice.toLowerCase() === "y") {
      let elementType = prompt("Che tipo di elemento vuoi aggiungere?");
      if (elementType) {
        let newElement = document.createElement(elementType);
        let content = prompt("Inserisci il contenuto:");
        newElement.innerHTML = content;
        targ.appendChild(newElement);
      }
    }
    
    let removeElementChoice = prompt("Vuoi rimuovere questo elemento? (y/n)");
    if (removeElementChoice && removeElementChoice.toLowerCase() === "y") {
        targ.parentNode.removeChild(targ);
    }
    
    alert("Hai fatto delle modifiche all'elemento " + tagName);
}
