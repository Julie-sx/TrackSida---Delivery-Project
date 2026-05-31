<?php

require_once('../script/session.php');
require_once('../script/datas-traitment.php');

$id_user=$_SESSION['user_id'];

$userInfos = selectData("utilisateurs",["pseudo","email","date_naissance","genre","derniere_connexion","niveau"],["id_utilisateur"=>$id_user]);

if((!empty($userInfos))){
    $userPseudo = $userInfos[0]["pseudo"];
    $userEmail = $userInfos[0]["email"];
    $userDateNaissance = $userInfos[0]["date_naissance"];
    $userGenre = $userInfos[0]["genre"];
    $userCon = $userInfos[0]["derniere_connexion"];
    $userNiveau = $userInfos[0]["niveau"];
}else{
    header('Location:../auth/deconnexion.php');
    exit;
}

$userPartenaires=selectSQL("SELECT COUNT(id_partenaire) as p FROM partenaires WHERE id_utilisateur = 1")[0]['p'];
echo($userPartenaires);


?>