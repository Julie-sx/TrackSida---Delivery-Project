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


const queryString = window.location.search;

const urlParams = new URLSearchParams(queryString);

const fail = urlParams.get('fail');

if(fail){

    const overlay = document.createElement('div');
    overlay.className = 'popup-overlay';
    overlay.id = 'dynamic-popup-overlay';

    const popup = document.createElement('div');
    popup.className = 'popup popup-err';

    const h2 = document.createElement('h2');
    h2.textContent = "Erreur -";

    const p = document.createElement('p');
    p.textContent = "Informations incorrects ou manquantes";

    const closeBtn = document.createElement('button');
    closeBtn.type = 'button';
    closeBtn.className = 'btn-submit';
    closeBtn.textContent = 'Fermer';

    closeBtn.addEventListener('click', () => {
        overlay.remove();
    });

    overlay.addEventListener('click', (e) => {
        if (e.target === overlay) {
            overlay.remove();
        }
    });

    popup.appendChild(h2);
    popup.appendChild(p);
    popup.appendChild(closeBtn);
    overlay.appendChild(popup);

    document.body.appendChild(overlay);
}