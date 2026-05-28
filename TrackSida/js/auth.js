reg=document.getElementById('tab-register');
inscr=document.getElementById('tab-login');

function toggleReg(){
    reg.ariaSelected="true";
    inscr.ariaSelected="false";
}

function toggleInscr(){
    inscr.ariaSelected="true";
    reg.ariaSelected="false";
}

reg.addEventListener('click',toggleReg);
inscr.addEventListener('click',toggleInscr);