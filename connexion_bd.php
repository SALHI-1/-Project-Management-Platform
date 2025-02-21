<?php
// Connexion à la base de données
try {
    $pdo = new PDO('mysql:host=localhost;dbname=gestion de projet', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>