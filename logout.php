<?php
session_start();


    // Détruit toutes les variables de session
    session_unset();

    // Détruit la session
    session_destroy();

    // Redirige vers la page de connexion ou la page d'accueil
    header("Location: login.php");
    exit;

?>