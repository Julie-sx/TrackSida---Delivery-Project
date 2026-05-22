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
  <link rel="stylesheet" href="../css/map.css" />
  <link rel="stylesheet" href="../css/style.css" />
</head>
<body>
<div class="app">

  <?php
  require('../module/header.php');
  ?>

  <!-- SUB-HEADER -->
  <div class="subheader">
    <button onclick="window.location.href='/'" class="back-btn" aria-label="Retour">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <polyline points="15 18 9 12 15 6"/>
      </svg>
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

  <?php
  require('../module/footer.php');
  ?>

</div>


<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="../js/map.js"></script>
</body>
</html>