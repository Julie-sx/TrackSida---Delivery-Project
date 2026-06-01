<?php
require_once('../script/mail.php');
require_once('../script/session.php');
require_once('../script/datas-traitment.php');

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Non connecté']);
    exit;
}

$id_user = $_SESSION['user_id'];
$input = json_decode(file_get_contents('php://input'), true);

if (!$input) {
    echo json_encode(['success' => false, 'message' => 'Aucune donnée reçue.']);
    exit;
}

// Récupération des données
$id_ist = intval($input['id_ist']);
$date_depistage = safeInput($input['date']);
$resultat = safeInput($input['resultat']);
$partenaires = $input['contacts'] ?? [];

if (empty($date_depistage) || !in_array($resultat, ['positif', 'negatif'])) {
    echo json_encode(['success' => false, 'message' => 'Données du formulaire invalides.']);
    exit;
}

try {
    // 1. On enregistre TOUJOURS le dépistage dans l'historique (Table depistages)
    insertData("depistages", [
        'id_utilisateur' => $id_user,
        'id_ist' => $id_ist,
        'date_depistage' => $date_depistage,
        'resultat' => $resultat
    ]);

    // 2. SI POSITIF ET CONTACTS SÉLECTIONNÉS : On déclenche l'alerte
    if ($resultat === 'positif' && !empty($partenaires)) {
        
        // On crée une déclaration technique pour lier les notifications
        $id_declaration = insertData("declarations_ist", [
            'id_utilisateur' => $id_user,
            'id_ist' => $id_ist,
            'date_diagnostic' => $date_depistage
        ]);

        // On prépare les liens anonymes pour chaque partenaire
        foreach ($partenaires as $id_partenaire) {
            $token = bin2hex(random_bytes(16)); 
            
            insertData("notifications_anonymes", [
                'id_declaration' => $id_declaration,
                'id_partenaire' => $id_partenaire,
                'token_unique' => $token
            ]);
            $partenaire_mail=selectSQL("SELECT `email_partenaire` FROM `partenaires` WHERE ".$id_partenaire.";");
            if(!empty($partenaire_mail)){
                $mail=$partenaire_mail[0]["email_partenaire"];
                sendTracksidaAlert($mail);
            }
        }
    }

    echo json_encode(['success' => true, 'message' => 'Dépistage enregistré !']);

} catch (Throwable $e) {
    echo json_encode(['success' => false, 'message' => 'Erreur technique : ' . $e->getMessage()]);
}
?>