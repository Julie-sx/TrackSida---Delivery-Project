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

  <?php
  require('../module/footer.php');
  ?>

</div>
</body>
</html>
