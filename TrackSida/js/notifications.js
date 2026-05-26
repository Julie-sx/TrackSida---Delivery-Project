/* =============================
   TRACKSIDA — notifications.js
   ============================= */

// ── Données de démonstration ──────────────────────────────────────────────────
const NOTIFICATIONS = [
  {
    id: 1,
    type: 'alert',
    title: 'Sid\'Alert envoyée',
    desc: 'Tu as prévenu 3 partenaires il y a 2 heures.',
    time: 'Il y a 2h',
    unread: true,
    action: { label: 'Voir', href: '#' }
  },
  {
    id: 2,
    type: 'contact',
    title: 'Nouveau contact ajouté',
    desc: 'Alex M. a été ajouté à tes partenaires.',
    time: 'Il y a 4h',
    unread: true,
    action: { label: 'Profil', href: '#' }
  },
  {
    id: 3,
    type: 'info',
    title: 'Rappel de dépistage',
    desc: 'Ton prochain dépistage est recommandé dans 30 jours.',
    time: 'Hier',
    unread: true,
    action: { label: 'Carte', href: '#' }
  },
  {
    id: 4,
    type: 'alert',
    title: 'Réponse reçue',
    desc: 'Jordan T. a confirmé avoir reçu ton alerte.',
    time: 'Hier',
    unread: false,
    action: null
  },
  {
    id: 5,
    type: 'info',
    title: 'Mise à jour disponible',
    desc: 'Une nouvelle version de TRACKSIDA est disponible.',
    time: 'Il y a 2 jours',
    unread: false,
    action: null
  },
  {
    id: 6,
    type: 'contact',
    title: 'Partenaire introuvable',
    desc: 'Le contact Sam L. n\'a pas pu être joint.',
    time: 'Il y a 3 jours',
    unread: false,
    action: { label: 'Modifier', href: '#' }
  },
  {
    id: 7,
    type: 'info',
    title: 'Centre Dép-IST proche',
    desc: 'Un nouveau centre a ouvert à moins de 5 km de chez toi.',
    time: 'Il y a 5 jours',
    unread: false,
    action: { label: 'Carte', href: '#' }
  }
];

// ── État ──────────────────────────────────────────────────────────────────────
let currentFilter = 'all';
let notifications  = NOTIFICATIONS.map(n => ({ ...n }));

// ── Icônes SVG par type ───────────────────────────────────────────────────────
const ICONS = {
  alert: `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
    <line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
  </svg>`,
  info: `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
    <circle cx="12" cy="12" r="10"/>
    <line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
  </svg>`,
  contact: `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
    <circle cx="9" cy="7" r="4"/>
    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
  </svg>`
};

// ── Rendu d'une carte ─────────────────────────────────────────────────────────
function createCard(notif, delay) {
  const card = document.createElement('article');
  card.className = `notif-card${notif.unread ? ' notif-card--unread' : ''}`;
  card.setAttribute('data-id', notif.id);
  card.setAttribute('data-type', notif.type);
  card.style.animationDelay = `${delay * 50}ms`;
  card.setAttribute('role', 'button');
  card.setAttribute('tabindex', '0');
  card.setAttribute('aria-label', notif.title);

  const actionHTML = notif.action
    ? `<button class="notif-action" data-href="${notif.action.href}">${notif.action.label}</button>`
    : '';

  card.innerHTML = `
    <div class="notif-icon notif-icon--${notif.type}" aria-hidden="true">
      ${ICONS[notif.type]}
    </div>
    <div class="notif-body">
      <p class="notif-body__title">${notif.title}</p>
      <p class="notif-body__desc">${notif.desc}</p>
      <time class="notif-body__time">${notif.time}</time>
    </div>
    ${actionHTML}
  `;

  // Marquer comme lu au clic
  card.addEventListener('click', (e) => {
    if (e.target.classList.contains('notif-action')) return;
    markAsRead(notif.id);
  });

  // Accessibilité clavier
  card.addEventListener('keydown', (e) => {
    if (e.key === 'Enter' || e.key === ' ') {
      e.preventDefault();
      markAsRead(notif.id);
    }
  });

  // Bouton action
  const actionBtn = card.querySelector('.notif-action');
  if (actionBtn) {
    actionBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      markAsRead(notif.id);
    });
  }

  return card;
}

// ── Rendu de la liste ─────────────────────────────────────────────────────────
function renderList() {
  const list       = document.getElementById('notif-list');
  const emptyState = document.getElementById('empty-state');

  const filtered = currentFilter === 'all'
    ? notifications
    : notifications.filter(n => n.type === currentFilter);

  list.innerHTML = '';

  if (filtered.length === 0) {
    emptyState.hidden = false;
    return;
  }

  emptyState.hidden = true;
  filtered.forEach((notif, i) => {
    list.appendChild(createCard(notif, i));
  });

  updateBadge();
}

// ── Marquer comme lu ─────────────────────────────────────────────────────────
function markAsRead(id) {
  const notif = notifications.find(n => n.id === id);
  if (!notif || !notif.unread) return;

  notif.unread = false;

  // Animation douce sur la carte
  const card = document.querySelector(`.notif-card[data-id="${id}"]`);
  if (card) {
    card.classList.remove('notif-card--unread');
    card.style.transition = 'opacity 0.3s';
    setTimeout(() => { card.style.opacity = '0.75'; }, 10);
    setTimeout(() => { card.style.opacity = '1'; }, 300);
  }

  updateBadge();
}

// ── Tout marquer comme lu ─────────────────────────────────────────────────────
function markAllAsRead() {
  notifications.forEach(n => { n.unread = false; });
  renderList();
}

// ── Badge de l'icône cloche ───────────────────────────────────────────────────
function updateBadge() {
  const unreadCount = notifications.filter(n => n.unread).length;
  const badge = document.getElementById('badge-count');
  badge.textContent = unreadCount;
  badge.dataset.count = unreadCount;
}

// ── Filtres ───────────────────────────────────────────────────────────────────
function initFilters() {
  const buttons = document.querySelectorAll('.filter-btn');
  buttons.forEach(btn => {
    btn.addEventListener('click', () => {
      buttons.forEach(b => {
        b.classList.remove('filter-btn--active');
        b.setAttribute('aria-selected', 'false');
      });
      btn.classList.add('filter-btn--active');
      btn.setAttribute('aria-selected', 'true');
      currentFilter = btn.dataset.filter;
      renderList();
    });
  });
}

// ── Init ──────────────────────────────────────────────────────────────────────
function init() {
  initFilters();
  renderList();

  document.getElementById('btn-read-all')
    .addEventListener('click', markAllAsRead);
}

document.addEventListener('DOMContentLoaded', init);