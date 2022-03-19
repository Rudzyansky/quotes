const dSignup = document.getElementById('signup');
const dName = document.getElementById('name');
const dUsername = document.getElementById('username');
const dEmail = document.getElementById('email');
const dPassword = document.getElementById('password');
const dConfirmPassword = document.getElementById('confirm_password');

dLogin.onclick = () => {
    window.location.href = '%root%/login' + window.location.search;
}

dSignup.onclick = () => {
    if (dPassword.value === dConfirmPassword.value) request(Targets.UserSignup, {
        "name": dName.value,
        "username": dUsername.value,
        "email": dEmail.value,
        "password": dPassword.value
    }, () => window.location.href = '%root%/profile');
    else alert("Passwords does not equals");
}

dName.onkeydown = ev => {
    if (ev.key === 'Enter') dUsername.focus();
}

dUsername.onkeydown = ev => {
    if (ev.key === 'Enter') dEmail.focus();
}

dEmail.onkeydown = ev => {
    if (ev.key === 'Enter') dPassword.focus();
}

dPassword.onkeydown = ev => {
    if (ev.key === 'Enter') dConfirmPassword.focus();
}

dConfirmPassword.onkeydown = ev => {
    if (ev.key === 'Enter') dSignup.click();
}

dName.focus();
