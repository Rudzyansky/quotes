const dInfo = document.getElementById('info');
const dLogin = document.getElementById('login');
const dLogout = document.getElementById('logout');

if (dLogin !== null) dLogin.onclick = () => {
    window.location.href = '%root%/login?' + window.location.pathname + window.location.search;
}

if (dLogout !== null) dLogout.onclick = () => {
    request(Targets.UserLogout, null, () => window.location.reload());
}
