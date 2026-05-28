<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
  <title>Ajouter un Article – Tracksida</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../css/add-article.css" />
</head>
<body>

<?php 
  require('../module/header.php'); 
  require_once('../script/session.php');
  if(!isAdmin()){
    header('Location:../');
  }
?>

<div class="app">

  <div class="subheader">
    <button onclick="window.location.href='/'" class="back-btn" aria-label="Retour">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <polyline points="15 18 9 12 15 6"/>
      </svg>
    </button>
    <span class="subheader-title">Nouvel article</span>
  </div>

  <main id="mainContent">
    <div class="section">
      <div class="section-title">
        <svg width="16" height="16" fill="none" stroke="#7B7FD4" stroke-width="2.2" viewBox="0 0 24 24">
          <path d="M12 20h9M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/>
        </svg>
        Créer une publication
      </div>

      <form method="POST" action="blogs-traitment.php" class="info-block article-form">
        
        <div class="form-group">
          <label for="article-title">Nom du blog</label>
          <input type="text" id="article-title" name="blog_title" placeholder="Ex: Comprendre la transmission..." required />
        </div>

        <div class="form-group">
          <label for="article-tags">Tags (Sélection multiple : Ctrl/Cmd + Clic)</label>
          <select id="article-tags" name="tags[]" multiple required class="info-select-multiple">
            <option value="transmission">Transmission</option>
            <option value="ist">IST</option>
            <option value="sante">Santé</option>
          </select>
          <span class="field-hint">Maintiens Ctrl (Windows) ou Cmd (Mac) pour sélectionner plusieurs tags.</span>
        </div>

        <div class="form-group">
          <label for="article-desc">Description</label>
          <textarea id="article-desc" name="description" placeholder="Rédige le contenu de ton article ici..." rows="8" required></textarea>
        </div>

        <div class="form-group">
          <label for="article-content">Contenu (HTML)</label>
          <textarea id="article-content" name="content" placeholder="Rédige le contenu de ton article ici..." rows="8" required></textarea>
        </div>

        <button type="submit" class="btn-submit btn-publish">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <line x1="22" y1="2" x2="11" y2="13"/>
            <polygon points="22 2 15 22 11 13 2 9 22 2"/>
          </svg>
          Publier l'article
        </button>

      </form>
    </div>
  </main>

</div>

<?php require('../module/footer.php'); ?>

</body>
</html>