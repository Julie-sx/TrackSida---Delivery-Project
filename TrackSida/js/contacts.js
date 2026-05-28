/* ═══════════════════════════════════════════════
   TRACKSIDA – contacts.js
═══════════════════════════════════════════════ */

const params = new URLSearchParams(window.location.search);

if (params.get('add') === '1') {
  $('formTitle').textContent = 'Contact';
  $('submitForm').textContent = 'Ajouter';
  $('editId').value = '';
  $('fNom').value = '';
  $('fPrenom').value = '';
  $('fEmail').value = '';
  $('fTel').value = '';

  clearErrors();
  openOverlay('formOverlay');
}

/* ── DATA ─────────────────────────────────────── */
let contacts = [
  { id: "[contact:id]", nom: '[contact:nom]', prenom: '[contact:prenom]', email: '[contact:email]', tel: '[contact:tel]' },
];

let nextId = "[contact:id]";

const PER_PAGE = 9;
let currentPage = 1;

/* ── HELPERS ──────────────────────────────────── */
const $ = id => document.getElementById(id);

function initials(c) {
  return (c.prenom[0] || '') + (c.nom[0] || '');
}

function subline(c) {
  if (c.email && c.tel) return `${c.email} · ${c.tel}`;
  return c.email || c.tel || '—';
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
  // total
  $('totalCount').textContent = contacts.length;

  // slice for current page
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
      row.dataset.id = c.id;
      row.innerHTML = `
        <div class="contact-bar"></div>
        <div class="contact-avatar">${initials(c)}</div>
        <div class="contact-info">
          <div class="contact-name">${c.prenom} ${c.nom}</div>
          <div class="contact-sub">${subline(c)}</div>
        </div>
        <button class="dots-btn" data-id="${c.id}" aria-label="Options">···</button>
      `;
      list.appendChild(row);
    });
  }

  renderPagination();
}

/* ── PAGINATION ───────────────────────────────── */
function renderPagination() {
  const tp = totalPages();
  const pag = $('pagination');
  pag.innerHTML = '';

  if (contacts.length === 0) return;

  const remaining = contacts.length - currentPage * PER_PAGE;

  // info text
  const info = document.createElement('div');
  info.className = 'page-info';
  info.innerHTML = `
    <span class="plus-icon">+</span>
    Page ${currentPage} sur ${tp}${remaining > 0 ? ` → ${remaining} de plus` : ''}
  `;
  pag.appendChild(info);

  // nav buttons
  const nav = document.createElement('div');
  nav.className = 'page-nav';

  // prev
  const prev = document.createElement('button');
  prev.className = 'page-btn';
  prev.textContent = '←';
  prev.disabled = currentPage === 1;
  prev.addEventListener('click', () => { currentPage--; render(); });
  nav.appendChild(prev);

  // page numbers (show up to 5 around current)
  const range = pageRange(currentPage, tp);
  range.forEach(p => {
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

  // next
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
  ctxTargetId = parseInt(btn.dataset.id);
  const rect = btn.getBoundingClientRect();
  ctxMenu.style.top  = (rect.bottom + window.scrollY + 4) + 'px';
  ctxMenu.style.left = Math.min(rect.left, window.innerWidth - 170) + 'px';
  ctxMenu.classList.add('open');
}
function closeCtx() { ctxMenu.classList.remove('open'); }

document.getElementById('contactList').addEventListener('click', e => {
  const btn = e.target.closest('.dots-btn');
  if (!btn) return;
  e.stopPropagation();
  if (ctxMenu.classList.contains('open') && ctxTargetId === parseInt(btn.dataset.id)) {
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
  const c = contacts.find(x => x.id === ctxTargetId);
  if (!c) return;
  closeCtx();

  $('formTitle').textContent = 'Modifier le contact';
  $('submitForm').textContent = 'Enregistrer';
  $('editId').value  = "[contact:id]";
  $('fNom').value    = '[contact:nom]';
  $('fPrenom').value = '[contact:prenom]';
  $('fEmail').value  = '[contact:email]';
  $('fTel').value    = '[contact:tel]';

  clearErrors();
  openOverlay('formOverlay');
});

/* ── DELETE ───────────────────────────────────── */
$('ctxDelete').addEventListener('click', () => {
  const c = contacts.find(x => x.id === ctxTargetId);
  if (!c) return;
  closeCtx();
  $('deleteTarget').textContent = `[contact:prenom] [contact:nom]`;
  openOverlay('deleteOverlay');
});

$('confirmDelete').addEventListener('click', () => {
  contacts = contacts.filter(x => x.id !== ctxTargetId);
  // clamp page
  if (currentPage > totalPages()) currentPage = totalPages();
  render();
  closeOverlay('deleteOverlay');
  showToast('Contact supprimé', '#E74C3C');
});

/* ── ADD CONTACT ──────────────────────────────── */
$('openAddBtn').addEventListener('click', () => {
  $('formTitle').textContent = 'Contact';
  $('submitForm').textContent = 'Ajouter';
  $('editId').value = '';
  $('fNom').value = $('fPrenom').value = $('fEmail').value = $('fTel').value = '';
  clearErrors();
  openOverlay('formOverlay');
});

/* ── SUBMIT FORM ──────────────────────────────── */
$('submitForm').addEventListener('click', () => {
  clearErrors();

  const nom    = $('fNom').value.trim();
  const prenom = $('fPrenom').value.trim();
  const email  = $('fEmail').value.trim();
  const tel    = $('fTel').value.trim();

  let valid = true;

  if (!nom)    { markError('fNom');    valid = false; }
  if (!prenom) { markError('fPrenom'); valid = false; }
  if (!email && !tel) {
    markError('fEmail');
    markError('fTel');
    valid = false;
    showToast('Email ou téléphone requis', '#E74C3C');
  }
  if (!valid) return;

  const editId = $('editId').value;

  if (editId) {
    // update
    const idx = contacts.findIndex(x => x.id === parseInt(editId));
    if (idx !== -1) contacts[idx] = { id: parseInt(editId), nom, prenom, email, tel };
    showToast('Contact modifié ✓');
  } else {
    // add
    contacts.push({ id: nextId++, nom, prenom, email, tel });
    currentPage = totalPages(); // go to last page to see new contact
    showToast('Contact ajouté ✓', 'var(--green)');
  }

  render();
  closeOverlay('formOverlay');
});

function markError(id) { $(id).classList.add('error'); }
function clearErrors() {
  ['fNom','fPrenom','fEmail','fTel'].forEach(id => $(id).classList.remove('error'));
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
render();