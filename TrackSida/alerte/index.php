<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>TrackSida – Sid'Alerte</title>
  <link rel= "stylesheet" href="../css/style.css">
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../css/sid-alerte.css" />
</head>
<body>

<main>

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

  <!-- SUB-HEADER -->
  <div class="subheader">
    <button class="back-btn" aria-label="Retour">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <polyline points="15 18 9 12 15 6"/>
      </svg>
    </button>
    <span class="subheader-title">Blogs et Articles</span>
  </div>

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

<!-- MODAL – SIGNALEMENT -->
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

<!-- MODAL – RÉSULTAT (dots) -->
<div class="overlay" id="resultOverlay" role="dialog" aria-modal="true">
  <div class="modal">
    <div class="modal-header">
      <h3>Résultat Dépistage</h3>
      <button class="close-btn" data-close="resultOverlay">✕</button>
    </div>
    <div class="modal-body">
      <div class="result-btns">
        <button class="result-btn positif" id="btnPositif">Positif</button>
        <button class="result-btn negatif" id="btnNegatif">Négatif</button>
      </div>
      <div class="find-center">Trouver un centre de dépistage</div>
    </div>
  </div>
</div>

<!-- MODAL – AJOUTER UN DÉPISTAGE -->
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
        <label>Résultat</label>
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

<script src="sid-alerte.js"></script>
</body>
</html>
