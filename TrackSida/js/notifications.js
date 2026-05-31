/* ═══════════════════════════════════════
   TRACKSIDA – notifications.js
═══════════════════════════════════════ */

/* ── DONNÉES ──────────────────────────────────────── */
/*
  type  : 'contact' | 'ist' | 'article' | 'profil'
  unread: true = non lue
  link  : page vers laquelle naviguer (optionnel)
*/
const NOTIFICATIONS = [
  {
    id: 1,
    type: 'contact',
    title: 'Nouveau contact ajouté',
    desc: 'Alex M. a été ajouté à ta liste de partenaires.',
    time: 'Il y a 5 min',
    unread: true,
    link: '/contact'
  },
  {
    id: 2,
    type: 'ist',
    title: 'IST signalée par un partenaire',
    desc: 'Un de tes partenaires a signalé une IST. Pense à te faire dépister.',
    time: 'Il y a 1h',
    unread: true,
    link: '/alerte'
  },
  {
    id: 3,
    type: 'contact',
    title: 'Contact modifié',
    desc: 'Les informations de Jordan T. ont été mises à jour.',
    time: 'Il y a 3h',
    unread: true,
    link: '/contact'
  },
  {
    id: 4,
    type: 'ist',
    title: 'IST signalée par toi',
    desc: 'Tu as signalé une IST. Tes partenaires ont été prévenus.',
    time: 'Hier',
    unread: true,
    link: '/alerte'
  },
  {
    id: 5,
    type: 'article',
    title: 'Nouvel article disponible',
    desc: 'Tout savoir sur la PrEP – prévention et accès.',
    time: 'Hier',
    unread: false,
    link: '/blog'
  },
  {
    id: 6,
    type: 'profil',
    title: 'Profil mis à jour',
    desc: 'Ton profil a bien été modifié.',
    time: 'Il y a 2 jours',
    unread: false,
    link: '/profil'
  },
  {
    id: 7,
    type: 'contact',
    title: 'Nouveau contact ajouté',
    desc: 'Sam L. a été ajouté à ta liste de partenaires.',
    time: 'Il y a 3 jours',
    unread: false,
    link: '/contact'
  },
  {
    id: 8,
    type: 'article',
    title: 'Nouvel article disponible',
    desc: 'IST et vie quotidienne : briser les tabous.',
    time: 'Il y a 4 jours',
    unread: false,
    link: '/blog'
  }
];

/* ── ICÔNES PAR TYPE ──────────────────────────────── */
const ICONS = {
  contact: '👥',
  ist:     '🔔',
  article: '📄',
  profil:  '👤'
};

/* ── ÉTAT ─────────────────────────────────────────── */
let notifications  = NOTIFICATIONS.map(n => ({ ...n }));
let currentFilter  = 'all';

/* ── HELPERS ──────────────────────────────────────── */
const $ = id => document.getElementById(id);

function unreadCount() {
  return notifications.filter(n => n.unread).length;
}

/* Met à jour le badge dans le header (si présent) */
function updateBadge() {
  const badge = document.querySelector('.notif-badge');
  if (!badge) return;
  const count = unreadCount();
  badge.textContent = count;
  badge.style.display = count > 0 ? 'flex' : 'none';
}

/* ── MARQUER UNE NOTIF COMME LUE ──────────────────── */
function markRead(id) {
  const notif = notifications.find(n => n.id === id);
  if (!notif || !notif.unread) return;

  notif.unread = false;

  /* Animation sur la carte */
  const card = document.querySelector(`.notif-card[data-id="${id}"]`);
  if (card) {
    card.classList.remove('unread');
  }

  updateBadge();
}

/* ── MARQUER TOUTES COMME LUES ────────────────────── */
function markAllRead() {
  notifications.forEach(n => { n.unread = false; });
  /* Met à jour toutes les cartes visibles sans re-render */
  document.querySelectorAll('.notif-card.unread').forEach(card => {
    card.classList.remove('unread');
  });
  updateBadge();
}

