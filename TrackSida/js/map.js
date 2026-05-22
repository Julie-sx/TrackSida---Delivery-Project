/* ─── DONNÉES DES CLINIQUES ─── */
const clinicsData = [
  {
    id: 1,
    name: "CeGIDD Lariboisière",
    address: "2 rue Ambroise Paré, 75010 Paris",
    phone: "0144841717",
    lat: 48.8827, lng: 2.3550,
    distance: 0.3,
    open: true,
    anonymous: true,
    free: true,
    type: "CeGIDD"
  },
  {
    id: 2,
    name: "CDAG Saint-Louis",
    address: "1 ave Claude Vellefaux, 75010 Paris",
    phone: "0142494949",
    lat: 48.8705, lng: 2.3634,
    distance: 0.8,
    open: false,
    anonymous: true,
    free: true,
    type: "CDAG"
  },
  {
    id: 3,
    name: "Hôpital Hôtel-Dieu",
    address: "1 place du Parvis Notre-Dame, 75004 Paris",
    phone: "0142348034",
    lat: 48.8534, lng: 2.3499,
    distance: 1.2,
    open: true,
    anonymous: false,
    free: false,
    type: "Hôpital"
  },
  {
    id: 4,
    name: "Planning Familial 11e",
    address: "57 rue du Faubourg-Saint-Antoine, 75011",
    phone: "0143725232",
    lat: 48.8533, lng: 2.3735,
    distance: 1.6,
    open: true,
    anonymous: true,
    free: true,
    type: "Planning"
  },
  {
    id: 5,
    name: "CDAG Bichat",
    address: "46 rue Henri Huchard, 75018 Paris",
    phone: "0140258080",
    lat: 48.8966, lng: 2.3319,
    distance: 2.1,
    open: false,
    anonymous: true,
    free: false,
    type: "CDAG"
  },
  {
    id: 6,
    name: "CeGIDD Fernand Widal",
    address: "200 rue du Faubourg-Saint-Denis, 75010",
    phone: "0140054545",
    lat: 48.8792, lng: 2.3618,
    distance: 2.5,
    open: true,
    anonymous: true,
    free: true,
    type: "CeGIDD"
  },
    {
    id: 7,
    name: "Centre de santé sexuelle Henri Barbusse",
    address: "3 ter Rue Henri Barbusse, 94800 Villejuif",
    phone: "0156714188",
    lat: 48.7936,
    lng: 2.3637,
    distance: 0,
    open: false,
    anonymous: true,
    free: true,
    type: "Planning"
  },
  {
    id: 8,
    name: "Centre de santé sexuelle Stalingrad",
    address: "22 Avenue de Stalingrad, 94800 Villejuif",
    phone: "0156714187",
    lat: 48.7994,
    lng: 2.3559,
    distance: 0,
    open: false,
    anonymous: true,
    free: true,
    type: "Planning"
  },
  {
    id: 9,
    name: "Centre Municipal de Santé Pierre Rouquès",
    address: "43 Avenue Karl Marx, 94800 Villejuif",
    phone: "",
    lat: 48.7927,
    lng: 2.3645,
    distance: 0,
    open: false,
    anonymous: true,
    free: true,
    type: "Centre"
  },
  {
    id: 10,
    name: "CeGIDD Pitié-Salpêtrière",
    address: "47 Boulevard de l'Hôpital, 75013 Paris",
    phone: "0142177012",
    lat: 48.8383,
    lng: 2.3651,
    distance: 0,
    open: false,
    anonymous: true,
    free: true,
    type: "CeGIDD"
  },
  {
    id: 11,
    name: "CeGIDD Kremlin-Bicêtre",
    address: "78 Rue du Général Leclerc, 94270 Le Kremlin-Bicêtre",
    phone: "0145212121",
    lat: 48.8106,
    lng: 2.3612,
    distance: 0,
    open: false,
    anonymous: true,
    free: true,
    type: "CeGIDD"
  },
  {
    id: 12,
    name: "Centre IST Saint-Louis",
    address: "42 Rue Bichat, 75010 Paris",
    phone: "0142499924",
    lat: 48.8746,
    lng: 2.3692,
    distance: 0,
    open: true,
    anonymous: true,
    free: true,
    type: "CeGIDD"
  },
  {
    id: 13,
    name: "Le 190 - Centre de santé sexuelle",
    address: "90 Rue Jean-Pierre Timbaud, 75011 Paris",
    phone: "0155253272",
    lat: 48.8687,
    lng: 2.3776,
    distance: 0,
    open: true,
    anonymous: false,
    free: false,
    type: "Centre"
  },
  {
    id: 14,
    name: "Centre de Dépistage Paris 01",
    address: "43 Rue de Valois, 75001 Paris",
    phone: "0142613004",
    lat: 48.8641,
    lng: 2.3357,
    distance: 0,
    open: false,
    anonymous: true,
    free: true,
    type: "CDAG"
  },
  {
    id: 15,
    name: "Free Prevention and Screening Centre",
    address: "43 Rue de Valois, 75001 Paris",
    phone: "0142974829",
    lat: 48.8641,
    lng: 2.3357,
    distance: 0,
    open: false,
    anonymous: true,
    free: true,
    type: "CDAG"
  },
  {
    id: 16,
    name: "Centre gratuit de dépistage Bobigny",
    address: "8-22 Avenue du Chemin Vert, 93000 Bobigny",
    phone: "0171295838",
    lat: 48.9078,
    lng: 2.4394,
    distance: 0,
    open: false,
    anonymous: true,
    free: true,
    type: "CeGIDD"
  },

  {
    id: 17,
    name: "CeGIDD Ambroise-Paré",
    address: "9 Avenue Charles de Gaulle, 92100 Boulogne-Billancourt",
    phone: "0149095959",
    lat: 48.8417,
    lng: 2.2375,
    distance: 0,
    open: false,
    anonymous: true,
    free: true,
    type: "CeGIDD"
  },
  {
    id: 18,
    name: "CeGIDD Ridder",
    address: "3 Rue de Ridder, 75014 Paris",
    phone: "0145875414",
    lat: 48.8322,
    lng: 2.3141,
    distance: 0,
    open: false,
    anonymous: true,
    free: true,
    type: "CeGIDD"
  },  {
    id: 19,
    name: "Centre de Santé Sexuelle des Bluets",
    address: "9 Rue des Bluets, 75011 Paris",
    phone: "0155280290",
    lat: 48.8595,
    lng: 2.3833,
    distance: 0,
    open: false,
    anonymous: true,
    free: true,
    type: "Planning"
  },
  {
    id: 20,
    name: "Centre de Santé Sexuelle Cavé",
    address: "16 Rue Cavé, 75018 Paris",
    phone: "0153099425",
    lat: 48.8867,
    lng: 2.3519,
    distance: 0,
    open: false,
    anonymous: true,
    free: true,
    type:"Planning"
  }
];

