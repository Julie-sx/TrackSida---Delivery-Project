<?php
    require_once '../script/datas-traitment.php';
    
    $blogs=selectData('blogs','*',[],"ORDER BY `date` DESC");
    function createBlog(string $nom, string $url,string $description="n'hesite pas à lire cet article"){
        $blog="<div onclick=\"window.location.href='/blog/".$url."'\" class=\"card\">
          <h3 class=\"card-title\">".$nom."</h3>
          <p class=\"card-excerpt\">".$description."</p>
          <div class=\"card-footer\"><button class=\"btn-lire\">Lire plus</button></div>
        </div>
        ";
        return $blog;
    }

    function blogWrite(int $id){
        global $blogs;
        $c_blog = $blogs[$id];
        if($c_blog['description']!=''){
            echo(createBlog($c_blog['blog_name'],$c_blog['blog_url'],$c_blog['description']));
        }else{
            echo(createBlog($c_blog['blog_name'],$c_blog['blog_url']));
        }
    }

    function lastBlogWrite(){
           blogWrite(0);
    }

    function allBlogsWrite(){
        global $blogs;
        $blogCount=count($blogs);
        for($i=1;$i<$blogCount;$i++){
            blogWrite($i);
        }
    }

    function tagsList(){
        $tags = selectData('tags', ['tag_name']);
        $output_tl = "";
        foreach ($tags as $tagRow) {
            $tag = $tagRow['tag_name'];
            $output_tl .= "<option value=\"" . htmlspecialchars($tag, ENT_QUOTES, 'UTF-8') . "\">" . htmlspecialchars($tag, ENT_QUOTES, 'UTF-8') . "</option>";
        }
        return $output_tl;
    }

    function insertBlogTags(int $id_blog, array $tags_names) {
        if (empty($tags_names)) {
            return;
        }

        foreach ($tags_names as $tag_name) {

            $tag_data = selectData('tags', ['id_tag'], ['tag_name' => $tag_name]);

            if (!empty($tag_data)) {
                $id_tag = $tag_data[0]['id_tag'];

                insertData('tags_list', [
                    'id_blog' => $id_blog,
                    'id_tag'  => $id_tag
                ]);
            }
        }
    }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title = isset($_POST['blog_title']) ? safeInput($_POST['blog_title']) : '';
    $description = isset($_POST['description']) ? safeInput($_POST['description']) : '';
    $content = isset($_POST['content']) ? safeInput($_POST['content']) : '';

    $tags = [];
    if (isset($_POST['tags']) && is_array($_POST['tags'])) {
        $tags = array_map('safeInput', $_POST['tags']);
    }
    if (empty($title) || empty($description) || empty($tags) || empty($content)) {
        header('Location: add-article.php?fail=err');
        exit;
    }

    //traitement bdd
    if (!is_dir($title)) {
    mkdir($title, 0755, true);
    }else{
        header('Location: add-article.php');
        exit;
    }

    $template = '<!DOCTYPE html>
        <html lang="fr">
        <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Tracksida – ' . htmlspecialchars($title) . '</title>
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700;800;900&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="../../css/style.css" />
        <link rel="stylesheet" href="../../css/article.css" />
        </head>
        <body class="app">

        <?php require(\'../../module/header.php\');
        require(\'../../script/datas-traitment.php\');
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

            <h1 class="article-title">[title]</h1>

            <hr class="article-divider" />

            <div class="article-body">
                [contenu]
            </div>

            </article>
        </main>

        <?php require(\'../../module/footer.php\'); ?>

        </body>
        </html>';

    $contenu_final = str_replace('[title]', htmlspecialchars($title), $template);
    
    $contenu_final = str_replace('[contenu]', nl2br(htmlspecialchars($content)), $contents_final ?? $contenu_final);

    $new_blog_id= insertData('blogs',['blog_name'=>$title,'blog_url'=>$title.'/','description'=>$description]);

    if ($new_blog_id > 0) {
        insertBlogTags($new_blog_id, $tags);
    }

    if (file_put_contents($title.'/index.php', $contenu_final) !== false){
        header('Location: '.$title.'/');
        exit;
    }

}


?>

