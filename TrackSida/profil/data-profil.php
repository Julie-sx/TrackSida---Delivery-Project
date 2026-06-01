<?php

require_once('../script/session.php');
require_once('../script/datas-traitment.php');

$id_user=$_SESSION['user_id'];

$userInfos = selectData("utilisateurs", ["pseudo", "email", "date_naissance", "genre", "derniere_connexion", "niveau", "date_inscription","telephone","ville"], ["id_utilisateur" => $id_user]);

if (!empty($userInfos)) {
    $userPseudo = $userInfos[0]["pseudo"];
    $userEmail = $userInfos[0]["email"];
    $userGenre = $userInfos[0]["genre"];
    $userNiveau = $userInfos[0]["niveau"];
    $userVille = $userInfos[0]["ville"];
    $userTel = $userInfos[0]["telephone"];
    if($userVille==Null){
        $userVille="Inconnue";
    }
    if($userTel==Null){
        $userTel="+33 ????????";
    }
    if($userEmail==Null){
        $userEmail="??@?.?";
    }
    if($userGenre==Null){
        $userGenre="Inconnue";
    }

    $rawDateNaiss = isset($userInfos[0]["date_naissance"]) ? trim($userInfos[0]["date_naissance"]) : '';
    if (!empty($rawDateNaiss) && $rawDateNaiss !== '0000-00-00' && $rawDateNaiss !== '0000-00-00 00:00:00') {
        try {
            $dateNaissObj = new DateTime($rawDateNaiss);
            $userDateNaissance = $dateNaissObj->format('d/m/Y');
        } catch (Exception $e) {
            $userDateNaissance = "Format invalide";
        }
    } else {
        $userDateNaissance = "Non renseignée";
    }

    $rawDerniereCon = isset($userInfos[0]["derniere_connexion"]) ? trim($userInfos[0]["derniere_connexion"]) : '';
    if (!empty($rawDerniereCon) && $rawDerniereCon !== '0000-00-00 00:00:00') {
        try {
            $dateConObj = new DateTime($rawDerniereCon);
            $userCon = $dateConObj->format('d/m/Y à H\hi');
        } catch (Exception $e) {
            $userCon = "Format invalide";
        }
    } else {
        $userCon = "Jamais connecté";
    }

    $rawDateInsc = isset($userInfos[0]["date_inscription"]) ? trim($userInfos[0]["date_inscription"]) : '';
    if (!empty($rawDateInsc) && $rawDateInsc !== '0000-00-00 00:00:00') {
        try {
            $dateInscObj = new DateTime($rawDateInsc);
            $userDi = $dateInscObj->format('d/m/Y');
            
            $aujourdhui = new DateTime();
            $intervalle = $dateInscObj->diff($aujourdhui);
            $userTime = $intervalle->format('%a');
        } catch (Exception $e) {
            $userDi = "Inconnue";
            $userTime = 0;
        }
    } else {
        $userDi = "Inconnue";
        $userTime = 0;
    }

    if ($userNiveau < 10) {
        $userType = "Utilisateur";
    } else {
        $userType = "Administrateur";
    }
    
    $initial = getInitials($userPseudo);
    $userPartenaires = selectSQL("SELECT COUNT(id_partenaire) as p FROM partenaires WHERE id_utilisateur = 1");
    if(!empty($userPartenaires)){
        $userPartenaires="0";
    }else{
        $userPartenaires=$userPartenaires[0]['p'];
    }
    $userDeclarations = selectSQL("SELECT COUNT(id_declaration) as d FROM declarations_ist WHERE id_utilisateur = 1");
    if(!empty($userDeclarations)){
        $userDeclarations="0";
    }else{
        $userDeclarations=$userDeclarations[0]['d'];
    }

} else {
    header('Location:../auth/deconnexion.php');
    exit;
}

function getInitials(string $chaine): string {
    $chaine = trim(preg_replace('/\s+/', ' ', $chaine));
    if (empty($chaine)) {
        return '';
    }
    $mots = explode(' ', $chaine);
    if (count($mots) > 1) {
        $initiale1 = mb_substr($mots[0], 0, 1);
        $initiale2 = mb_substr($mots[1], 0, 1);
        
        return mb_strtoupper($initiale1 . $initiale2);
    } 
    return mb_strtoupper(mb_substr($chaine, 0, 2));
}



?>