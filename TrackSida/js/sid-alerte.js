/* ═══════════════════════════════════════════════════
   SID'ALERTE – sid-alerte.js
═══════════════════════════════════════════════════ */

const VISIBLE_DEFAULT = 5;
let showAll = false;

const $ = id => document.getElementById(id);

document.addEventListener('DOMContentLoaded', () => {

function getColor(item) {
  if (item.result === 'positif') return 'orange';
  if (item.result === 'negatif') return 'green';
  if (item.type === 'contact')   return 'blue';
  if (item.type === 'signal')    return 'orange';
  if (item.type === 'depistage') return 'purple';
  return 'blue';
}

function openOverlay(id) {
  $(id).classList.add('open');
  document.body.style.overflow = 'hidden';
}
function closeOverlay(id) {
  $(id).classList.remove('open');
  document.body.style.overflow = '';
}

function showToast(msg) {
  const t = $('toast');
  t.textContent = msg;
  t.classList.add('show');
  setTimeout(() => t.classList.remove('show'), 2800);
}

/* ── RENDER HISTORY ──────────────────────────────── */
function renderHistory() {
  const list = $('historyList');
  if(!list) return;
  list.innerHTML = '';

  const items = showAll ? appHistory : appHistory.slice(0, VISIBLE_DEFAULT);

  items.forEach(item => {
    const div = document.createElement('div');
    div.className = `history-item ${getColor(item)}`;
    div.dataset.id = item.id;
    div.innerHTML = `<span class="item-text">${item.label}</span>`;
    list.appendChild(div);
  });

  const btn = $('voirPlusBtn');
  if (appHistory.length <= VISIBLE_DEFAULT) {
    btn.style.display = 'none';
  } else {
    btn.style.display = 'flex';
    btn.innerHTML = showAll
      ? '<span>−</span> Voir moins'
      : `<span>+</span> Voir plus (${appHistory.length - VISIBLE_DEFAULT} de plus)`;
    btn.classList.toggle('expanded', showAll);
  }
}

$('voirPlusBtn').addEventListener('click', () => {
  showAll = !showAll;
  renderHistory();
});

/* ── CONTACTS RENDERING ──────────────────────────── */
let selectedContacts = new Set();

function renderContacts() {
  const list = $('contactsList');
  if (!list) return;
  list.innerHTML = '';
  
  if (typeof CONTACTS !== 'undefined') {
      
    // --- NOUVEAUTÉ : Si l'utilisateur n'a pas de partenaire ---
    if (CONTACTS.length === 0) {
      list.innerHTML = `
        <div style="padding: 16px; font-size: 0.85rem; color: var(--muted); text-align: center; background: var(--bg); border-radius: 10px; border: 2px dashed var(--purple-lt);">
          Tu n'as aucun partenaire enregistré.<br>
          <span style="font-size: 0.75rem; opacity: 0.8;">Ajoutes-en dans ton espace "Partenaires" pour pouvoir les alerter.</span>
        </div>
      `;
      return; // On arrête la fonction ici
    }

    // --- Si l'utilisateur a des partenaires (Affichage normal) ---
    CONTACTS.forEach(c => {
      const div = document.createElement('div');
      div.className = `contact-item${selectedContacts.has(c.id) ? ' selected' : ''}`;
      div.dataset.cid = c.id;
      div.innerHTML = `
        <div class="contact-avatar">${c.initials}</div>
        <span>${c.name}</span>
        <span class="contact-check">✓</span>
      `;
      div.addEventListener('click', () => {
        if (selectedContacts.has(c.id)) {
          selectedContacts.delete(c.id);
          div.classList.remove('selected');
        } else {
          selectedContacts.add(c.id);
          div.classList.add('selected');
        }
      });
      list.appendChild(div);
    });
  }
}
/* ── DÉPISTAGE RESULT SELECTION ──────────────────── */
let depResult = null;

const btnPositif = $('depPositif');
const btnNegatif = $('depNegatif');

if(btnPositif) {
    btnPositif.addEventListener('click', () => {
      depResult = 'positif';
      btnPositif.classList.add('selected');
      btnNegatif.classList.remove('selected');
      
      const group = $('contactsGroup');
      if (group) {
          group.style.display = 'block';
          renderContacts();
      }
    });
}

if(btnNegatif) {
    btnNegatif.addEventListener('click', () => {
      depResult = 'negatif';
      btnNegatif.classList.add('selected');
      btnPositif.classList.remove('selected');
      
      const group = $('contactsGroup');
      if (group) group.style.display = 'none';
      selectedContacts.clear();
    });
}

/* ── OPEN DÉPISTAGE ──────────────────────────────── */
const openDepistageBtn = $('openDepistageBtn');
if(openDepistageBtn) {
    openDepistageBtn.addEventListener('click', () => {
      depResult = null;
      if(btnPositif) btnPositif.classList.remove('selected');
      if(btnNegatif) btnNegatif.classList.remove('selected');
      
      const dateInput = $('depistageDate');
      if(dateInput) dateInput.value = '';
      
      const group = $('contactsGroup');
      if (group) group.style.display = 'none'; 
      selectedContacts.clear();
      
      openOverlay('depistageOverlay');
    });
}

/* ── SUBMIT DÉPISTAGE UNIFIÉ ────────────────────────────── */
const submitDepistageBtn = $('submitDepistage');
if(submitDepistageBtn) {
    submitDepistageBtn.addEventListener('click', async () => {
      const selectEl = $('depistageType');
      const typeId = selectEl.value; 
      const typeText = selectEl.options[selectEl.selectedIndex].text; 
      const date = $('depistageDate').value;

      if (!date) {
        $('depistageDate').focus();
        showToast('Veuillez renseigner une date.');
        return;
      }
      if (!depResult) {
        showToast('Veuillez sélectionner un résultat.');
        btnPositif.classList.add('required-highlight');
        btnNegatif.classList.add('required-highlight');
        setTimeout(() => {
          btnPositif.classList.remove('required-highlight');
          btnNegatif.classList.remove('required-highlight');
        }, 1200);
        return;
      }

      const selectedContactsArray = Array.from(selectedContacts);

      try {
        submitDepistageBtn.textContent = 'Enregistrement...';
        submitDepistageBtn.disabled = true;

        const response = await fetch('process-depistage.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({
            id_ist: typeId,
            date: date,
            resultat: depResult,
            contacts: selectedContactsArray
          })
        });

        const data = await response.json();

        if (data.success) {
          const label = depResult === 'negatif'
            ? `Vous avez fait un dépistage – Négatif (${typeText})`
            : `Vous avez signalé une IST – Positif (${typeText})`;

          const newItem = {
            id: Date.now(),
            type: depResult === 'negatif' ? 'depistage' : 'signal',
            label: label,
            result: depResult,
          };
          
          appHistory.unshift(newItem);
          renderHistory();
          
          closeOverlay('depistageOverlay');
          showToast('Dépistage enregistré ✓');
          
        } else {
          showToast('Erreur : ' + data.message);
        }
      } catch (error) {
        console.error(error);
        showToast('Erreur de connexion au serveur.');
      } finally {
        submitDepistageBtn.textContent = 'Enregistrer';
        submitDepistageBtn.disabled = false;
      }
    });
}

/* ── CLOSE BUTTONS ───────────────────────────────── */
document.querySelectorAll('[data-close]').forEach(btn => {
  btn.addEventListener('click', () => closeOverlay(btn.dataset.close));
});

/* ── BACKDROP CLICK ──────────────────────────────── */
document.querySelectorAll('.overlay').forEach(overlay => {
  overlay.addEventListener('click', e => {
    if (e.target === overlay) closeOverlay(overlay.id);
  });
});

/* ── ESC ─────────────────────────────────────────── */
document.addEventListener('keydown', e => {
  if (e.key === 'Escape') {
    ['depistageOverlay'].forEach(id => {
        const el = document.getElementById(id);
        if(el) closeOverlay(id);
    });
  }
});

/* ── INIT ────────────────────────────────────────── */
renderHistory();

}); // DOMContentLoaded