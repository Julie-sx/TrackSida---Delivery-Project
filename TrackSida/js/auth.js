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

document.querySelectorAll('.toggle-pwd').forEach(button => {
    button.addEventListener('click', function() {
        const targetId = this.getAttribute('data-target');
        const input = document.getElementById(targetId);
        
        if (input.type === 'password') {
            input.type = 'text';
        } else {
            input.type = 'password';
        }
    });
});


const regPwdInput = document.getElementById('reg-pwd');
const bars = [
    document.getElementById('bar1'),
    document.getElementById('bar2'),
    document.getElementById('bar3'),
    document.getElementById('bar4')
];
const pwdHint = document.getElementById('pwdHint');

regPwdInput.addEventListener('input', function() {
    const val = this.value;
    let score = 0;

    if (val.length >= 8) score++;
    if (val.match(/[A-Z]/) && val.match(/[a-z]/)) score++;
    if (val.match(/[0-9]/)) score++;
    if (val.match(/[^A-Za-z0-9]/)) score++;

    bars.forEach(bar => bar.className = 'pwd-bar');

    // Cas où le champ est vide
    if (val.length === 0) {
        pwdHint.textContent = "Minimum 8 caractères";
        pwdHint.style.color = "var(--muted)";
        return;
    }

    if (score <= 1) {
        bars[0].classList.add('weak');
        pwdHint.textContent = "Faible";
        pwdHint.style.color = "var(--red)";
    } else if (score === 2) {
        bars[0].classList.add('medium');
        bars[1].classList.add('medium');
        pwdHint.textContent = "Moyen";
        pwdHint.style.color = "#F39C12";
    } else if (score === 3) {
        bars[0].classList.add('medium');
        bars[1].classList.add('medium');
        bars[2].classList.add('medium');
        pwdHint.textContent = "Bon";
        pwdHint.style.color = "#F39C12";
    } else if (score >= 4) {
        bars.forEach(bar => bar.classList.add('strong'));
        pwdHint.textContent = "Très fort";
        pwdHint.style.color = "var(--green)";
    }
});

const registerForm = document.getElementById('registerForm');

function toggleError(inputId, errId, isError) {
    const input = document.getElementById(inputId);
    const errSpan = document.getElementById(errId);
    
    if (isError) {
        input.classList.add('error');
        errSpan.classList.add('visible');
        return false;
    } else {
        input.classList.remove('error');
        errSpan.classList.remove('visible');
        return true;
    }
}

registerForm.addEventListener('submit', function(e) {
    e.preventDefault(); 
    
    let isValid = true;

    // Vérif Prénom (non vide)
    const prenom = document.getElementById('reg-prenom').value.trim();
    if (!toggleError('reg-prenom', 'regPrenomErr', prenom === '')) isValid = false;

    const nom = document.getElementById('reg-nom').value.trim();
    if (!toggleError('reg-nom', 'regNomErr', nom === '')) isValid = false;

    const email = document.getElementById('reg-email').value.trim();
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!toggleError('reg-email', 'regEmailErr', !emailRegex.test(email))) isValid = false;

    const pwd = document.getElementById('reg-pwd').value;
    if (!toggleError('reg-pwd', 'regPwdErr', pwd.length < 8)) isValid = false;

    const pwdConfirm = document.getElementById('reg-pwd-confirm').value;
    if (!toggleError('reg-pwd-confirm', 'regConfirmErr', pwd !== pwdConfirm || pwdConfirm === '')) isValid = false;

    const cgu = document.getElementById('reg-cgu');
    const cguErr = document.getElementById('regCguErr');
    if (!cgu.checked) {
        cguErr.classList.add('visible');
        isValid = false;
    } else {
        cguErr.classList.remove('visible');
    }

    if (isValid) {
        this.submit();
    }
});