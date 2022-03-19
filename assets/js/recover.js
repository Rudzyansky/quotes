const dUsername = document.getElementById('username');
const dRecover = document.getElementById('recover');

dRecover.onclick = () => {
    request(Targets.UserRecoverRequest, {
        "username": dUsername.value,
    }, () => window.location.href = '%root%/login');
};

dUsername.onkeydown = ev => {
    if (ev.key === 'Enter') dRecover.click();
}

dUsername.focus();
