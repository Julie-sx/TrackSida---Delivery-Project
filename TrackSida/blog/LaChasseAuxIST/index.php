<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Tracksida – Article</title>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700;800;900&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../../css/style.css" />
  <link rel="stylesheet" href="../../css/article.css" />
</head>
<body class="app">

<?php require('../../module/header.php'); ?>

  <main>
    <article class="article-page">

      <!-- Bouton retour -->
      <button class="article-back" onclick="window.history.back()">
        ← Retour au blog
      </button>

      <!-- Tags -->
      <div class="article-tags">
        <span class="article-tag">Prévention</span>
        <span class="article-tag">Dépistage</span>
      </div>

      <!-- Titre -->
      <h1 class="article-title">La chasse aux IST</h1>

      <!-- Séparateur -->
      <hr class="article-divider" />

      <!-- Corps -->
      <div class="article-body">

        <p>
          Découvrez comment dépister et prévenir les infections sexuellement
          transmissibles au quotidien. Un guide complet pour mieux comprendre
          les risques et se protéger efficacement.
        </p>

        <h2>Comprendre les IST</h2>

        <p>
          Les infections sexuellement transmissibles (IST) sont des infections
          qui se transmettent principalement lors de rapports sexuels non
          protégés. Certaines peuvent aussi se transmettre par le sang ou de
          la mère à l'enfant.
        </p>

        <!-- Bloc mise en avant -->
        <div class="article-callout">
          💡 Se faire dépister régulièrement est le meilleur moyen de prendre
          soin de soi et de ses partenaires, même sans symptômes.
        </div>

        <h2>Les modes de transmission</h2>

        <p>Les principales voies de transmission sont :</p>

        <ul>
          <li>Les rapports sexuels vaginaux, anaux ou oraux non protégés</li>
          <li>Le partage de matériel d'injection</li>
          <li>Le contact avec du sang contaminé</li>
          <li>La transmission de la mère à l'enfant (grossesse, accouchement)</li>
        </ul>

        <h2>Se protéger au quotidien</h2>

        <h3>Le préservatif</h3>
        <p>
          Le préservatif (masculin ou féminin) reste le moyen le plus efficace
          pour se protéger contre la plupart des IST et les grossesses non
          désirées.
        </p>

        <h3>La PrEP</h3>
        <p>
          La prophylaxie pré-exposition (PrEP) est un traitement médicamenteux
          qui protège du VIH. Elle est disponible sur prescription et remboursée
          en France.
        </p>

        <h2>Où se faire dépister ?</h2>
        <p>
          Tu peux utiliser notre outil <strong>Dép-IST</strong> pour trouver
          le centre de dépistage le plus proche de chez toi.
        </p>

      </div>

    </article>
  </main>

<?php require('../../module/footer.php'); ?>

</body>
</html>