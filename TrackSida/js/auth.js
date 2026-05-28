const tabLogin = document.getElementById('tab-login');
const tabRegister = document.getElementById('tab-register');

const panelLogin = document.getElementById('panel-login');
const panelRegister = document.getElementById('panel-register');

function switchToRegister() {
    tabRegister.setAttribute('aria-selected', 'true');
    tabLogin.setAttribute('aria-selected', 'false');

    tabRegister.classList.add('active');
    tabLogin.classList.remove('active');
    
    panelRegister.classList.add('active');
    panelLogin.classList.remove('active');
}

function switchToLogin() {
    tabLogin.setAttribute('aria-selected', 'true');
    tabRegister.setAttribute('aria-selected', 'false');

    tabLogin.classList.add('active');
    tabRegister.classList.remove('active');
    
    panelLogin.classList.add('active');
    panelRegister.classList.remove('active');
}

tabRegister.addEventListener('click', switchToRegister);
tabLogin.addEventListener('click', switchToLogin);