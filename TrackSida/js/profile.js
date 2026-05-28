/* ============================================================
   profile.js — Track SIDA | Page Profil
   Convention de données :
     [session:NomDeL'info]  → infos utilisateur / session
     [server:NomDeL'info]   → config globale du serveur
     [blog:NomDeL'info]     → données de la BDD blogs
   ============================================================ */

/* ─── ÉTAT GLOBAL ─── */
let isEditMode = false;
let modalCallback = null;

/* ─── INIT ─── */
document.addEventListener('DOMContentLoaded', () => {
  initPreferences();
  initSessionTimer();
});

/* ──────────────────────────────────────────────────────────────
   PRÉFÉRENCES : lire les valeurs injectées par le backend
   et initialiser les toggles / selects selon [session:*]
   ────────────────────────────────────────────────────────────── */

function initPreferences() {
  /*
   * À connecter côté backend :
   *   [session:notificationsEnabled]  → true / false
   *   [session:anonymousMode]         → true / false
   *   [session:remindersEnabled]      → true / false
   *   [session:language]              → "fr" | "en" | "es" | "ar"
   *
   * Exemple de remplacement côté serveur (PHP, Jinja, etc.) :
   *   const notifs = {{ session.notifications_enabled | tojson }};
   *
   * En attendant l'intégration, on lit les data-attributes
   * que le serveur peut écrire directement sur les éléments.
   */

  const toggleNotifs   = document.getElementById('toggleNotifs');
  const toggleAnon     = document.getElementById('toggleAnon');
  const toggleReminder = document.getElementById('toggleReminder');
  const langSelect     = document.getElementById('langSelect');

  /*
   * Le backend doit écrire l'attribut checked sur les inputs
   * ou injecter les valeurs via data-init="true/false".
   * Ces fallbacks locaux (localStorage) servent de bridge
   * avant la connexion complète au serveur.
   */
  if (localStorage.getItem('pref_notifications') !== null) {
    toggleNotifs.checked = localStorage.getItem('pref_notifications') === 'true';
  }
  if (localStorage.getItem('pref_anonymous') !== null) {
    toggleAnon.checked = localStorage.getItem('pref_anonymous') === 'true';
  }
  if (localStorage.getItem('pref_reminders') !== null) {
    toggleReminder.checked = localStorage.getItem('pref_reminders') === 'true';
  }
  if (localStorage.getItem('pref_language')) {
    langSelect.value = localStorage.getItem('pref_language');
  }
}

/* ──────────────────────────────────────────────────────────────
   SESSION TIMER
   Met à jour [session:sessionDuration] en temps réel
   ────────────────────────────────────────────────────────────── */

function initSessionTimer() {
  const el = document.getElementById('sessionDuration');
  if (!el) return;

  /*
   * Le backend doit fournir le timestamp de début de session.
   * [session:sessionStart] → timestamp Unix en secondes (ex: 1716300000)
   *
   * Pour l'intégration, remplace la ligne ci-dessous par :
   *   const startTs = [session:sessionStart] * 1000;
   * ou via un data-attribute sur l'élément.
   *
   * En attendant, on utilise Date.now() si le placeholder n'est pas résolu.
   */
  const rawText = el.textContent;
  const isPlaceholder = rawText.includes('[session:');

  if (isPlaceholder) {
    // Pas encore connecté au backend → affiche "--"
    el.textContent = '--:--';
    return;
  }

  // Si le backend a injecté une valeur parsable
  const startTs = Date.now(); // remplacer par la vraie valeur backend
  function tick() {
    const diff = Math.floor((Date.now() - startTs) / 1000);
    const h = Math.floor(diff / 3600).toString().padStart(2, '0');
    const m = Math.floor((diff % 3600) / 60).toString().padStart(2, '0');
    const s = (diff % 60).toString().padStart(2, '0');
    el.textContent = `${h}:${m}:${s}`;
  }
  tick();
  setInterval(tick, 1000);
}

