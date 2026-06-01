<link rel="stylesheet" href="../css/menu.css">
<link rel="stylesheet" href="../../css/menu.css">

<!-- FOOTER -->
<footer>
    <button class="footer-btn active" id="menuToggle" aria-label="Menu">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round">
            <line x1="3" y1="6" x2="21" y2="6"/>
            <line x1="3" y1="12" x2="21" y2="12"/>
            <line x1="3" y1="18" x2="21" y2="18"/>
        </svg>
        Menu
    </button>

    <button onclick="window.location.href='/contact?add=1'" class="footer-center" aria-label="Ajouter">
        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#7B7FD4" stroke-width="2.8" stroke-linecap="round">
            <line x1="12" y1="5" x2="12" y2="19"/>
            <line x1="5" y1="12" x2="19" y2="12"/>
        </svg>
    </button>

    <button onclick="window.location.href='/profil'" class="footer-btn" aria-label="Profil">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round">
            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
            <circle cx="12" cy="7" r="4"/>
        </svg>
        Profil
    </button>
</footer>

<!-- MENU MOBILE -->
<div class="mobile-menu-overlay" id="mobileMenu">

    <div class="mobile-menu">
        <div class="mobile-menu-header">
            <h3>Menu</h3>

            <button id="closeMenu" class="close-menu">
                ✕
            </button>
        </div>

        <button onclick="window.location.href='/'" class="mobile-link">
            Accueil
        </button>

        <button onclick="window.location.href='/blog'" class="mobile-link">
            Blog
        </button>

        <button onclick="window.location.href='/contact'" class="mobile-link">
            Contact
        </button>

        <button onclick="window.location.href='/map'" class="mobile-link">
            Map
        </button>

        <button onclick="window.location.href='/profil'" class="mobile-link">
            Profil
        </button>

        <button onclick="window.location.href='/alerte'" class="mobile-link">
            Sid'Alerte
        </button>
    </div>

</div>

<script src="../js/menu.js"></script>