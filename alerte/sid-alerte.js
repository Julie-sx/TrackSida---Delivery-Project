/* ═══════════════════════════════════════════════════
   SID'ALERTE – sid-alerte.js
═══════════════════════════════════════════════════ */

/* ── DATA ────────────────────────────────────────── */
const CONTACTS = [
  { id: 1, name: 'Alice M.',    initials: 'AM' },
  { id: 2, name: 'Baptiste R.', initials: 'BR' },
  { id: 3, name: 'Clara D.',    initials: 'CD' },
  { id: 4, name: 'Damien K.',   initials: 'DK' },
  { id: 5, name: 'Emma L.',     initials: 'EL' },
];

// result: 'unknown' | 'positif' | 'negatif'
let history = [
  { id: 1, type: 'contact',   label: 'Un de vos contacts a signalé une IST', result: 'unknown' },
  { id: 2, type: 'contact',   label: 'Un de vos contacts a signalé une IST', result: 'unknown' },
  { id: 3, type: 'depistage', label: 'Vous avez fait un dépistage – Négatif', result: 'negatif' },
  { id: 4, type: 'contact',   label: 'Un de vos contacts a signalé une IST', result: 'unknown' },
  { id: 5, type: 'signal',    label: 'Vous avez signalé une IST', result: 'positif' },
  { id: 6, type: 'contact',   label: 'Un de vos contacts a signalé une IST', result: 'unknown' },
  { id: 7, type: 'depistage', label: 'Vous avez fait un dépistage – Positif', result: 'positif' },
  { id: 8, type: 'signal',    label: 'Vous avez signalé une IST', result: 'positif' },
];

const VISIBLE_DEFAULT = 5;
let showAll = false;

/* ── HELPERS ─────────────────────────────────────── */
const $ = id => document.getElementById(id);

function getColor(item) {
  if (item.result === 'positif') return 'orange';
  if (item.result === 'negatif') return 'green';
  // unknown
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
  list.innerHTML = '';

  const items = showAll ? history : history.slice(0, VISIBLE_DEFAULT);

  items.forEach(item => {
    const div = document.createElement('div');
    div.className = `history-item ${getColor(item)}`;
    div.dataset.id = item.id;

    div.innerHTML = `
      <span class="item-text">${item.label}</span>
      <button class="dots-btn" data-id="${item.id}">···</button>
    `;
    list.appendChild(div);
  });

  // voir plus label
  const btn = $('voirPlusBtn');
  if (history.length <= VISIBLE_DEFAULT) {
    btn.style.display = 'none';
  } else {
    btn.style.display = 'flex';
    btn.innerHTML = showAll
      ? '<span>−</span> Voir moins'
      : `<span>+</span> Voir plus (${history.length - VISIBLE_DEFAULT} de plus)`;
    btn.classList.toggle('expanded', showAll);
  }
}

/* ── VOIR PLUS ───────────────────────────────────── */
$('voirPlusBtn').addEventListener('click', () => {
  showAll = !showAll;
  renderHistory();
});

/* ── DOTS → RESULT MODAL ─────────────────────────── */
let activeItemId = null;

document.getElementById('historyList').addEventListener('click', e => {
  const btn = e.target.closest('.dots-btn');
  if (!btn) return;

  activeItemId = parseInt(btn.dataset.id);
  const item = history.find(h => h.id === activeItemId);

  // pre-select known result
  $('btnPositif').classList.remove('selected');
  $('btnNegatif').classList.remove('selected');
  if (item.result === 'positif') $('btnPositif').classList.add('selected');
  if (item.result === 'negatif') $('btnNegatif').classList.add('selected');

  openOverlay('resultOverlay');
});

function selectResult(result) {
  $('btnPositif').classList.toggle('selected', result === 'positif');
  $('btnNegatif').classList.toggle('selected', result === 'negatif');

  if (activeItemId !== null) {
    const item = history.find(h => h.id === activeItemId);
    if (item) {
      // update label if it's a contact item (unknown → now we know)
      if (item.type === 'contact' && item.result === 'unknown') {
        item.label = result === 'positif'
          ? 'Un de vos contacts a signalé une IST – Positif'
          : 'Un de vos contacts a signalé une IST – Négatif';
      }
      item.result = result;
      renderHistory();
      showToast(`Résultat enregistré : ${result === 'positif' ? 'Positif ✓' : 'Négatif ✓'}`);
    }
  }
}

$('btnPositif').addEventListener('click', () => selectResult('positif'));
$('btnNegatif').addEventListener('click', () => selectResult('negatif'));

/* ── CONTACTS DANS SIGNALEMENT ───────────────────── */
let selectedContacts = new Set();

function renderContacts() {
  const list = $('contactsList');
  list.innerHTML = '';
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

/* ── OPEN SIGNALEMENT ────────────────────────────── */
$('openSignalBtn').addEventListener('click', () => {
  selectedContacts.clear();
  renderContacts();
  $('dateEstimee').value = '';
  openOverlay('signalOverlay');
});

/* ── SUBMIT SIGNALEMENT ──────────────────────────── */
$('submitSignal').addEventListener('click', () => {
  const type = $('typeIST').value;
  const date = $('dateEstimee').value;

  if (!date) {
    $('dateEstimee').focus();
    showToast('Veuillez renseigner une date.');
    return;
  }

  const newItem = {
    id: Date.now(),
    type: 'signal',
    label: `Vous avez signalé une IST (${type})`,
    result: 'positif',
  };
  history.unshift(newItem);
  renderHistory();
  closeOverlay('signalOverlay');
  alert('IST bien signalée');
});

/* ── DÉPISTAGE RESULT SELECTION ──────────────────── */
let depResult = null;

$('depPositif').addEventListener('click', () => {
  depResult = 'positif';
  $('depPositif').classList.add('selected');
  $('depNegatif').classList.remove('selected');
});
$('depNegatif').addEventListener('click', () => {
  depResult = 'negatif';
  $('depNegatif').classList.add('selected');
  $('depPositif').classList.remove('selected');
});

/* ── OPEN DÉPISTAGE ──────────────────────────────── */
$('openDepistageBtn').addEventListener('click', () => {
  depResult = null;
  $('depPositif').classList.remove('selected');
  $('depNegatif').classList.remove('selected');
  $('depistageDate').value = '';
  openOverlay('depistageOverlay');
});

/* ── SUBMIT DÉPISTAGE ────────────────────────────── */
$('submitDepistage').addEventListener('click', () => {
  const type = $('depistageType').value;
  const date = $('depistageDate').value;

  if (!date) {
    $('depistageDate').focus();
    showToast('Veuillez renseigner une date.');
    return;
  }
  if (!depResult) {
    showToast('Veuillez sélectionner un résultat.');
    return;
  }

  const label = depResult === 'negatif'
    ? `Vous avez fait un dépistage – Négatif (${type})`
    : `Vous avez fait un dépistage – Positif (${type})`;

  const newItem = {
    id: Date.now(),
    type: 'depistage',
    label,
    result: depResult,
  };
  history.unshift(newItem);
  renderHistory();
  closeOverlay('depistageOverlay');
  showToast('Dépistage enregistré ✓');
});

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
    ['signalOverlay', 'resultOverlay', 'depistageOverlay'].forEach(closeOverlay);
  }
});

/* ── INIT ────────────────────────────────────────── */
renderHistory();
