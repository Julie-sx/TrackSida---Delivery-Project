<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Tracksida – Notifications</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700;800;900&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../css/style.css" />
  <link rel="stylesheet" href="../css/notifications.css" />
</head>
<body class="app">

<?php require('../module/header.php'); ?>

  <main>

    <!-- Titre + action -->
    <div class="notif-toprow">
      <h2 class="notif-page-title">Notifications</h2>
      <button class="btn-ghost" id="btnReadAll">Tout marquer comme lu</button>
    </div>

    <!-- Filtres -->
    <div class="notif-filters" role="tablist" aria-label="Filtrer les notifications">
      <button class="filter-pill filter-pill--active" data-filter="all"     role="tab" aria-selected="true">Toutes</button>
      <button class="filter-pill"                     data-filter="contact" role="tab" aria-selected="false">Contacts</button>
      <button class="filter-pill"                     data-filter="ist"     role="tab" aria-selected="false">IST</button>
      <button class="filter-pill"                     data-filter="article" role="tab" aria-selected="false">Articles</button>
      <button class="filter-pill"                     data-filter="profil"  role="tab" aria-selected="false">Profil</button>
    </div>

    <!-- Liste -->
    <div class="notif-list" id="notifList" role="list" aria-label="Notifications"></div>

    <!-- État vide -->
    <div class="notif-empty" id="notifEmpty" hidden>
      <svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <path d="M18 8a6 6 0 0 0-12 0c0 7-3 9-3 9h18s-3-2-3-9"/>
        <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
        <line x1="2" y1="2" x2="22" y2="22"/>
      </svg>
      <p>Aucune notification dans cette catégorie</p>
    </div>

  </main>

<?php require('../module/footer.php'); ?>

<script src="../js/notifications.js"></script>
</body>
</html>