<?php
require_once("bdd.php");


function querySecure($sql, $params = [], $connexion = null) {
    global $pdo;

    $db = $connexion ?? $pdo;
    if (!$db instanceof PDO) {
        die("Erreur : La connexion à la base de données fournie n'est pas valide.");
    }

    try {
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        return $stmt;

    } catch (PDOException $e) {
        error_log("Erreur SQL : " . $e->getMessage());
        return false;
    }
}

$partenairesListRequest="SELECT id_utilisateur, surnom, email_partenaire, telephone, notes, date_ajout, date_contact FROM partenaires WHERE id_utilisateur = ? ;";

// ID-User, Surnom, email, phone, note
//(`id_utilisateur`, `surnom`, `email_partenaire`, `telephone`, `date_contact`, `notes`, `date_ajout`)
$partenairesAdd="INSERT INTO `partenaires` ? VALUES (?, CURRENT_TIMESTAMP)";

function addPartenaire($id_u,$surnom,$email=null,$phone=null,$notes=null){
    global $partenairesAdd;
    if($phone!=null || $email!=null){
        $rq_param1 ="(`id_utilisateur`, `surnom`";
        $rq_param2 = [$id_u,$surnom];
        if($email!=null){
            $rq_param1.=", `email_partenaire`";
            array_push($rq_param2,$email);
        }
        if($phone!=null){
            $rq_param1.=", `telephone`";
            array_push($rq_param2,$phone);
        }
        if($phone!=null){
            $rq_param1.=", `notes`";
            array_push($rq_param2,$notes);
        }
        $rq_param1.=", `date_ajout`)";
        querySecure($partenairesAdd,[$rq_param1,$rq_param2]);
    }else{
        error_log("Erreur SQL : wrong informations");
    }
}

addPartenaire("1","Melvin","mel@email.com",null,"homme de ma vie");


?>