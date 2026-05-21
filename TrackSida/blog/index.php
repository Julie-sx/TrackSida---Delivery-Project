<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Tracksida – Blogs & Articles</title>
  <link rel= "stylesheet" href="../css/style.css">
</head>
<body>
<div class="app">

  <!-- HEADER -->
  <header>
    <a href="#" class="logo">Tracksida</a>
    <button class="notif-btn" aria-label="Notifications">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
        <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
      </svg>
      <span class="notif-badge">56</span>
    </button>
  </header>

  <?php
  require('../module/header.php');
?>

  <!-- SUB-HEADER -->
  <div class="subheader">
    <button class="back-btn" aria-label="Retour">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <polyline points="15 18 9 12 15 6"/>
      </svg>
    </button>
    <span class="subheader-title">Blogs et Articles</span>
  </div>

  <!-- MAIN -->
  <main>
    <section class="section">
      <h2 class="section-title">Article du mois</h2>
      <div>
        <div class="card">
          <h3 class="card-title">La chasse au IST</h3>
          <p class="card-excerpt">Découvrez comment dépister et prévenir les infections sexuellement transmissibles au quotidien. Un guide complet pour mieux comprendre les risques et se protéger efficacement.</p>
          <div class="card-footer"><button class="btn-lire">Lire plus</button></div>
        </div>
      </div>
    </section>

    <section class="section">
      <h2 class="section-title">Tout savoir sur le sida</h2>
      <div>
        <div class="card">
          <h3 class="card-title">La chasse au IST</h3>
          <p class="card-excerpt">Comprendre les modes de transmission et les moyens de prévention disponibles.</p>
          <div class="card-footer"><button class="btn-lire">Lire plus</button></div>
        </div>
        <br>
        <div class="card">
          <h3 class="card-title">Vivre avec le VIH</h3>
          <p class="card-excerpt">Des témoignages inspirants de personnes qui mènent une vie épanouie avec le virus.</p>
          <div class="card-footer"><button class="btn-lire">Lire plus</button></div>
        </div>
      </div>
    </section>

    <section class="section">
      <h2 class="section-title">Les découvertes</h2>
      <div>
        <div class="card">
          <h3 class="card-title">Nouveau traitement ARV</h3>
          <p class="card-excerpt">Une injection bimestrielle efficace à 99 % : les dernières avancées scientifiques de 2025.</p>
          <div class="card-footer"><button class="btn-lire">Lire plus</button></div>
        </div>
      </div>
    </section>
  </main>

  <!-- FOOTER -->
  <footer>
    <button class="footer-btn active" aria-label="Menu">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round">
        <line x1="3" y1="6" x2="21" y2="6"/>
        <line x1="3" y1="12" x2="21" y2="12"/>
        <line x1="3" y1="18" x2="21" y2="18"/>
      </svg>
      Menu
    </button>

    <button class="footer-center" aria-label="Ajouter">
      <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#7B7FD4" stroke-width="2.8" stroke-linecap="round">
        <line x1="12" y1="5" x2="12" y2="19"/>
        <line x1="5" y1="12" x2="19" y2="12"/>
      </svg>
    </button>

    <button class="footer-btn" aria-label="Profil">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round">
        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
        <circle cx="12" cy="7" r="4"/>
      </svg>
      Profil
    </button>
  </footer>

</div>
</body>
</html>