/* ── RENDU D'UNE CARTE ────────────────────────────── */
function createCard(notif, delay) {
  const article = document.createElement('article');
  article.className = `notif-card${notif.unread ? ' unread' : ''}`;
  article.setAttribute('data-id', notif.id);
  article.setAttribute('data-type', notif.type);
  article.setAttribute('role', 'listitem');
  article.style.animationDelay = `${delay * 45}ms`;

  article.innerHTML = `
    <div class="notif-icon notif-icon--${notif.type}" aria-hidden="true">
      ${ICONS[notif.type]}
    </div>
    <div class="notif-body">
      <p class="notif-body__title">${notif.title}</p>
      <p class="notif-body__desc">${notif.desc}</p>
      <time class="notif-body__time">${notif.time}</time>
    </div>
    <button
      class="btn-mark-read"
      aria-label="Marquer comme lu"
      data-id="${notif.id}"
    >Lu ✓</button>
  `;

  /* Clic sur le bouton → marquer comme lu */
  article.querySelector('.btn-mark-read').addEventListener('click', (e) => {
    e.stopPropagation();
    markRead(notif.id);
  });

  return article;
}

/* ── RENDU DE LA LISTE ────────────────────────────── */
function renderList() {
  const list  = $('notifList');
  const empty = $('notifEmpty');

  const filtered = currentFilter === 'all'
    ? notifications
    : notifications.filter(n => n.type === currentFilter);

  list.innerHTML = '';

  if (filtered.length === 0) {
    empty.hidden = false;
    return;
  }

  empty.hidden = true;
  filtered.forEach((notif, i) => list.appendChild(createCard(notif, i)));

  updateBadge();
}

/* ── FILTRES ──────────────────────────────────────── */
function initFilters() {
  document.querySelectorAll('.filter-pill').forEach(btn => {
    btn.addEventListener('click', () => {
      document.querySelectorAll('.filter-pill').forEach(b => {
        b.classList.remove('filter-pill--active');
        b.setAttribute('aria-selected', 'false');
      });
      btn.classList.add('filter-pill--active');
      btn.setAttribute('aria-selected', 'true');
      currentFilter = btn.dataset.filter;
      renderList();
    });
  });
}

/* ── INIT ─────────────────────────────────────────── */
document.addEventListener('DOMContentLoaded', () => {
  initFilters();
  renderList();

  $('btnReadAll').addEventListener('click', markAllRead);
});

function popup(texte, couleur) {
    // Création de l'overlay
    const overlay = document.createElement("div");
    overlay.style.position = "fixed";
    overlay.style.top = "0";
    overlay.style.left = "0";
    overlay.style.width = "100%";
    overlay.style.height = "100%";
    overlay.style.backgroundColor = "rgba(0, 0, 0, 0.5)";
    overlay.style.display = "flex";
    overlay.style.justifyContent = "center";
    overlay.style.alignItems = "center";
    overlay.style.zIndex = "9999";

    const popup = document.createElement("div");
    popup.style.backgroundColor = couleur;
    popup.style.padding = "20px";
    popup.style.borderRadius = "10px";
    popup.style.boxShadow = "0 4px 10px rgba(0,0,0,0.3)";
    popup.style.color = "white";
    popup.style.fontSize = "18px";
    popup.style.textAlign = "center";

    popup.textContent = texte;

    const boutonFermer = document.createElement("button");
    boutonFermer.textContent = "Fermer";
    boutonFermer.style.marginTop = "15px";
    boutonFermer.style.display = "block";
    boutonFermer.style.marginLeft = "auto";
    boutonFermer.style.marginRight = "auto";

    boutonFermer.onclick = () => {
        document.body.removeChild(overlay);
    };

    popup.appendChild(document.createElement("br"));
    popup.appendChild(boutonFermer);
    overlay.appendChild(popup);
    document.body.appendChild(overlay);
    setTimeout(() => {
        overlay.remove();
    }, 5000);
}