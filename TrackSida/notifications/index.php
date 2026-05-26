<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>TRACKSIDA — Notifications</title>
  <link rel="stylesheet" href="../css/notifications.css" />
  <link rel="stylesheet" href="../css/style.css" />
</head>
<body>
<?php
  require('../module/header.php');
  ?>

  <!-- MAIN -->
  <main class="page">

    <!-- TITRE + ACTIONS -->
    <div class="notif-header">
      <h1 class="notif-header__title">Notifications</h1>
      <button class="btn-ghost" id="btn-read-all">Tout marquer comme lu</button>
    </div>

    <!-- FILTRES -->
    <div class="filters" role="tablist">
      <button class="filter-btn filter-btn--active" data-filter="all" role="tab" aria-selected="true">Toutes</button>
      <button class="filter-btn" data-filter="alert" role="tab" aria-selected="false">Alertes</button>
      <button class="filter-btn" data-filter="info" role="tab" aria-selected="false">Infos</button>
      <button class="filter-btn" data-filter="contact" role="tab" aria-selected="false">Contacts</button>
    </div>

    <!-- LISTE -->
    <section class="notif-list" id="notif-list" aria-label="Liste des notifications">
      <!-- injectées par JS -->
    </section>

    <!-- ÉTAT VIDE -->
    <div class="empty-state" id="empty-state" hidden>
      <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M18 8a6 6 0 0 0-12 0c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/><line x1="2" y1="2" x2="22" y2="22"/></svg>
      <p>Aucune notification</p>
    </div>

  </main>

  <?php
  require('../module/footer.php');
  ?>

  <script src="../js/notifications.js"></script>
</body>
</html>