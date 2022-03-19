// search(decodeURIComponent(window.location.search).substring(1));

// init search block start
dSearch.value = decodeURIComponent(window.location.search).substring(1);
refreshFlag = true;

function getListInit(i) {
    getQuotesListWithCustom(i, () => {
        let height = document.documentElement.clientHeight;
        let atBottom = document.documentElement.getBoundingClientRect().bottom;
        if (atBottom <= height + 100) getListInit(index + 1);
    })
}

getListInit(0);
// init search block end


dAdd.onclick = add;

let inSearch = false;
dSearch.onkeydown = e => {
    inSearch = true;
    if (e.key === 'Enter') window.location.search = encodeURIComponent(dSearch.value);
};
dSearch.onkeyup = e => {
    inSearch = false;
    if (e.key === 'ArrowLeft' || e.key === 'ArrowRight' || e.key === 'ArrowUp' || e.key === 'ArrowDown') return true;
    reSearch();
};

window.onscroll = () => {
    let height = document.documentElement.clientHeight;
    let atBottom = document.documentElement.getBoundingClientRect().bottom;
    if (atBottom <= height + 100) getList(index + 1)
};

dTop.onclick = scrollTop;
dLeft.firstElementChild.style.display = 'none';
dLeft.onmouseover = () => dLeft.firstElementChild.style.display = '';
dLeft.onmouseleave = () => dLeft.firstElementChild.style.display = 'none';

dBottom.onclick = scrollBottom;
dRight.firstElementChild.style.display = 'none';

dRight.onmouseover = () => {
    dInfo.style.display = 'none';
    dRight.firstElementChild.style.display = '';
}
dRight.onmouseleave = () => {
    dRight.firstElementChild.style.display = 'none';
    dInfo.style.display = '';
}
