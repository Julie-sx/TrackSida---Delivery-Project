<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Tracksida – Sid'Alert</title>
  <link rel= "stylesheet" href="./css/style.css">
</head>
<body class="app">

  <!-- HEADER -->
<?php
  require('./module/header.php');
?>

  <!-- MAIN -->
  <main>

    <!-- Page title -->
    <button onclick="window.location.href='/alerte'" class="hero-alert">

    <div class="hero-alert-content">
      <h1 class="hero-title">Sid'Alert</h1>

      <p class="hero-desc">
        Préviens rapidement tes partenaires et accède aux outils essentiels.
      </p>
    </div>

    <div class="hero-arrow">
      →
    </div>
  </button>

    <br>

    <!-- Bloc Dép-IST -->
    <div class="block">
      <div class="block-header">
        <span class="block-icon">📍</span>
        <span class="block-title">Dép-IST</span>
      </div>
      <p class="block-desc">Trouve un centre de dépistage proche de chez toi !</p>
          <div class="block-cta">
        <button onclick="window.location.href='/map'" class="btn-action">Carte</button>
      </div>
    </div>

    <!-- Bloc Contacts -->
    <div class="block">
      <div class="block-header">
        <span class="block-icon">👥</span>
        <span class="block-title">Contacts</span>
      </div>
      <p class="block-desc">Consulte et référence tes partenaires</p>
      <div class="block-cta">
        <button onclick="window.location.href='/contact'" class="btn-action">Ajouter</button>
      </div>
    </div>

    <!-- Bloc S'informer -->
    <div class="block">
      <div class="block-header">
        <span class="block-icon">❓</span>
        <span class="block-title">S'informer</span>
      </div>
      <p class="block-desc">En savoir plus sur les IST</p>
      <div class="block-cta">
        <button onclick="window.location.href='/blog'" class="btn-action">Explorer</button>
      </div>
    </div>

  </main>

  <!-- FOOTER -->
  <?php
  require('./module/footer.php');
  ?>

</body>
</html>
