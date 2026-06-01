/* ═══════════════════════════════════════════════
   TRACKSIDA – contacts.js
═══════════════════════════════════════════════ */

const params = new URLSearchParams(window.location.search);

/* ── DATA ─────────────────────────────────────── */
let contacts = [];

const PER_PAGE = 9;
let currentPage = 1;

/* ── HELPERS ──────────────────────────────────── */
const $ = id => document.getElementById(id);

function initials(c) {
  return (c.surnom ? c.surnom[0] : '?').toUpperCase();
}

function subline(c) {
  const e = c.email_partenaire || '';
  const t = c.telephone || '';
  if (e && t) return `${e} · ${t}`;
  return e || t || '—';
}

function totalPages() {
  return Math.max(1, Math.ceil(contacts.length / PER_PAGE));
}

function showToast(msg, color) {
  const t = $('toast');
  t.textContent = msg;
  t.style.background = color || 'var(--purple-dk)';
  t.classList.add('show');
  setTimeout(() => t.classList.remove('show'), 2600);
}

/* ── RENDER ───────────────────────────────────── */
function render() {
  $('totalCount').textContent = contacts.length;

  const start = (currentPage - 1) * PER_PAGE;
  const page  = contacts.slice(start, start + PER_PAGE);

  const list = $('contactList');
  list.innerHTML = '';

  if (contacts.length === 0) {
    list.innerHTML = `
      <div class="empty-state">
        <div class="empty-icon">👤</div>
        Aucun contact pour l'instant
      </div>`;
  } else {
    page.forEach(c => {
      const row = document.createElement('div');
      row.className = 'contact-row';
      row.dataset.id = c.id_partenaire;
      row.innerHTML = `
        <div class="contact-bar"></div>
        <div class="contact-avatar">${initials(c)}</div>
        <div class="contact-info">
          <div class="contact-name">${c.surnom ?? '—'}</div>
          <div class="contact-sub">${subline(c)}</div>
        </div>
        <button class="dots-btn" data-id="${c.id_partenaire}" aria-label="Options">···</button>
      `;
      list.appendChild(row);
    });
  }

  renderPagination();
}

/* ── PAGINATION ───────────────────────────────── */
function renderPagination() {
  const tp  = totalPages();
  const pag = $('pagination');
  pag.innerHTML = '';

  if (contacts.length === 0) return;

  const remaining = contacts.length - currentPage * PER_PAGE;

  const info = document.createElement('div');
  info.className = 'page-info';
  info.innerHTML = `
    <span class="plus-icon">+</span>
    Page ${currentPage} sur ${tp}${remaining > 0 ? ` → ${remaining} de plus` : ''}
  `;
  pag.appendChild(info);

  const nav = document.createElement('div');
  nav.className = 'page-nav';

  const prev = document.createElement('button');
  prev.className = 'page-btn';
  prev.textContent = '←';
  prev.disabled = currentPage === 1;
  prev.addEventListener('click', () => { currentPage--; render(); });
  nav.appendChild(prev);

  pageRange(currentPage, tp).forEach(p => {
    if (p === '…') {
      const dots = document.createElement('span');
      dots.textContent = '…';
      dots.style.cssText = 'padding:0 4px;color:var(--muted);font-weight:700;font-size:.85rem;';
      nav.appendChild(dots);
    } else {
      const btn = document.createElement('button');
      btn.className = `page-btn${p === currentPage ? ' active' : ''}`;
      btn.textContent = p;
      btn.addEventListener('click', () => { currentPage = p; render(); });
      nav.appendChild(btn);
    }
  });

  const next = document.createElement('button');
  next.className = 'page-btn';
  next.textContent = '→';
  next.disabled = currentPage === tp;
  next.addEventListener('click', () => { currentPage++; render(); });
  nav.appendChild(next);

  pag.appendChild(nav);
}

function pageRange(cur, total) {
  if (total <= 7) return Array.from({ length: total }, (_, i) => i + 1);
  const pages = [];
  if (cur <= 4) {
    pages.push(1,2,3,4,5,'…',total);
  } else if (cur >= total - 3) {
    pages.push(1,'…',total-4,total-3,total-2,total-1,total);
  } else {
    pages.push(1,'…',cur-1,cur,cur+1,'…',total);
  }
  return pages;
}

/* ── CONTEXT MENU ─────────────────────────────── */
let ctxTargetId = null;
const ctxMenu = $('ctxMenu');

function openCtx(btn) {
  ctxTargetId = btn.dataset.id;
  const rect = btn.getBoundingClientRect();
  ctxMenu.style.top  = (rect.bottom + window.scrollY + 4) + 'px';
  ctxMenu.style.left = Math.min(rect.left, window.innerWidth - 170) + 'px';
  ctxMenu.classList.add('open');
}
function closeCtx() { ctxMenu.classList.remove('open'); }

$('contactList').addEventListener('click', e => {
  const btn = e.target.closest('.dots-btn');
  if (!btn) return;
  e.stopPropagation();
  if (ctxMenu.classList.contains('open') && ctxTargetId === btn.dataset.id) {
    closeCtx();
  } else {
    openCtx(btn);
  }
});

document.addEventListener('click', e => {
  if (!ctxMenu.contains(e.target)) closeCtx();
});

