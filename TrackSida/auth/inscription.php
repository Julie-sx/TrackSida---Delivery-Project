<?php

require_once('../script/datas-traitment.php');

echo('...');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo("reception data...");
    $prenom = isset($_POST['prenom']) ? safeInput($_POST['prenom']) : '';
    $nom = isset($_POST['nom']) ? safeInput($_POST['nom']) : '';
    $gender = isset($_POST['gender']) ? safeInput($_POST['gender']) : '';
    $email = isset($_POST['email']) ? safeInput($_POST['email']) : '';
    $password = isset($_POST['password']) ? safeInput($_POST['password']) : '';
    $password_confirm = isset($_POST['password_confirm']) ? safeInput($_POST['password_confirm']) : '';
    $ville = isset($_POST['ville']) ? safeInput($_POST['ville']) : '';
    $telephone = isset($_POST['telephone']) ? safeInput($_POST['telephone']) : '';
    $dateN = isset($_POST['date_naissance']) ? safeInput($_POST['date_naissance']) : '';

    
    $cgu = isset($_POST['cgu']) ? 1 : 0;
    if (empty($prenom) || empty($nom) || empty($gender) || empty($email) || empty($password)) {
        header('Location: index.php?fail=err');
        exit;
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('Location: index.php?fail=invalid_email');
        exit;
    }

    if (strlen($password) < 8) {
        header('Location: index.php?fail=pwd_too_short');
        exit;
    }

    if ($password !== $password_confirm) {
        header('Location: index.php?fail=pwd_mismatch');
        exit;
    }
    if ($cgu !== 1) {
        header('Location: index.php?fail=cgu_required');
        exit;
    }
    if ($_POST['password']!=$password){
        header('Location: index.php?fail=pass_wr_err');
        exit;
    }
    echo("f6...");
    $password = hash('sha256',$password);
    echo("password hash...");
    echo('try bdd insert');
    $bdd_findUSer = selectData("utilisateurs",["id_utilisateur"],["email"=>$email]);

    if (!empty($bdd_findUSer)) {
        header('Location: index.php?fail=user_already');
        exit;
    }
    
    $pseudo_genere = $prenom . " " . $nom;
    $bdd_findPseudo = selectData("utilisateurs", ["id_utilisateur"], ["pseudo" => $pseudo_genere]);

    if (!empty($bdd_findPseudo)) {
        header('Location: index.php?fail=pseudo_exists');
        exit;
    }

    $data_array=[
    "pseudo"=>$prenom." ".$nom,
    "email"=>$email,
    "genre"=>$gender,
    "mot_de_passe"=>$password,
    "ville"=>$ville,
    "telephone"=>$telephone,
    "date_naissance"=>$dateN
    ];

    insertData("utilisateurs", $data_array);
    echo("redirection...");
    header('Location: index.php?success=trytoconnect');
    exit;

} else {
    header('Location: index.php');
    exit;
}
?>