let map, markers = [], userMarker = null;
let currentFilter = 'all';
let currentSearch = '';
let userLat = 48.875, userLng = 2.352; /* Paris par défaut */

/* ─── INIT MAP ─── */
window.addEventListener('load', () => {
  map = L.map('map', { zoomControl: false, attributionControl: false }).setView([userLat, userLng], 13);

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19
  }).addTo(map);

  L.control.zoom({ position: 'bottomright' }).addTo(map);

  document.getElementById('mapLoading').style.display = 'none';

  renderAll();
  addMarkersToMap();

  /* Auto-localisation au chargement */
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(pos => {
      userLat = pos.coords.latitude;
      userLng = pos.coords.longitude;
      updateDistances();
      setUserMarker(userLat, userLng);
      map.setView([userLat, userLng], 13);
      renderAll();
    }, () => {});
  }
});

/* ─── USER MARKER ─── */
function setUserMarker(lat, lng) {
  if (userMarker) map.removeLayer(userMarker);
  const userIcon = L.divIcon({
    html: `<div style="width:16px;height:16px;background:#7B7FD4;border:3px solid white;border-radius:50%;box-shadow:0 2px 8px rgba(123,127,212,.5)"></div>`,
    className: '',
    iconAnchor: [8, 8]
  });
  userMarker = L.marker([lat, lng], { icon: userIcon }).addTo(map);
  userMarker.bindPopup('<b style="font-family:Nunito">📍 Vous êtes ici</b>');
}

