<?php
ob_start();

header('Content-Type: application/json; charset=utf-8');

require_once('../script/session.php');

function jsonError(string $message, int $code = 400): void {
    if (ob_get_length()) ob_clean();
    http_response_code($code);
    echo json_encode(['success' => false, 'message' => $message]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonError('Méthode non autorisée.', 405);
}

$id     = trim($_POST['id']     ?? '');
$surnom = safeInput($_POST['surnom'] ?? '');
$email  = safeInput($_POST['email']  ?? '');
$tel    = safeInput($_POST['tel']    ?? '');
$notes  = safeInput($_POST['notes']  ?? '');

if ($id === '' || !ctype_digit($id)) jsonError('Identifiant invalide.');
if ($surnom === '') jsonError('Le surnom est obligatoire.');
if ($email === '' && $tel === '') jsonError('Email ou téléphone obligatoire.');
if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    jsonError('Adresse email invalide.');
}

$exists = selectData(
    'partenaires',
    ['id_partenaire'],
    ['id_partenaire' => (int) $id, 'id_utilisateur' => (int) $_SESSION['user_id']]
);

if (empty($exists)) {
    jsonError('Contact introuvable.', 404);
}

$ok = runSql(
    'UPDATE partenaires
     SET surnom           = :surnom,
         email_partenaire = :email,
         telephone        = :tel,
         notes            = :notes
     WHERE id_partenaire  = :id
       AND id_utilisateur = :uid',
    [
        ':surnom' => $surnom,
        ':email'  => $email,
        ':tel'    => $tel,
        ':notes'  => $notes,
        ':id'     => (int) $id,
        ':uid'    => (int) $_SESSION['user_id'],
    ]
);

if (!$ok) {
    jsonError('Erreur lors de la modification.', 500);
}

if (ob_get_length()) ob_clean(); 
echo json_encode(['success' => true]);