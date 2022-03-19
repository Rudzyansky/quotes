const regExp1 = /^([\d\wа-яё]{3,})(: |:$)/gimu;
const regExp2 = /^(&lt;)([\d\wа-яё]{3,})(&gt; |&gt;$)/gimu;
const regExpC = /\([cс]\) ([\d\wа-яё]{3,})$/gimu;
const regExpT = /(^| )(#[\d\wа-яё]{3,})/gimu;
const regExpD = /<a class="(character|tag)">([^<]+)<\/a>/gimu;

const dHtml = document.getElementsByTagName('html')[0];
const dContainer = document.getElementsByClassName('container')[0];
const dLeft = document.getElementById('left');
const dTop = document.getElementById('top');
const dRight = document.getElementById('right');
const dBottom = document.getElementById('bottom');
const dAdd = document.getElementById('add');
const dSearch = document.getElementById('search');
const dLoaded = document.getElementById('loaded');
const dCount = document.getElementById('count');

// временный костыль, потом сделать нормально (p.s. тут всё легаси, надо переписывать)
const isLoggedIn = document.getElementById('logout') !== null

let index = 0;
let refreshFlag = false;
let lock = false;

function search(text) {
    dSearch.value = text;
    reSearch();
}

function reSearch() {
    index = 0;
    refreshFlag = true;
    lock = false;
    getList(index)
}

/*
 * Generator
 */

function generateQuote(quote) {
    return `
<div class="quote">
    <div class="flex space-between align-items-center">
        <div class="flex">
            #<a class="id" href="%root%/quote/${quote.id}">${quote.id}</a>
            <div class="controls"></div>
        </div>
        <div class="timestamp">${quote.timestamp}</div>
    </div>
    <div class="text">${quote.text.decorate()}</div>
</div>`;
}

/*
 * Common
 */

Element.prototype.removeChildren = function () {
    while (this.firstChild) this.removeChild(this.firstChild);
};

/*
 * Controls
 */

Element.prototype.appendControl = function (name) {
    let controls = this.getElementsByClassName('controls')[0];
    let control = document.createElement('a');
    control.className = name;
    control.innerText = name;
    control.onclick = () => this[name + 'Action']();
    controls.appendChild(control);
};

Element.prototype.removeControls = function () {
    this.getElementsByClassName('controls')[0].removeChildren();
};

Element.prototype.showControls = function () {
    let controls = this.getElementsByClassName('controls')[0];
    controls.style.display = '';
};

Element.prototype.hideControls = function () {
    let controls = this.getElementsByClassName('controls')[0];
    controls.style.display = 'none';
};

/*
 * Generate Quote Node
 */

function generateQuoteNode(quote) {
    let node = new DOMParser().parseFromString(generateQuote(quote), 'text/html').body.firstElementChild;
    node.hideControls();
    if (isLoggedIn || isNaN(parseInt(node.getElementsByClassName('id')[0].innerText))) {
        node.appendControl('edit');
        node.appendControl('remove');
        node.onmouseover = node.showControls;
        node.onmouseleave = node.hideControls;
    }

    let text = node.getElementsByClassName('text')[0];
    text.onCtrlS(() => node.applyAction())
    text.onEscape(() => node.cancelAction())
    text.decorate()
    return node;
}

/*
 * Print Quote Node
 */

Element.prototype.printQuoteAtBottom = function (quote) {
    return this.insertAdjacentElement('beforeend', generateQuoteNode(quote))
};

Element.prototype.printQuoteAtTop = function (quote) {
    return this.insertAdjacentElement("afterbegin", generateQuoteNode(quote))
};

/*
 * Add empty quote
 */

function add() {
    dContainer.printQuoteAtTop({id: 'new', text: '\n', timestamp: ''}).editMode();
    setTimeout(scrollTop, 12); // костыль. иначе криво прокручивается
}

/*
 * Actions
 */

// noinspection JSUnusedGlobalSymbols
Element.prototype.editAction = function () {
    this.editMode();
};

// noinspection JSUnusedGlobalSymbols
Element.prototype.removeAction = function () {
    if (!confirm('Are you really want to remove this quote?')) return;
    let id = parseInt(this.getElementsByClassName('id')[0].innerText);
    if (isNaN(id)) {
        this.remove()
        return
    }
    request(Targets.QuoteRemove, {"id": id}, () => {
        this.remove();
        dLoaded.innerText = (parseInt(dLoaded.innerText) - 1).toString();
        dCount.innerText = (parseInt(dCount.innerText) - 1).toString();
        request(Targets.QuoteGetList, {"index": index, "search": dSearch.innerText}, (response) => {
            let quote = response.quotes[response.quotes.length - 1];
            if (parseInt(dContainer.lastElementChild.getElementsByClassName('id')[0].innerText) !== quote.id) {
                dContainer.printQuoteAtBottom(quote);
                dLoaded.innerText = (parseInt(dLoaded.innerText) + 1).toString();
            }
        });
    });
};

Element.prototype.applyAction = function () {
    let id = this.getElementsByClassName('id')[0];
    let text = this.getElementsByClassName('text')[0];
    let timestamp = this.getElementsByClassName('timestamp')[0];
    this.viewMode();
    text.innerHTML = text.innerText.decorate()
    // this.appendControl('UNSAVED')
    this.decorate()
    if (id.innerText > 0) request(Targets.QuoteUpdate, {"id": parseInt(id.innerText), "text": text.innerText}, () => {
        text.innerHTML = text.innerText.decorate();
        text.decorate()
    });
    else request(Targets.QuoteAdd, {"text": text.innerText}, q => {
        id.innerText = q.id;
        id.href = `%root%/quote/${q.id}`;
        text.printDecorated(q)
        timestamp.innerText = q.timestamp;
        dCount.innerText = (parseInt(dCount.innerText) + 1).toString();
        dContainer.lastElementChild.remove();
    });
};

Element.prototype.cancelAction = function () {
    let text = this.getElementsByClassName('text')[0];
    this.viewMode();
    let id = parseInt(this.getElementsByClassName('id')[0].innerText);
    if (id > 0) request(Targets.QuoteGet, {"id": id}, q => text.printDecorated(q));
    else this.remove();
};

/*
 * Decorate
 */

String.prototype.decorate = function () {
    return this
        .replace(regExp1, '<a class="character">$1</a>$2')
        .replace(regExp2, '$1<a class="character">$2</a>$3')
        .replace(regExpC, '(c) <a class="character">$1</a>')
        .replace(regExpT, '$1<a class="tag">$2</a>')
        .replace(/\n/gi, '<br>');
};

String.prototype.unDecorate = function () {
    return this
        .replace(regExpD, '$2')
        .replace(/<br>/gi, '\n')
        .replace(/&lt;/gi, '<')
        .replace(/&gt;/gi, '>');
};

Element.prototype.printDecorated = function (quote) {
    this.innerHTML = quote.text.decorate();
    this.decorate()
}

Element.prototype.decorate = function () {
    let chars = this.getElementsByClassName('character');
    let tags = this.getElementsByClassName('tag');
    for (let i = 0; i < chars.length; ++i) chars.item(i).onclick = () => search(`@${chars.item(i).innerText}`);
    for (let i = 0; i < tags.length; ++i) tags.item(i).onclick = () => search(`${tags.item(i).innerText}`);
}

/*
 * Modes
 */

Element.prototype.editMode = function () {
    // noinspection JSUnusedGlobalSymbols
    this.onmouseover = null;
    // noinspection JSUnusedGlobalSymbols
    this.onmouseleave = null;
    this.removeControls();
    this.appendControl('apply');
    this.appendControl('cancel');
    this.showControls();
    let text = this.getElementsByClassName('text')[0];
    text.contentEditable = true;
    text.innerText = text.innerHTML.unDecorate();

    // move cursor to end
    let range = document.createRange();
    range.selectNodeContents(text);
    range.collapse(false);
    let sel = window.getSelection();
    sel.removeAllRanges();
    sel.addRange(range);
    text.focus()

    // Deprecated
    // document.execCommand('defaultParagraphSeparator', false, 'br');
    return this;
};

Element.prototype.viewMode = function () {
    // noinspection JSUnusedGlobalSymbols
    this.onmouseover = this.showControls;
    // noinspection JSUnusedGlobalSymbols
    this.onmouseleave = this.hideControls;
    this.removeControls();
    this.appendControl('edit');
    this.appendControl('remove');
    let text = this.getElementsByClassName('text')[0];
    text.contentEditable = false;
    // text.innerHTML = text.innerText.decorate();
    return this;
};

/*
 * Fetch quotes
 */

function getQuotesListWithCustom(i, callback) {
    if (lock) return;
    lock = true;
    if (!refreshFlag && index === i) return;
    request(Targets.QuoteGetList, {
        "index": i,
        "search": dSearch.value
    }, (received) => {
        if (!refreshFlag && index === i) return;
        refreshFlag = false;
        if (received === null) return;
        if (received.quotes.length === 0) return;
        index = received.index;
        // noinspection JSUnresolvedVariable
        dLoaded.innerText = (index * received.limit + received.quotes.length).toString();
        // noinspection JSUnresolvedVariable
        dCount.innerText = received.found;
        if (i === 0) dContainer.removeChildren();
        received.quotes.forEach(quote => dContainer.printQuoteAtBottom(quote));
        if (i === 0) dHtml.scrollIntoView({behavior: "smooth"});
        lock = false;
        if (callback !== undefined) callback()
    });
}

function getList(i) {
    getQuotesListWithCustom(i)
}

/*
 * Scroll
 */

function scrollTop() {
    dHtml.scrollIntoView({behavior: "smooth", block: "start"})
}

function scrollBottom() {
    dHtml.scrollIntoView({behavior: "smooth", block: "end"})
}

/*
 * Hotkey bind factory
 */

Element.prototype.onCtrlS = function (callable) {
    this.addEventListener('keydown', e => {
        if (e.ctrlKey && ['s', 'S', 'ы', 'Ы'].includes(e.key)) {
            e.preventDefault()
            callable()
        }
    })
}

Element.prototype.onEscape = function (callable) {
    this.addEventListener('keydown', e => {
        if (e.key === 'Escape') {
            callable()
        }
    })
}
