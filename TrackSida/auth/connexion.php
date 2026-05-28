<?php

require_once('../script/bdd.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $email = isset($_POST['email']) ? safeInput($_POST['email']) : '';
    
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    
    $remember = isset($_POST['remember']) ? 1 : 0;

    if (empty($email) || empty($password)) {
        header('Location: index.php?fail=err');
        exit;
    }
    if ($_POST['password']!=$password){
        header('Location: index.php?fail=err');
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('Location: index.php?fail=invalid_email');
        exit;
    }

    $password=hash('sha256',$password);
    $bdd_findUSer = selectData("utilisateurs",["mot_de_passe","id_utilisateur"],["email"=>$email]);

    if (empty($bdd_findUSer)) {
    header('Location: index.php?fail=invalid_password');
    exit;
    }

    $dt_password = $bdd_findUSer[0]['mot_de_passe'];

    if($password === $dt_password){
        setSession($bdd_findUSer[0]['id_utilisateur']);
        header('Location: index.php');
        exit;
    }else{
        header('Location: index.php?fail=invalid_password');
        exit;
    }


} else {
    header('Location: index.php');
    exit;
}
?>