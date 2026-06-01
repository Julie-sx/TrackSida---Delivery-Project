<?php
require_once('../script/session.php');
require_once('../script/datas-traitment.php');

// Sécurité : Vérifier que l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "message" => "Non connecté"]);
    exit;
}

$id_user = $_SESSION['user_id'];

// On intercepte soit du POST classique, soit du JSON (fetch)
$input = json_decode(file_get_contents('php://input'), true);
$action = $_POST['action'] ?? $input['action'] ?? '';

header('Content-Type: application/json');

// --- ACTION 1 : MODIFICATION DES INFOS PERSONNELLES ---
if ($action === 'update_infos') {
    $email = isset($input['email']) ? safeInput($input['email']) : '';
    $phone = isset($input['phone']) ? safeInput($input['phone']) : '';
    $birthDate = isset($input['birthDate']) ? safeInput($input['birthDate']) : '';
    $city = isset($input['city']) ? safeInput($input['city']) : '';

    // Validation minimale pour l'e-mail
    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(["success" => false, "message" => "Adresse e-mail invalide."]);
        exit;
    }

    // Préparation de la requête SQL d'update personnalisée ou via tes fonctions
    // Ici avec runSql pour être précis sur les colonnes de ta table
    $query = "UPDATE utilisateurs SET 
                email = :email, 
                telephone = :phone, 
                date_naissance = :birth, 
                ville = :city 
              WHERE id_utilisateur = :id";
              
    $params = [
        "email" => $email,
        "phone" => $phone,
        "birth" => !empty($birthDate) ? $birthDate : null,
        "city" => $city,
        "id" => $id_user
    ];

    try {
        runSql($query, $params);
        echo json_encode(["success" => true, "message" => "Profil mis à jour !"]);
    } catch (Exception $e) {
        echo json_encode(["success" => false, "message" => "Erreur lors de la sauvegarde."]);
    }
    exit;
}

// --- ACTION 2 : MODIFICATION DU MOT DE PASSE ---
if ($action === 'changeMdp') {
    // Si envoyé par URLSearchParams (comme à la fin de ton profile.js)
    $password = $_POST['password'] ?? '';

    if (strlen($password) < 8) {
        echo json_encode(["success" => false, "message" => "Le mot de passe doit faire au moins 8 caractères."]);
        exit;
    }

    $passwordHash = hash('sha256', $password);

    try {
        runSql("UPDATE utilisateurs SET mot_de_passe = :mdp WHERE id_utilisateur = :id", [
            "mdp" => $passwordHash,
            "id" => $id_user
        ]);
        echo json_encode(["success" => true, "message" => "Mot de passe modifié avec succès !"]);
    } catch (Exception $e) {
        echo json_encode(["success" => false, "message" => "Erreur serveur."]);
    }
    exit;
}

echo json_encode(["success" => false, "message" => "Action inconnue."]);

?>