<?php
include 'connexion_bd.php';
require_once 'Classes/tache.php';

session_start();
// Vérification de l'existence de l'ID dans la session
if (!isset($_SESSION['id_resp']) && !isset($_SESSION['nom_resp'])) {
    session_unset();
    session_destroy();
    header('Location: login.php'); // Redirige vers la page de connexion si l'utilisateur n'est pas authentifié
    exit();
}
$id_owner=$_SESSION['id_resp'];
$nom_owner=$_SESSION['nom_resp'];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit'])) {
    // Récupération des données depuis le formulaire
$id = intval($_POST['id']);
$nom = trim($_POST['nom']);
$description = trim($_POST['description']);
$date_debut = trim($_POST['date_debut']);
$date_fin_prevue = trim($_POST['date_fin_prevue']);
$date_fin_reelle = trim($_POST['date_fin_reelle']);
$statut = trim($_POST['statut']);
$priorite = trim($_POST['priorite']);
$dep_projet=intval($_POST['dep_projet']);
$id_resp = intval($_POST['id_resp']);


// Création de l'objet tache avec les propriétés nécessaires
$tache = new tache(
     $pdo,
     $nom,
     $description,
     $date_debut,
     $date_fin_prevue,
     $date_fin_reelle ,
     $statut,
     $priorite,
     $id_resp,
    $dep_projet // Ajout de la priorité si nécessaire
);

        // Mise à jour du projet
        $success = $tache->updatetache($id);

        // Vérification et retour
        if ($success) {
            $titre="Modification d'une Tache";
        
            $texte="le responsable $nom_owner a modifie la tache $nom";
             // Préparation et exécution de la requête
            $sql = "INSERT INTO notification (titre, texte, id_createur,id_tache) VALUES ( :titre, :texte, :id_createur, :id_tache)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':titre' => $titre,
                ':texte' => $texte,
                ':id_createur' => $id_owner,
                ':id_tache' => $id,
            ]);
header('Location: gerer_tache.php');        } else {
            echo "Échec de la mise à jour";
        }
    }
}
?>
