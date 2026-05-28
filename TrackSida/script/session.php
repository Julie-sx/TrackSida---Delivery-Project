<?php

require_once 'datas-traitment.php';

if (session_status() === PHP_SESSION_NONE) {
        session_start();
}

if(!viewSession()){
    header('Location:/auth/');
}

?>