/* ──────────────────────────────────────────────────────────────
   MODE ÉDITION
   ────────────────────────────────────────────────────────────── */

function toggleEdit() {
  isEditMode = !isEditMode;
  const btn = document.getElementById('editToggleBtn');
  const saveBar = document.getElementById('saveBar');
  const avatarEditBtn = document.getElementById('avatarEditBtn');

  btn.classList.toggle('active', isEditMode);
  saveBar.classList.toggle('hidden', !isEditMode);
  avatarEditBtn.classList.toggle('visible', isEditMode);

  // Champs éditables
  const editableFields = [
    { value: 'valEmail',  input: 'inputEmail' },
    { value: 'valPhone',  input: 'inputPhone' },
    { value: 'valBirth',  input: 'inputBirth' },
    { value: 'valCity',   input: 'inputCity'  },
  ];

  editableFields.forEach(({ value, input }) => {
    const valEl   = document.getElementById(value);
    const inputEl = document.getElementById(input);
    if (!valEl || !inputEl) return;

    if (isEditMode) {
      // Pré-remplir l'input avec la valeur affichée (si pas un placeholder)
      const currentVal = valEl.textContent.trim();
      inputEl.value = currentVal.startsWith('[') ? '' : currentVal;
      valEl.classList.add('hidden');
      inputEl.classList.remove('hidden');
    } else {
      valEl.classList.remove('hidden');
      inputEl.classList.add('hidden');
    }
  });
}

function cancelEdit() {
  if (isEditMode) toggleEdit();
}

function saveEdit() {
  /*
   * Envoyer les modifications au backend.
   * Endpoint suggéré : POST /api/profile/update
   * Body JSON :
   * {
   *   email:     inputEmail.value,
   *   phone:     inputPhone.value,
   *   birthDate: inputBirth.value,
   *   city:      inputCity.value
   * }
   *
   * Remplacer ce bloc par un vrai fetch() lors de l'intégration.
   */

  const payload = {
    email:     document.getElementById('inputEmail')?.value,
    phone:     document.getElementById('inputPhone')?.value,
    birthDate: document.getElementById('inputBirth')?.value,
    city:      document.getElementById('inputCity')?.value,
  };

  console.log('[Track SIDA] saveEdit payload:', payload);

  // Mettre à jour l'affichage avec les nouvelles valeurs
  if (payload.email)     updateFieldDisplay('valEmail', payload.email);
  if (payload.phone)     updateFieldDisplay('valPhone', payload.phone);
  if (payload.birthDate) updateFieldDisplay('valBirth', formatDate(payload.birthDate));
  if (payload.city)      updateFieldDisplay('valCity',  payload.city);

  cancelEdit();
  showToast('✓ Profil mis à jour', 'success');

  /*
   * Intégration backend :
   *
   * fetch('/api/profile/update', {
   *   method: 'POST',
   *   headers: { 'Content-Type': 'application/json', 'X-Session-Token': '[session:token]' },
   *   body: JSON.stringify(payload)
   * })
   * .then(r => r.json())
   * .then(data => {
   *   if (data.success) {
   *     cancelEdit();
   *     showToast('✓ Profil mis à jour', 'success');
   *   } else {
   *     showToast('Erreur : ' + data.message, 'error');
   *   }
   * })
   * .catch(() => showToast('Connexion impossible', 'error'));
   */
}

function updateFieldDisplay(id, value) {
  const el = document.getElementById(id);
  if (el && value) el.textContent = value;
}

function formatDate(isoDate) {
  if (!isoDate) return '';
  const d = new Date(isoDate);
  return d.toLocaleDateString('fr-FR', { day: '2-digit', month: '2-digit', year: 'numeric' });
}

/* ──────────────────────────────────────────────────────────────
   AVATAR
   ────────────────────────────────────────────────────────────── */

