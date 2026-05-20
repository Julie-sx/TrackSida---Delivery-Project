<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
  <title>Cliniques de dépistage – Track SIDA</title>
  
  <!-- Polices et Bibliothèques Externes -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
  
  <!-- CSS Local -->
  <link rel="stylesheet" href="map.css" />
</head>
<body>
<div class="app">

  <!-- HEADER -->
  <header>
    <span class="logo">Track SIDA</span>
    <button class="notif-btn" aria-label="Notifications">
      <svg width="20" height="20" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
      <span class="notif-badge">2</span>
    </button>
  </header>

  <!-- SUB-HEADER -->
  <div class="subheader">
    <button class="back-btn" aria-label="Retour" onclick="history.back()">
      <svg width="16" height="16" fill="none" stroke="white" stroke-width="2.5" viewBox="0 0 24 24"><path d="M15 18l-6-6 6-6"/></svg>
    </button>
    <span class="subheader-title">Cliniques de dépistage</span>
  </div>

  <!-- MAIN -->
  <main>

    <!-- SEARCH -->
    <div class="search-wrap">
      <div class="search-input-wrap">
        <span class="search-icon">
          <svg width="18" height="18" fill="none" stroke="#8585A8" stroke-width="2.2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        </span>
        <input
          class="search-input"
          id="searchInput"
          type="text"
          placeholder="Chercher une clinique..."
          autocomplete="off"
          oninput="onSearch(this.value)"
        />
        <button class="search-clear" id="clearBtn" onclick="clearSearch()" aria-label="Effacer">
          <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
      </div>
      <button class="locate-btn" onclick="locateMe()" aria-label="Me localiser">
        <svg width="20" height="20" fill="none" stroke="white" stroke-width="2.2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><line x1="12" y1="2" x2="12" y2="5"/><line x1="12" y1="19" x2="12" y2="22"/><line x1="2" y1="12" x2="5" y2="12"/><line x1="19" y1="12" x2="22" y2="12"/></svg>
      </button>
    </div>

    <!-- CHIPS -->
    <div class="chips-wrap" id="chipsWrap">
      <button class="chip active" data-filter="all" onclick="setFilter('all', this)">Toutes</button>
      <button class="chip" data-filter="open" onclick="setFilter('open', this)">Ouvertes</button>
      <button class="chip" data-filter="anon" onclick="setFilter('anon', this)">Anonymes</button>
      <button class="chip" data-filter="free" onclick="setFilter('free', this)">Gratuites</button>
      <button class="chip" data-filter="near" onclick="setFilter('near', this)">Près de moi</button>
    </div>

    <!-- MAP -->
    <div class="map-container">
      <div class="map-loading" id="mapLoading">
        <div class="map-loading-icon"></div>
        <span class="map-loading-text">Chargement de la carte…</span>
      </div>
      <div id="map"></div>
    </div>

    <!-- RESULTS HEADER -->
    <div class="results-header">
      <span class="results-label">Résultats</span>
      <span class="results-count" id="resultsCount">— cliniques</span>
    </div>

    <!-- CLINIC LIST -->
    <div class="clinics-list" id="clinicsList"></div>

  </main>

  <!-- FOOTER -->
  <footer>
    <button class="footer-btn">
      <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
      Accueil
    </button>
    <button class="footer-btn active">
      <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
      Cliniques
    </button>
    <button class="footer-center">
      <svg width="26" height="26" fill="none" stroke="#7B7FD4" stroke-width="2.2" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
    </button>
    <button class="footer-btn">
      <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
      Résultats
    </button>
    <button class="footer-btn">
      <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
      Profil
    </button>
  </footer>

</div>


<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="map.js"></script>
</body>
</html>