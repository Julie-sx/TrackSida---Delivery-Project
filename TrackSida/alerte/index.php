<?php
require_once('../script/session.php');
require_once('../script/datas-traitment.php');

$id_user = $_SESSION['user_id'];

// 1. Récupération des partenaires de l'utilisateur connecté
$listePartenaires = selectData("partenaires", ["id_partenaire", "surnom"], ["id_utilisateur" => $id_user]);

$contacts_js = [];
foreach ($listePartenaires as $p) {
    $initiale = mb_strtoupper(mb_substr($p['surnom'], 0, 1));
    $contacts_js[] = [
        "id" => $p['id_partenaire'],
        "name" => $p['surnom'],
        "initials" => $initiale
    ];
}

// 2. Récupération de la liste des IST publiées
$listeIST = selectData("ist", ["id_ist", "nom"], ["est_publie" => 1]);

// 3. NOUVEAU : Récupération de l'historique des dépistages
// On utilise un LEFT JOIN car si id_ist = 0 (Bilan Complet), il n'y a pas de correspondance dans la table 'ist'
$sqlHistory = "SELECT d.id_depistage, d.date_depistage, d.resultat, d.id_ist, i.nom as ist_nom 
               FROM depistages d 
               LEFT JOIN ist i ON d.id_ist = i.id_ist 
               WHERE d.id_utilisateur = $id_user 
               ORDER BY d.date_depistage DESC, d.date_enregistrement DESC";
               
$historiqueBDD = selectSQL($sqlHistory);
$history_js = [];

if (!empty($historiqueBDD)) {
    foreach ($historiqueBDD as $dep) {
        // On récupère le nom (Bilan Complet si ID = 0)
        $istName = ($dep['id_ist'] == 0 || empty($dep['ist_nom'])) ? 'Bilan Complet' : $dep['ist_nom'];
        $res = $dep['resultat']; // 'positif' ou 'negatif'
        
        // On recrée le label exactement comme dans ton JS
        $label = ($res === 'negatif') 
            ? "Vous avez fait un dépistage – Négatif ($istName)" 
            : "Vous avez signalé une IST – Positif ($istName)";
            
        $type = ($res === 'negatif') ? 'depistage' : 'signal';
        
        $history_js[] = [
            'id' => $dep['id_depistage'],
            'type' => $type,
            'label' => $label,
            'result' => $res
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>TrackSida – Sid'Alerte</title>
  <link rel="stylesheet" href="../css/style.css" />
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../css/sid-alerte.css" />
</head>
<body>

<div class="app">

  <?php require('../module/header.php'); ?>

  <div class="subheader">
    <button onclick="window.location.href='/'" class="back-btn" aria-label="Retour">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <polyline points="15 18 9 12 15 6"/>
      </svg>
    </button>
    <span class="subheader-title">Sid'Alerte</span>
  </div>

  <main>
    <div class="history-card">
      <h2>Historique des dépistages et signalements</h2>
      <div id="historyList"></div>
      <div class="bottom-row">
        <div class="voir-plus" id="voirPlusBtn"><span>+</span> Voir plus</div>
        <button class="add-depistage-btn" id="openDepistageBtn" style="margin-left: auto;">＋ Ajouter un dépistage</button>
      </div>
    </div>
  </main>

  <?php require('../module/footer.php'); ?>

</div>

<div class="overlay" id="depistageOverlay" role="dialog" aria-modal="true">
  <div class="modal">
    <div class="modal-header">
      <h3>Ajouter un dépistage</h3>
      <button class="close-btn" data-close="depistageOverlay">✕</button>
    </div>
    <div class="modal-body">
      
      <div class="form-group">
        <label for="depistageType">Type de test <span class="req">*</span></label>
        <div class="select-wrapper">
          <select id="depistageType">
            <option value="0">Bilan Complet</option>
            <?php foreach ($listeIST as $ist): ?>
                <option value="<?= $ist['id_ist'] ?>">
                    <?= htmlspecialchars($ist['nom']) ?>
                </option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>
      
      <div class="form-group">
        <label for="depistageDate">Date du dépistage <span class="req">*</span></label>
        <input type="date" id="depistageDate" />
      </div>
      
      <div class="form-group">
        <label>Résultat <span class="req">*</span></label>
        <div class="result-btns small">
          <button class="result-btn positif" id="depPositif">Positif</button>
          <button class="result-btn negatif" id="depNegatif">Négatif</button>
        </div>
      </div>

      <div id="contactsGroup" style="display: none; margin-top: 20px;">
        <div class="form-group">
          <label>Contacts à avertir anonymement</label>
          <div class="contacts-list" id="contactsList"></div>
        </div>
      </div>
      
      <button class="submit-btn" id="submitDepistage">Enregistrer</button>
      
    </div>
  </div>
</div>

<div class="toast" id="toast"></div>

<script>
  // On passe dynamiquement la liste des contacts ET l'historique de la BDD au Javascript !
  const CONTACTS = <?php echo json_encode($contacts_js); ?>;
  let appHistory = <?php echo json_encode($history_js); ?>; 
</script>

<script src="../js/sid-alerte.js"></script>

</body>
</html>