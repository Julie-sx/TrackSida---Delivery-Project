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
        $tags=selectData('tags',['tag_name']);
        for($i=0;$i<count($tags);$i++){
            $tag = $tags[$i]['tag_name'];
            echo("<option value=\"".$tag."\">".$tag."</option>");
        }
    }


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title = isset($_POST['blog_title']) ? safeInput($_POST['blog_title']) : '';
    $description = isset($_POST['description']) ? safeInput($_POST['description']) : '';
    $description = isset($_POST['content']) ? safeInput($_POST['content']) : '';

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

        <?php require(\'../../module/header.php\'); ?>

        <main>
            <article class="article-page">

            <button class="article-back" onclick="window.history.back()">
                ← Retour au blog
            </button>

            <div class="article-tags">
                [tags]
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

    insertData('blogs',['blog_name'=>$title,'blog_url'=>$title.'/','description'=>$description]);

    if (file_put_contents($title.'/index.php', $contenu_final) !== false){
        header('Location: '.$title.'/');
        exit;
    }

}



?>

