function nop() {
}

function msg(e) {
    // noinspection JSUnresolvedVariable
    // alert(`${e.localized}\n${e.message}`);
    alert(e.message);
}

function request(target, body, callback = nop, fallbackCallback = msg) {
    const req = new XMLHttpRequest();
    req.open("POST", `%root%/api/${target}`, true);
    req.setRequestHeader('Content-Type', 'application/json; charset=UTF-8');
    req.responseType = "json";
    req.onreadystatechange = () => {
        if (req.readyState === XMLHttpRequest.DONE) {
            if (req.status === 200) callback(req.response);
            else fallbackCallback(req.response);
        }
    };
    req.send(JSON.stringify(body));
}

// Do not use fields in classes. It's experimental(wtf!?) feature and not working on old browsers.

const Targets = {
    QuoteAdd: 'quote/add',
    QuoteGet: 'quote/get',
    QuoteGetList: 'quote/get/list',
    QuoteRemove: 'quote/remove',
    QuoteUpdate: 'quote/update',
    UserLogin: 'user/login',
    UserLogout: 'user/logout',
    UserRecover: 'user/recover',
    UserRecoverRequest: 'user/recover/request',
    UserSignup: 'user/signup'
};
