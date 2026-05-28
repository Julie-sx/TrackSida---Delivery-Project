<?php

require_once 'bdd.php';


// Permet de faire des selects ; via une table, une liste d'infos a selectionner, et une liste de paramètres
// exemple : selectData("utilisateur",["name","age"],["id"=>5]);

function selectData(string $table, array|string $infos = '*', array $parametres = []){
    global $pdo;

    //Creation requete
    if (is_array($infos) && !empty($infos)) {
        $columns = implode(', ', array_map(fn($col) => "`$col`", $infos));
    } else {
        $columns = '*';
    }
    $sql = "SELECT $columns FROM `$table`";

    if (!empty($parametres)) {
        $conditions = implode(' AND ', array_map(fn($key) => "`$key` = :$key", array_keys($parametres)));
        $sql .= " WHERE $conditions";
    }

    //execution PDO
    $stmt = $pdo->prepare($sql);
    $stmt->execute($parametres);

    return $stmt->fetchAll();
}

//Peremet d'insérer des datas dans la bdd, il faut préciser la table, les éléments ainsi que leur valeur

function insertData(string $table, array $data){
    global $pdo;

    //constructeur de requete
    $columns = implode(', ', array_map(fn($key) => "`$key`", array_keys($data)));
    $placeholders = implode(', ', array_map(fn($key) => ":$key", array_keys($data)));

    $sql  = "INSERT INTO `$table` ($columns) VALUES ($placeholders)";

    //exectution PDO
    $stmt = $pdo->prepare($sql);
    $stmt->execute($data);

    return (int) $pdo->lastInsertId();
}

// fonction utile pour verif des inputs

function safeInput(string $input){
    $input = strip_tags($input);
    $input = trim($input);
    $input = stripslashes($input);
    $input = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u', '', $input);
    $input = htmlspecialchars($input, ENT_QUOTES | ENT_HTML5, 'UTF-8');

    return $input;
}

//Session

function setSession(int $userId){
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Régénération de l'ID pour éviter la fixation de session
    session_regenerate_id(true);

    $_SESSION['user_id']      = $userId;
    $_SESSION['connecte_le']  = date('Y-m-d H:i:s');

}

function viewSession(){
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (empty($_SESSION['user_id'])) {
        return null;
    }else{
        return $_SESSION['user_id'];
    }
}

function killSession(){
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $_SESSION = [];
    session_destroy();
}