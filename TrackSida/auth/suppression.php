<?php
require_once('../script/session.php');
runSql("DELETE FROM `utilisateurs` WHERE `utilisateurs`.`id_utilisateur` = ".$_SESSION('user_id').";");
header('Location:deconnexion.php');

?>