function updateDistances() {
  clinicsData.forEach(c => {
    const d = getDistance(userLat, userLng, c.lat, c.lng);
    c.distance = d;
  });
}

function getDistance(lat1, lng1, lat2, lng2) {
  const R = 6371;
  const dLat = (lat2 - lat1) * Math.PI / 180;
  const dLng = (lng2 - lng1) * Math.PI / 180;
  const a = Math.sin(dLat/2)**2 + Math.cos(lat1*Math.PI/180)*Math.cos(lat2*Math.PI/180)*Math.sin(dLng/2)**2;
  return Math.round(R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)) * 10) / 10;
}

/* ─── MAP MARKERS ─── */
function addMarkersToMap() {
  markers.forEach(m => map.removeLayer(m));
  markers = [];

  clinicsData.forEach(clinic => {
    const color = clinic.open ? '#4CAF8A' : '#FF6B6B';
    const icon = L.divIcon({
      html: `<div style="width:32px;height:32px;background:${color};border:3px solid white;border-radius:50% 50% 50% 0;transform:rotate(-45deg);box-shadow:0 2px 8px rgba(0,0,0,.2)"><div style="transform:rotate(45deg);width:100%;height:100%;display:flex;align-items:center;justify-content:center;font-size:14px">🏥</div></div>`,
      className: '',
      iconAnchor: [16, 32],
      iconSize: [32, 32]
    });

    const marker = L.marker([clinic.lat, clinic.lng], { icon }).addTo(map);
    marker.bindPopup(`
      <div style="font-family:Nunito;min-width:160px">
        <div style="font-weight:800;font-size:13px;margin-bottom:4px">${clinic.name}</div>
        <div style="font-size:11px;color:#8585A8;margin-bottom:6px">${clinic.address}</div>
        <div style="font-size:11px;font-weight:700;color:${clinic.open ? '#2E7D57' : '#C0392B'}">${clinic.open ? '● Ouvert' : '● Fermé'}</div>
      </div>
    `);

    marker.on('click', () => {
      highlightCard(clinic.id);
    });

    markers.push(marker);
    clinic._marker = marker;
  });
}

/* ─── FILTER ─── */
function setFilter(filter, el) {
  currentFilter = filter;
  document.querySelectorAll('.chip').forEach(c => c.classList.remove('active'));
  el.classList.add('active');
  renderAll();
}

/* ─── SEARCH ─── */
function onSearch(val) {
  currentSearch = val.toLowerCase();
  document.getElementById('clearBtn').classList.toggle('visible', val.length > 0);
  renderAll();
}

function clearSearch() {
  document.getElementById('searchInput').value = '';
  currentSearch = '';
  document.getElementById('clearBtn').classList.remove('visible');
  renderAll();
}

/* ─── LOCATE ─── */
function locateMe() {
  if (!navigator.geolocation) return;
  const btn = document.querySelector('.locate-btn');
  btn.style.opacity = '0.6';
  navigator.geolocation.getCurrentPosition(pos => {
    userLat = pos.coords.latitude;
    userLng = pos.coords.longitude;
    updateDistances();
    setUserMarker(userLat, userLng);
    map.flyTo([userLat, userLng], 14, { duration: 1.2 });
    btn.style.opacity = '1';
    renderAll();
  }, () => { btn.style.opacity = '1'; });
}

