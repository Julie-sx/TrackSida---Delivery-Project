<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>TrackSida – Sid'Alerte</title>
  <link rel="stylesheet" href="../css/style.css" />
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../css/sid-alerte.css" />
</head>
<body>

<div class="app">

  <?php require('../module/header.php'); ?>

  <div class="subheader">
    <button onclick="window.location.href='/'" class="back-btn" aria-label="Retour">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <polyline points="15 18 9 12 15 6"/>
      </svg>
    </button>
    <span class="subheader-title">Sid'Alerte</span>
  </div>

  <main>

    <button class="cta-btn" id="openSignalBtn">Signaler une IST</button>

    <div class="history-card">
      <h2>Historique des signalements</h2>
      <div id="historyList"></div>
      <div class="bottom-row">
        <div class="voir-plus" id="voirPlusBtn"><span>+</span> Voir plus</div>
        <button class="add-depistage-btn" id="openDepistageBtn">＋ Ajouter un dépistage</button>
      </div>
    </div>

  </main>

  <?php require('../module/footer.php'); ?>

</div>

<!-- ══ MODAL – SIGNALEMENT ══ -->
<div class="overlay" id="signalOverlay" role="dialog" aria-modal="true">
  <div class="modal">
    <div class="modal-header">
      <h3>Signalement</h3>
      <button class="close-btn" data-close="signalOverlay">✕</button>
    </div>
    <div class="modal-body">
      <div class="form-group">
        <label for="typeIST">Type <span class="req">*</span></label>
        <div class="select-wrapper">
          <select id="typeIST">
            <option value="VIH">VIH</option>
            <option value="HSV">Herpès (HSV)</option>
            <option value="HPV">HPV</option>
            <option value="Gonorrhée">Gonorrhée</option>
            <option value="Chlamydia">Chlamydia</option>
            <option value="Syphilis">Syphilis</option>
            <option value="Autre">Autre</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label for="dateEstimee">Date estimée <span class="req">*</span></label>
        <input type="date" id="dateEstimee" />
      </div>
      <div class="form-group">
        <label>Contacts à avertir</label>
        <div class="contacts-list" id="contactsList"></div>
      </div>
      <div class="checkbox-row">
        <input type="checkbox" id="anonyme" checked />
        <label for="anonyme">Rester anonyme</label>
      </div>
      <button class="submit-btn" id="submitSignal">Signaler</button>
    </div>
  </div>
</div>

<!-- ══ MODAL – AJOUTER UN DÉPISTAGE ══ -->
<div class="overlay" id="depistageOverlay" role="dialog" aria-modal="true">
  <div class="modal">
    <div class="modal-header">
      <h3>Ajouter un dépistage</h3>
      <button class="close-btn" data-close="depistageOverlay">✕</button>
    </div>
    <div class="modal-body">
      <div class="form-group">
        <label for="depistageType">Type de test <span class="req">*</span></label>
        <div class="select-wrapper">
          <select id="depistageType">
            <option value="VIH">VIH</option>
            <option value="HSV">Herpès (HSV)</option>
            <option value="HPV">HPV</option>
            <option value="Gonorrhée">Gonorrhée</option>
            <option value="Chlamydia">Chlamydia</option>
            <option value="Syphilis">Syphilis</option>
            <option value="Bilan complet">Bilan complet</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label for="depistageDate">Date du dépistage <span class="req">*</span></label>
        <input type="date" id="depistageDate" />
      </div>
      <div class="form-group">
        <label>Résultat <span class="req">*</span></label>
        <div class="result-btns small">
          <button class="result-btn positif" id="depPositif">Positif</button>
          <button class="result-btn negatif" id="depNegatif">Négatif</button>
        </div>
      </div>
      <button class="submit-btn" id="submitDepistage">Enregistrer</button>
    </div>
  </div>
</div>

<div class="toast" id="toast"></div>

<script src="../js/sid-alerte.js"></script>
</body>
</html>