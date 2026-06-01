<?php
// On affiche les erreurs à l'écran si jamais un require plante avant le bloc try
ini_set('display_errors', 1);
error_reporting(E_ALL);

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

$id_ist = intval($input['id_ist']);
$date_depistage = safeInput($input['date']);
$resultat = safeInput($input['resultat']);
$partenaires = $input['contacts'] ?? [];

if (empty($date_depistage) || !in_array($resultat, ['positif', 'negatif'])) {
    echo json_encode(['success' => false, 'message' => 'Données du formulaire invalides.']);
    exit;
}

try {
    insertData("depistages", [
        'id_utilisateur' => $id_user,
        'id_ist' => $id_ist,
        'date_depistage' => $date_depistage,
        'resultat' => $resultat
    ]);

    if ($resultat === 'positif' && !empty($partenaires)) {
        
        $id_declaration = insertData("declarations_ist", [
            'id_utilisateur' => $id_user,
            'id_ist' => $id_ist,
            'date_diagnostic' => $date_depistage
        ]);

        foreach ($partenaires as $id_partenaire) {
            $token = bin2hex(random_bytes(16)); 
            
            insertData("notifications_anonymes", [
                'id_declaration' => $id_declaration,
                'id_partenaire' => intval($id_partenaire),
                'token_unique' => $token
            ]);
            
            $id_partenaire_clean = intval($id_partenaire);
            $partenaire_mail = selectSQL("SELECT `email_partenaire` FROM `partenaires` WHERE `id_partenaire` = " . $id_partenaire_clean . ";");
            
            if (!empty($partenaire_mail) && isset($partenaire_mail[0]["email_partenaire"])) {
                $mail_dest = $partenaire_mail[0]["email_partenaire"];
                try {
                    sendTracksidaAlert($mail_dest);
                } catch (Throwable $mailException) {
                }
            }
        }
    }

    echo json_encode(['success' => true, 'message' => 'Dépistage enregistré !']);

} catch (Throwable $e) {
    // Renvoie l'erreur au format JSON propre pour que JS puisse l'afficher sans crasher
    echo json_encode([
        'success' => false, 
        'message' => 'Erreur technique PHP : ' . $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine()
    ]);
}
?>