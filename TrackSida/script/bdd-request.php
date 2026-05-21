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

$partenairesListRequest = "SELECT id_utilisateur, surnom, email_partenaire, telephone, notes, date_ajout, date_contact FROM partenaires WHERE id_utilisateur = ?;";

function addPartenaire($id_u, $surnom, $email = null, $phone = null, $notes = null) {
    if ($phone === null && $email === null) {
        error_log("Erreur d'ajout : Il faut au moins un email ou un numéro de téléphone.");
        return false;
    }

    $colonnes = ['`id_utilisateur`', '`surnom`', '`date_ajout`'];
    $marqueurs = ['?', '?', 'CURRENT_TIMESTAMP'];
    $valeurs = [$id_u, $surnom];

    if ($email !== null) {
        $colonnes[] = '`email_partenaire`';
        $marqueurs[] = '?';
        $valeurs[] = $email;
    }
    
    if ($phone !== null) {
        $colonnes[] = '`telephone`';
        $marqueurs[] = '?';
        $valeurs[] = $phone;
    }
    
    if ($notes !== null) {
        $colonnes[] = '`notes`';
        $marqueurs[] = '?';
        $valeurs[] = $notes;
    }

    // Résultat ex: INSERT INTO `partenaires` (`id_utilisateur`, `surnom`, `date_ajout`, `email_partenaire`) VALUES (?, ?, CURRENT_TIMESTAMP, ?)
    $sql = "INSERT INTO `partenaires` (" . implode(', ', $colonnes) . ") VALUES (" . implode(', ', $marqueurs) . ")";

    return querySecure($sql, $valeurs);
}

$result = addPartenaire("1", "Melvin", "mel@email.com", null, "homme de ma vie");

if ($result) {
    echo("success");
} else {
    echo("erreur lors de l'insertion");
}
?>