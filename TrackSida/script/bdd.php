<?php
// Connexion Infos
$host    = 'rdqicartracksida.mysql.db';
$db      = 'rdqicartracksida';
$user    = 'rdqicartracksida';
$pass    = 'Trk789456123';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

// Config
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Active les exceptions
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Retourne les données sous forme de tableau associatif
    PDO::ATTR_EMULATE_PREPARES   => false, 
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    
    echo "Connexion réussie à la base de données !";

} catch (PDOException $e) {
    throw new PDOException($e->getMessage(), (int)$e->getCode());
}
?>