function changeAvatar() {
  /*
   * Intégration : ouvrir un file picker et uploader vers
   * POST /api/profile/avatar (multipart/form-data)
   * Réponse : { url: "https://cdn.../avatar.jpg" }
   *
   * Remplace ci-dessous par ton implémentation.
   */
  const input = document.createElement('input');
  input.type = 'file';
  input.accept = 'image/*';

  input.onchange = (e) => {
    const file = e.target.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = (ev) => {
      const avatar = document.getElementById('avatarCircle');
      avatar.innerHTML = `<img src="${ev.target.result}" alt="Avatar" />`;

      /* Envoyer au serveur :
      const formData = new FormData();
      formData.append('avatar', file);
      fetch('/api/profile/avatar', {
        method: 'POST',
        headers: { 'X-Session-Token': '[session:token]' },
        body: formData
      })
      .then(r => r.json())
      .then(data => {
        if (data.url) avatar.innerHTML = `<img src="${data.url}" alt="Avatar" />`;
      }); */
    };
    reader.readAsDataURL(file);
  };

  input.click();
}

/* ──────────────────────────────────────────────────────────────
   PRÉFÉRENCES : SAVE
   ────────────────────────────────────────────────────────────── */

function savePref(key, value) {
  /*
   * Envoyer la préférence au backend.
   * Endpoint : PATCH /api/profile/preferences
   * Body : { key: "notifications", value: true }
   *
   * Clés possibles :
   *   notifications  → [session:notificationsEnabled]
   *   anonymous      → [session:anonymousMode]
   *   reminders      → [session:remindersEnabled]
   *   language       → [session:language]
   */

  localStorage.setItem('pref_' + key, String(value));
  console.log('[Track SIDA] savePref:', key, '=', value);
  showToast('Préférence enregistrée', 'success');

  /*
   * fetch('/api/profile/preferences', {
   *   method: 'PATCH',
   *   headers: {
   *     'Content-Type': 'application/json',
   *     'X-Session-Token': '[session:token]'
   *   },
   *   body: JSON.stringify({ key, value })
   * });
   */
}

/* ──────────────────────────────────────────────────────────────
   MOT DE PASSE
   ────────────────────────────────────────────────────────────── */

function openChangePasswordModal() {
  const modal = document.getElementById("changeMdp");
  modal.classList.remove("hidden");

  console.log("modal opened");
}

function closeChangePasswordModal() {
  const modal = document.getElementById("changeMdp");
  modal.classList.add("hidden");

  console.log("modal closed");
}

// option : clic sur overlay pour fermer
document.addEventListener("DOMContentLoaded", () => {
  const modal = document.getElementById("changeMdp");

  modal.addEventListener("click", (e) => {
    if (e.target === modal) {
      closeChangePasswordModal();
    }
  });

  const form = modal.querySelector("form");
  form.addEventListener("submit", (e) => {
    e.preventDefault();

     const newPassword = document.getElementById("mdpInput").value;
    console.log("Nouveau mot de passe :", newPassword);

    closeChangePasswordModal();
  });
});

/* ──────────────────────────────────────────────────────────────
   LIENS LÉGAUX
   ────────────────────────────────────────────────────────────── */

function openLink(type) {
  /*
   * URLs à personnaliser.
   * [server:baseUrl] sera remplacé par ex. "https://tracksida.fr"
   */
  const urls = {
    cgu:     '/legal/cgu',       /* [server:cguUrl]     */
    privacy: '/legal/privacy',   /* [server:privacyUrl] */
    support: '/support',         /* [server:supportUrl] */
  };
  const url = urls[type] || '/';
  console.log('[Track SIDA] openLink:', url);
  /* window.location.href = url; */
  showToast('Ouverture de la page…');
}

/* ──────────────────────────────────────────────────────────────
   DÉCONNEXION
   ────────────────────────────────────────────────────────────── */

