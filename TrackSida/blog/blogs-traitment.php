<?php
    require_once '../script/datas-traitment.php';
    
    $blogs=selectData('blogs',['*'],[],"ORDER BY `date` DESC");
    
    function createBlog(string $nom, string $url,string $description="n'hesite pas à lire cet article"){
        $blog="<div onclick=\"window.location.href='/blog/".$url."'\" class=\"card\">
          <h3 class=\"card-title\">".$nom."<\"/h3>
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

    echo('test');
?>

