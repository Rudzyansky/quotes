const dQuote = document.getElementsByClassName('quote')[0];
const dControls = dQuote.getElementsByClassName('controls')[0];
const dText = dQuote.getElementsByClassName('text')[0];

dQuote.hideControls();

/* Shitcode Block */
Element.prototype.addActions = () => {
    for (const dControl of dControls.children) {
        dControl.onclick = () => dControl.parentElement.parentElement.parentElement.parentElement[dControl.className + 'Action']();
    }
}
dControls.addActions();

dQuote.onmouseover = dQuote.showControls;
dQuote.onmouseleave = dQuote.hideControls;

dText.innerHTML = dText.innerHTML.decorate();
dText.decorate()