function confirmLogout() {
  showModal({
    icon: `<svg width="28" height="28" fill="none" stroke="#5557B0" stroke-width="2" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>`,
    iconBg: 'var(--purple-bg)',
    title: 'Se déconnecter ?',
    desc: 'Tu devras te reconnecter avec ton email et ton mot de passe.',
    confirmLabel: 'Déconnexion',
    confirmClass: 'purple',
    onConfirm: doLogout,
  });
}

function doLogout() {
  closeModal();
  showToast('Déconnexion en cours…');

  /*
   * Intégration backend :
   * POST /auth/logout
   * Headers : { 'X-Session-Token': '[session:token]' }
   *
   * fetch('/auth/logout', { method: 'POST', ... })
   *   .then(() => window.location.href = '/login');
   */
  console.log('[Track SIDA] doLogout — [session:userId] déconnecté');
  setTimeout(() => { window.location.href = '/login'; }, 1000);
}

/* ──────────────────────────────────────────────────────────────
   SUPPRESSION DE COMPTE
   ────────────────────────────────────────────────────────────── */

function confirmDelete() {
  showModal({
    icon: `<svg width="28" height="28" fill="none" stroke="${'#E74C3C'}" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg>`,
    iconBg: 'var(--red-lt)',
    title: 'Supprimer le compte ?',
    desc: 'Cette action est irréversible. Toutes tes données seront définitivement effacées.',
    confirmLabel: 'Supprimer définitivement',
    confirmClass: '',
    onConfirm: doDelete,
  });
}

function doDelete() {
  closeModal();
  showToast('Suppression du compte en cours…', 'error');

  /*
   * Intégration backend :
   * DELETE /api/account
   * Headers : { 'X-Session-Token': '[session:token]' }
   * Body : { userId: '[session:userId]', confirm: true }
   *
   * fetch('/api/account', {
   *   method: 'DELETE',
   *   headers: {
   *     'Content-Type': 'application/json',
   *     'X-Session-Token': '[session:token]'
   *   },
   *   body: JSON.stringify({ userId: '[session:userId]', confirm: true })
   * })
   * .then(() => window.location.href = '/goodbye');
   */
  console.log('[Track SIDA] doDelete — suppression compte [session:userId]');
}

/* ──────────────────────────────────────────────────────────────
   MODAL GÉNÉRIQUE
   ────────────────────────────────────────────────────────────── */

function showModal({ icon, iconBg, title, desc, confirmLabel, confirmClass, onConfirm }) {
  const overlay  = document.getElementById('modalOverlay');
  const iconEl   = document.getElementById('modalIcon');
  const titleEl  = document.getElementById('modalTitle');
  const descEl   = document.getElementById('modalDesc');
  const confirmBtn = document.getElementById('modalConfirmBtn');

  iconEl.innerHTML = icon;
  iconEl.style.background = iconBg;
  titleEl.textContent = title;
  descEl.textContent = desc;
  confirmBtn.textContent = confirmLabel;
  confirmBtn.className = 'btn-modal-confirm' + (confirmClass ? ' ' + confirmClass : '');

  modalCallback = onConfirm;
  confirmBtn.onclick = () => { if (modalCallback) modalCallback(); };

  overlay.classList.remove('hidden');
  document.body.style.overflow = 'hidden';
}

function closeModal() {
  document.getElementById('modalOverlay').classList.add('hidden');
  document.body.style.overflow = '';
  modalCallback = null;
}

// Fermer en cliquant l'overlay
document.addEventListener('DOMContentLoaded', () => {
  document.getElementById('modalOverlay')?.addEventListener('click', (e) => {
    if (e.target === e.currentTarget) closeModal();
  });
});


let toastTimer = null;

function showToast(message, type = '') {
  const toast = document.getElementById('toast');
  if (!toast) return;

  toast.textContent = message;
  toast.className = 'toast' + (type ? ' ' + type : '');

  if (toastTimer) clearTimeout(toastTimer);
  toastTimer = setTimeout(() => {
    toast.classList.add('hidden');
  }, 2800);
}