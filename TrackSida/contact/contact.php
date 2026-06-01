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

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $contacts = selectSQL(
        'SELECT id_partenaire, surnom, email_partenaire, telephone, notes
         FROM partenaires
         WHERE id_utilisateur = ' . (int) $_SESSION['user_id'] . '
         ORDER BY surnom ASC'
    );

    if (ob_get_length()) ob_clean();
    echo json_encode([
        'success'  => true,
        'contacts' => $contacts,
    ]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $surnom = safeInput($_POST['surnom'] ?? '');
    $email  = safeInput($_POST['email']  ?? '');
    $tel    = safeInput($_POST['tel']    ?? '');
    $notes  = safeInput($_POST['notes']  ?? '');

    if ($surnom === '') jsonError('Le surnom est obligatoire.');
    if ($email === '' && $tel === '') jsonError('Email ou téléphone obligatoire.');
    if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        jsonError('Adresse email invalide.');
    }

    $newId = insertData('partenaires', [
        'id_utilisateur'   => (int) $_SESSION['user_id'],
        'surnom'           => $surnom,
        'email_partenaire' => $email,
        'telephone'        => $tel,
        'notes'            => $notes,
    ]);

    if (ob_get_length()) ob_clean();
    http_response_code(201);
    echo json_encode(['success' => true, 'id' => $newId]);
    exit;
}

jsonError('Méthode non autorisée.', 405);