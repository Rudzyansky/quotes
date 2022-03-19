// const dLogin = document.getElementById('login');
const dSignUp = document.getElementById('signup');
const dUsername = document.getElementById('username');
const dPassword = document.getElementById('password');

function loginOnPressEnter(ev) {
    if (ev.key === 'Enter') dLogin.click();
}

dLogin.onclick = () => {
    request(Targets.UserLogin, {
        "username": dUsername.value,
        "password": dPassword.value
    }, () => window.location.href = window.location.search.substring(1));
};

dSignUp.onclick = () => {
    window.location.href = '%root%/signup' + window.location.search;
};

dUsername.onkeydown = loginOnPressEnter;
dPassword.onkeydown = loginOnPressEnter;

dUsername.focus();
