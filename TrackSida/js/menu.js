const mobileMenu = document.getElementById('mobileMenu');
const menuToggle = document.getElementById('menuToggle');
const closeMenu = document.getElementById('closeMenu');

menuToggle.addEventListener('click', () => {
    mobileMenu.classList.add('open');
});

closeMenu.addEventListener('click', () => {
    mobileMenu.classList.remove('open');
});

mobileMenu.addEventListener('click', (e) => {
    if(e.target === mobileMenu){
        mobileMenu.classList.remove('open');
    }
});