/* ── EDIT ─────────────────────────────────────── */
$('ctxEdit').addEventListener('click', () => {
  const c = contacts.find(x => String(x.id_partenaire) === ctxTargetId);
  if (!c) return;
  closeCtx();

  $('formTitle').textContent  = 'Modifier le contact';
  $('submitForm').textContent = 'Enregistrer';
  $('editId').value  = c.id_partenaire;
  $('fNom').value    = c.surnom        ?? '';
  $('fEmail').value  = c.email_partenaire ?? '';
  $('fTel').value    = c.telephone     ?? '';
  $('fNotes').value  = c.notes         ?? '';

  clearErrors();
  openOverlay('formOverlay');
});

/* ── DELETE ───────────────────────────────────── */
$('ctxDelete').addEventListener('click', () => {
  const c = contacts.find(x => String(x.id_partenaire) === ctxTargetId);
  if (!c) return;
  closeCtx();
  $('deleteTarget').textContent = c.surnom ?? '—';
  openOverlay('deleteOverlay');
});

$('confirmDelete').addEventListener('click', () => {
  contacts = contacts.filter(x => String(x.id_partenaire) !== ctxTargetId);
  if (currentPage > totalPages()) currentPage = totalPages();
  render();
  closeOverlay('deleteOverlay');
  showToast('Contact supprimé', '#E74C3C');
});

/* ── ADD CONTACT ──────────────────────────────── */
$('openAddBtn').addEventListener('click', () => {
  $('formTitle').textContent  = 'Contact';
  $('submitForm').textContent = 'Ajouter';
  $('editId').value = '';
  $('fNom').value = $('fEmail').value = $('fTel').value = $('fNotes').value = '';
  clearErrors();
  openOverlay('formOverlay');
});

/* ── SUBMIT FORM ──────────────────────────────── */
$('submitForm').addEventListener('click', async () => {
  clearErrors();

  const surnom = $('fNom').value.trim();
  const email  = $('fEmail').value.trim();
  const tel    = $('fTel').value.trim();
  const notes  = $('fNotes').value.trim();
  const editId = $('editId').value;

  let valid = true;
  if (!surnom) { markError('fNom'); valid = false; }
  if (!email && !tel) {
    markError('fEmail');
    markError('fTel');
    valid = false;
    showToast('Email ou téléphone requis', '#E74C3C');
  }
  if (!valid) return;

  const formData = new FormData();
  formData.append('surnom', surnom);
  formData.append('email',  email);
  formData.append('tel',    tel);
  formData.append('notes',  notes);

  if (editId) {
    /* ── UPDATE ─────────────────────────────── */
    formData.append('id', editId);

    let ok = false;
    try {
      const res  = await fetch('../contact/m-contact.php', { method: 'POST', body: formData });
      const data = await res.json();
      ok = data.success === true;
    } catch (e) { ok = false; }

    if (!ok) {
      showToast('Erreur lors de la modification', '#E74C3C');
      return;
    }

    const idx = contacts.findIndex(x => String(x.id_partenaire) === editId);
    if (idx !== -1) contacts[idx] = {
      ...contacts[idx],
      surnom,
      email_partenaire: email,
      telephone:        tel,
      notes,
    };
    showToast('Contact modifié ✓');

  } else {
    /* ── ADD ────────────────────────────────── */
    let newId = null;
    try {
      const res  = await fetch('../contact/contact.php', { method: 'POST', body: formData });
      const data = await res.json();
      if (data.success === true) newId = data.id;
    } catch (e) { newId = null; }

    if (newId === null) {
      showToast('Erreur lors de l\'ajout', '#E74C3C');
      return;
    }

    contacts.push({
      id_partenaire:    newId,
      surnom,
      email_partenaire: email,
      telephone:        tel,
      notes,
    });
    currentPage = totalPages();
    showToast('Contact ajouté ✓', 'var(--green)');
  }

  render();
  closeOverlay('formOverlay');
});

function markError(id) { $(id).classList.add('error'); }
function clearErrors() {
  ['fNom','fEmail','fTel'].forEach(id => $(id).classList.remove('error'));
}

/* ── OVERLAY UTILS ────────────────────────────── */
function openOverlay(id) {
  $(id).classList.add('open');
  document.body.style.overflow = 'hidden';
}
function closeOverlay(id) {
  $(id).classList.remove('open');
  document.body.style.overflow = '';
}

document.querySelectorAll('[data-close]').forEach(btn => {
  btn.addEventListener('click', () => closeOverlay(btn.dataset.close));
});
document.querySelectorAll('.overlay').forEach(overlay => {
  overlay.addEventListener('click', e => {
    if (e.target === overlay) closeOverlay(overlay.id);
  });
});
document.addEventListener('keydown', e => {
  if (e.key === 'Escape') {
    ['formOverlay','deleteOverlay'].forEach(closeOverlay);
    closeCtx();
  }
});

/* ── INIT ─────────────────────────────────────── */
async function init() {
  try {
    const res  = await fetch('../contact/contact.php');
    const data = await res.json();
    if (data.success) {
      contacts = data.contacts;
    } else {
      showToast('Erreur lors du chargement', '#E74C3C');
    }
  } catch (e) {
    showToast('Impossible de charger les contacts', '#E74C3C');
  }

  render();

  if (params.get('add') === '1') {
    $('formTitle').textContent  = 'Contact';
    $('submitForm').textContent = 'Ajouter';
    $('editId').value = '';
    $('fNom').value = $('fEmail').value = $('fTel').value = $('fNotes').value = '';
    clearErrors();
    openOverlay('formOverlay');
  }
}

init();