/* ─── RENDER ─── */
function getFiltered() {
  let list = [...clinicsData];

  if (currentSearch) {
    list = list.filter(c =>
      c.name.toLowerCase().includes(currentSearch) ||
      c.address.toLowerCase().includes(currentSearch) ||
      c.type.toLowerCase().includes(currentSearch)
    );
  }

  if (currentFilter === 'open') list = list.filter(c => c.open);
  else if (currentFilter === 'anon') list = list.filter(c => c.anonymous);
  else if (currentFilter === 'free') list = list.filter(c => c.free);
  else if (currentFilter === 'near') list = list.filter(c => c.distance <= 1.5);

  list.sort((a, b) => a.distance - b.distance);
  return list;
}

function renderAll() {
  const filtered = getFiltered();
  const container = document.getElementById('clinicsList');
  document.getElementById('resultsCount').textContent = `${filtered.length} clinique${filtered.length !== 1 ? 's' : ''}`;

  if (filtered.length === 0) {
    container.innerHTML = `
      <div class="empty-state">
        <div class="empty-icon">
          <svg width="28" height="28" fill="none" stroke="#7B7FD4" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        </div>
        <div class="empty-title">Aucun résultat</div>
        <div class="empty-desc">Essaie un autre nom ou modifie les filtres.</div>
      </div>`;
    return;
  }

  container.innerHTML = filtered.map((c, i) => `
    <div class="clinic-card" id="card-${c.id}" style="animation-delay:${i * 0.06}s" onclick="focusClinic(${c.id})">
      <div class="clinic-icon-wrap">
        <svg width="22" height="22" fill="none" stroke="#7B7FD4" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><line x1="12" y1="22" x2="12" y2="12"/><rect x="9" y="12" width="6" height="10"/><line x1="9" y1="7" x2="15" y2="7"/><line x1="12" y1="4" x2="12" y2="10"/></svg>
      </div>
      <div class="clinic-info">
        <div class="clinic-name">${c.name}</div>
        <div class="clinic-address">${c.address}</div>
        <div class="clinic-meta">
          <span class="meta-pill pill-dist">
            <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
            ${c.distance} km
          </span>
          <span class="meta-pill ${c.open ? 'pill-open' : 'pill-closed'}">
            ${c.open ? '● Ouvert' : '● Fermé'}
          </span>
          ${c.anonymous ? `<span class="meta-pill pill-anon">Anonyme</span>` : ''}
        </div>
      </div>
      <div class="clinic-actions" onclick="event.stopPropagation()">
        <button class="action-btn btn-map" onclick="focusClinic(${c.id})" title="Voir sur la carte">
          <svg width="18" height="18" fill="none" stroke="#7B7FD4" stroke-width="2" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
        </button>
        <button class="action-btn btn-call" onclick="window.location='tel:+33${c.phone}'" title="Appeler">
          <svg width="18" height="18" fill="none" stroke="#2E7D57" stroke-width="2" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13 19.79 19.79 0 0 1 1.61 4.4 2 2 0 0 1 3.58 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 9.91a16 16 0 0 0 6.16 6.16l.91-.91a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
        </button>
      </div>
    </div>
  `).join('');
}

/* ─── FOCUS CLINIC ─── */
function focusClinic(id) {
  const clinic = clinicsData.find(c => c.id === id);
  if (!clinic) return;

  map.flyTo([clinic.lat, clinic.lng], 15, { duration: 1 });
  if (clinic._marker) clinic._marker.openPopup();

  document.querySelectorAll('.clinic-card').forEach(el => el.classList.remove('highlighted'));
  const card = document.getElementById('card-' + id);
  if (card) {
    card.classList.add('highlighted');
    card.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
  }
}

function highlightCard(id) {
  document.querySelectorAll('.clinic-card').forEach(el => el.classList.remove('highlighted'));
  const card = document.getElementById('card-' + id);
  if (card) {
    card.classList.add('highlighted');
    card.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
  }
}