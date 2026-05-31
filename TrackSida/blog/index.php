<?php 
  require_once '../script/session.php';
  require_once 'blogs-traitment.php'; 
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Tracksida – Blogs & Articles</title>
  <link rel= "stylesheet" href="../css/style.css">
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
    <span class="subheader-title">Blogs et Articles</span>
  </div>

  <!-- MAIN -->
  <main>
    <?php
    if(isAdmin()){
      echo("<section class=\"section-add\">
        <a href=\"add-article.php\">
        <button class=\"btn-add-article\">
          + Ajouter un article
        </button>
        </a>
      </section>");
    }
    ?>

    <section class="section">
      <h2 class="section-title">Article du mois</h2>
      <div>
        <?php lastBlogWrite(); ?>
      </div>
    </section>

    <section class="section">
      <h2 class="section-title">Tout savoir sur les IST</h2>
      <div>
        <?php allBlogsWrite(); ?>
      </div>
    </section>

  </main>

  <?php
  require('../module/footer.php');
  ?>

</div>
</body>
</html>
