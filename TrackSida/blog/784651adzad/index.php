<!DOCTYPE html>
        <html lang="fr">
        <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Tracksida – 784651adzad</title>
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700;800;900&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="../../css/style.css" />
        <link rel="stylesheet" href="../../css/article.css" />
        </head>
        <body class="app">

        <?php require('../../module/header.php');
        require('../../script/datas-traitment.php');
        ?>

        <main>
            <article class="article-page">

            <button class="article-back" onclick="window.history.back()">
                ← Retour au blog
            </button>

            <div class="article-tags">
                <?php
                    $nomDossier = basename(__DIR__);
                    $rq="SELECT tag_name FROM tags AS t LEFT JOIN tags_list AS tl ON t.id_tag = tl.id_tag LEFT	JOIN blogs AS b ON tl.id_blog = b.id_blog WHERE	blog_name LIKE \"".$nomDossier."\"";
                    $tags=selectSQL($rq);
                    $rq_r="";
                    foreach($tags as $tag){
                        $rq_r.="<span class=\"article-tag\">".$tag["tag_name"]."</span>";
                    }
                    echo($rq_r);
                ?>
            </div>

            <h1 class="article-title">784651adzad</h1>

            <hr class="article-divider" />

            <div class="article-body">
                dzq
            </div>

            </article>
        </main>

        <?php require('../../module/footer.php'); ?>

        </body>
        </html>