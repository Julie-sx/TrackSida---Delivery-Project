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
    
    $cgu = isset($_POST['cgu']) ? 1 : 0;
    echo("verif data set...");
    if (empty($prenom) || empty($nom) || empty($gender) || empty($email) || empty($password)) {
        header('Location: index.php?fail=err');
        exit;
    }
    echo("f1...");
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('Location: index.php?fail=invalid_email');
        exit;
    }
    echo("f2...");
    if (strlen($password) < 8) {
        header('Location: index.php?fail=pwd_too_short');
        exit;
    }
    echo("f3...");
    if ($password !== $password_confirm) {
        header('Location: index.php?fail=pwd_mismatch');
        exit;
    }
    echo("f4...");
    if ($cgu !== 1) {
        header('Location: index.php?fail=cgu_required');
        exit;
    }
    echo("f5...");
    if ($_POST['password']!=$password){
        header('Location: index.php?fail=err');
        exit;
    }
    echo("f6...");
    $password = hash('sha256',$password);
    echo("password hash...");
    echo('try bdd insert');
    $bdd_findUSer = selectData("utilisateurs",["id_utilisateur"],["email"=>$email]);

    if (!empty($bdd_findUSer)) {
        header('Location: index.php?fail=err');
        exit;
    }

    //ajout bdd

    $data_array=[
    "pseudo"=>$prenom." ".$nom,
    "email"=>$email,
    "genre"=>$gender,
    "mot_de_passe"=>$password
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