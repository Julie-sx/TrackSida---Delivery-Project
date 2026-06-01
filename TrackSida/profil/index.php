<?php 
require 'data-profil.php' ; 
global $userPseudo;
global $userEmail;
global $userDateNaissance;
global $userPartenaires;
global $userDeclarations;
global $userDi;
global $initial;
global $userType;
global $userTime;
global $userVille;
global $userTel;

?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
  <title>Profil – Track SIDA</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../css/profile.css" />
</head>
<body>

<?php
  require('../module/header.php');
  ?>

<div class="app">

<div class="subheader">

    <div class="subheader-left">
      <button onclick="window.location.href='/'" class="back-btn" aria-label="Retour">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <polyline points="15 18 9 12 15 6"/>
        </svg>
      </button>

      <span class="subheader-title">Mon profil</span>
    </div>

    <div id="editToggleBtn" class="edit-btn" onclick="toggleEdit()">
      <svg xmlns="http://www.w3.org/2000/svg"
          width="18"
          height="18"
          viewBox="0 0 24 24"
          fill="none"
          stroke="currentColor"
          stroke-width="2"
          stroke-linecap="round"
          stroke-linejoin="round">
          <path d="M12 20h9"/>
          <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z"/>
      </svg>
    </div>

  </div>
  <!-- MAIN -->
  <main id="mainContent">
  
    <!-- HERO CARD -->
    <div class="hero-card" data-anim="0">
      <div class="avatar-ring">
        <div class="avatar" id="avatarCircle">
          <span id="avatarInitials"><?= htmlspecialchars($initial) ?></span>
        </div>
        <div class="avatar-status" id="avatarStatus"></div>
      </div>
      <div class="hero-info">
        <h1 class="hero-name" id="heroName"><?= htmlspecialchars($userPseudo) ?></h1>
        <div class="hero-meta">
          <span class="hero-handle" id="heroHandle">@<?= htmlspecialchars($userPseudo) ?></span>
          <span class="hero-badge" id="heroBadge"><?= htmlspecialchars($userType) ?></span>
        </div>
        <p class="hero-since">Membre depuis <span id="heroSince"><?=  htmlspecialchars($userTime) ?> Jours</span></p>
      </div>
      <button class="avatar-edit-btn" id="avatarEditBtn" onclick="changeAvatar()" aria-label="Changer l'avatar">
        <svg width="14" height="14" fill="none" stroke="white" stroke-width="2.5" viewBox="0 0 24 24"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
      </button>
    </div>

    <!-- STATS ROW -->
    <div class="stats-row" data-anim="1">
      <div class="stat-card">
        <span class="stat-value" id="statNotifs"><?= htmlspecialchars($userPartenaires) ?></span>
        <span class="stat-label">Partenaires</span>
      </div>
      <div class="stat-divider"></div>
      <div class="stat-card">
        <span class="stat-value" id="statTests"><?= htmlspecialchars($userDeclarations) ?></span>
        <span class="stat-label">Tests<br>enregistrés</span>
      </div>
      <div class="stat-divider"></div>
      <div class="stat-card">
        <span class="stat-value" id="statDays"><?= htmlspecialchars($userDi) ?></span>
        <span class="stat-label">Inscription</span>
      </div>
    </div>

    <!-- SECTION : INFOS PERSONNELLES -->
    <div class="section" data-anim="2">
      <div class="section-title">
        <svg width="16" height="16" fill="none" stroke="#7B7FD4" stroke-width="2.2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        Informations personnelles
      </div>
      <div class="info-block">

        <div class="info-row" id="rowEmail">
          <div class="info-label">
            <svg width="15" height="15" fill="none" stroke="#8585A8" stroke-width="2" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
            E-mail
          </div>
          <div class="info-value" id="valEmail"><?= htmlspecialchars($userEmail) ?></div>
          <input class="info-input hidden" id="inputEmail" type="email" placeholder="[session:email]" />
        </div>

        <div class="info-separator"></div>

        <div class="info-row" id="rowPhone">
          <div class="info-label">
            <svg width="15" height="15" fill="none" stroke="#8585A8" stroke-width="2" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2A19.79 19.79 0 0 1 11.63 19 19.5 19.5 0 0 1 5 12.37 19.79 19.79 0 0 1 3.08 4.2 2 2 0 0 1 5.05 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L9.91 9.91a16 16 0 0 0 6.16 6.16l.91-.91a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
            Téléphone
          </div>
          <div class="info-value" id="valPhone"><?= htmlspecialchars($userTel) ?></div>
          <input class="info-input hidden" id="inputPhone" type="tel" placeholder="[session:phone]" />
        </div>

        <div class="info-separator"></div>

        <div class="info-row" id="rowBirth">
          <div class="info-label">
            <svg width="15" height="15" fill="none" stroke="#8585A8" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            Date de naissance
          </div>
          <div class="info-value" id="valBirth"><?= htmlspecialchars($userDateNaissance) ?></div>
          <input class="info-input hidden" id="inputBirth" type="date" value="<?= htmlspecialchars($userInfos[0]['date_naissance'] ?? '') ?>" />
        </div>

        <div class="info-separator"></div>

        <div class="info-row" id="rowCity">
          <div class="info-label">
            <svg width="15" height="15" fill="none" stroke="#8585A8" stroke-width="2" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
            Ville
          </div>
          <div class="info-value" id="valCity"><?= htmlspecialchars($userVille) ?></div>
          <input class="info-input hidden" id="inputCity" type="text" placeholder="[session:city]" />
        </div>

      </div>
    </div>

    <div class="section" data-anim="3">
      <button class="btn-secondary mt12" onclick="openChangePasswordModal()">
        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
        Changer le mot de passe
      </button>
    </div>

    <!-- SECTION : À PROPOS -->
    <div class="section" data-anim="5">
      <div class="section-title">
        <svg width="16" height="16" fill="none" stroke="#7B7FD4" stroke-width="2.2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        À propos
      </div>
      <div class="info-block">

        <div class="info-row link-row" onclick="openLink('cgu')">
          <div class="info-label-standalone">Conditions d'utilisation</div>
          <svg width="16" height="16" fill="none" stroke="#8585A8" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
        </div>

        <div class="info-separator"></div>

        <div class="info-row link-row" onclick="openLink('privacy')">
          <div class="info-label-standalone">Politique de confidentialité</div>
          <svg width="16" height="16" fill="none" stroke="#8585A8" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
        </div>

        <div class="info-separator"></div>

        <div class="info-row link-row" onclick="openLink('support')">
          <div class="info-label-standalone">Contacter le support</div>
          <svg width="16" height="16" fill="none" stroke="#8585A8" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
        </div>

        <div class="info-separator"></div>

        <div class="info-row">
          <div class="info-label-standalone muted-sm">Serveur : France · Build R-00158-a789 </div>
        </div>

      </div>
    </div>

    <!-- DANGER ZONE -->
    <div class="section danger-section" data-anim="6">
      <div class="section-title danger-title">
        <svg width="16" height="16" fill="none" stroke="#E74C3C" stroke-width="2.2" viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>

      </div>
      <div class="danger-buttons">
        <button class="btn-logout" onclick="confirmLogout()">
          <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
          Se déconnecter
        </button>
        <button class="btn-delete" onclick="confirmDelete()">
          <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
          Supprimer le compte
        </button>
      </div>
    </div>

    <!-- SAVE EDIT BUTTON (hidden by default) -->
    <div class="save-bar hidden" id="saveBar">
      <button class="btn-cancel" onclick="cancelEdit()">Annuler</button>
      <button class="btn-save" onclick="saveEdit()">Enregistrer les modifications</button>
    </div>

  </main>
  
  <!-- MODAL CONFIRM -->
  <div class="modal-overlay hidden" id="modalOverlay">
    <div class="modal" id="modal">
      <div class="modal-icon" id="modalIcon"></div>
      <div class="modal-title" id="modalTitle"></div>
      <div class="modal-desc" id="modalDesc"></div>
      <div class="modal-actions">
        <button class="btn-modal-cancel" onclick="closeModal()">Annuler</button>
        <button class="btn-modal-confirm" id="modalConfirmBtn"></button>
      </div>
    </div>
  </div>

  <!-- MODAL Changer mdp -->
  <div class="modal-overlay hidden" id="changeMdp">

    <form class="modal-content">
      
      <label for="mdpInput">Nouveau mot de passe</label>

      <input 
        type="password"
        id="mdpInput"
        name="mdp"
        placeholder="Entrez votre nouveau mot de passe"
        required
      >

      <button type="submit">
        Enregistrer
      </button>

    </form>

  </div>

  <!-- TOAST -->
  <div class="toast hidden" id="toast"></div>

</div>

<?php
  require('../module/footer.php');
  ?>

<script src="../js/profile.js"></script>
</body>
</html>