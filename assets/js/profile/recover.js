const dRandom = document.getElementById('random');
const dPassword = document.getElementById('password');

dPassword.onkeydown = ev => {
    if (ev.key === 'Enter') request(Targets.UserRecover, {
        "random": dRandom.value,
        "password": dPassword.value,
    }, () => window.location.href = '%root%/login');
}

dPassword.focus();
