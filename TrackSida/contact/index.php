<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>TrackSida – Contacts</title>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="contacts.css" />
</head>
<body>

<main>

  <?php
  require('../module/header.php');
?>

  <div class="contacts-card">
    <div class="card-top">
      <div class="total-badge">
        <span class="total-count" id="totalCount">0</span>
        <span class="total-label">Contact</span>
      </div>
    </div>

    <div id="contactList"></div>

    <div class="pagination" id="pagination"></div>

    <button class="add-btn" id="openAddBtn">＋ Ajouter un contact</button>
  </div>

</main>

<!-- MODAL – AJOUTER / MODIFIER -->
<div class="overlay" id="formOverlay" role="dialog" aria-modal="true">
  <div class="modal">
    <div class="modal-header">
      <h3 id="formTitle">Contact</h3>
      <button class="close-btn" data-close="formOverlay">✕</button>
    </div>
    <div class="modal-body">
      <input type="hidden" id="editId" value="" />

      <div class="form-group">
        <label for="fNom">Nom <span class="req">*</span></label>
        <input type="text" id="fNom" placeholder="Dupont" />
      </div>
      <div class="form-group">
        <label for="fPrenom">Prénom <span class="req">*</span></label>
        <input type="text" id="fPrenom" placeholder="Marie" />
      </div>
      <div class="form-group">
        <label for="fEmail">Email <span class="req-either">*</span></label>
        <input type="email" id="fEmail" placeholder="marie@email.com" />
      </div>
      <div class="form-group">
        <label for="fTel">Téléphone <span class="req-either">*</span></label>
        <input type="tel" id="fTel" placeholder="06 12 34 56 78" />
      </div>

      <p class="form-hint">* champ obligatoire &nbsp;·&nbsp; <span class="req-either">*</span> email ou téléphone obligatoire</p>

      <button class="submit-btn" id="submitForm">Ajouter</button>
    </div>
  </div>
</div>

<!-- MENU CONTEXTUEL (···) -->
<div class="ctx-menu" id="ctxMenu">
  <button id="ctxEdit">✏️ Modifier</button>
  <button id="ctxDelete">🗑️ Supprimer</button>
</div>

<!-- MODAL – CONFIRM DELETE -->
<div class="overlay" id="deleteOverlay" role="dialog" aria-modal="true">
  <div class="modal modal-sm">
    <div class="modal-header danger">
      <h3>Supprimer le contact</h3>
      <button class="close-btn" data-close="deleteOverlay">✕</button>
    </div>
    <div class="modal-body">
      <p class="confirm-text">Voulez-vous vraiment supprimer <strong id="deleteTarget"></strong> ?</p>
      <div class="confirm-btns">
        <button class="cancel-btn" data-close="deleteOverlay">Annuler</button>
        <button class="danger-btn" id="confirmDelete">Supprimer</button>
      </div>
    </div>
  </div>
</div>

<?php
  require('../module/footer.php');
  ?>

<div class="toast" id="toast"></div>

<script src="contacts.js"></script>
</body>
</html>
