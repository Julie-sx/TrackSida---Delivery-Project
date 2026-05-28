<?php

require_once 'datas-traitment.php';

if (session_status() === PHP_SESSION_NONE) {
        session_start();
}

if(!viewSession()){
    header('Location:/auth/');
}

function isAdmin(){
    $userLevel=selectData('utilisateurs',['niveau'],['id_utilisateur'=>$_SESSION['user_id']]);
    if(!empty($userLevel)){
        $userLevel=intval($userLevel[0]['niveau']);
        if($userLevel>=10){
            return true;
        }else{
            return false;
        }
    }else{
        return false;
    }
}

?>