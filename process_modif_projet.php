<?php
include 'connexion_bd.php';
require_once 'Classes/projet.php';

session_start();
// Vérification de l'existence de l'ID dans la session
if (!isset($_SESSION['id_admin'])) {
    session_unset();
    session_destroy();
    header('Location: login.php'); // Redirige vers la page de connexion si l'utilisateur n'est pas authentifié
    exit();
}
$id_admin=$_SESSION['id_admin'];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit'])) {
        // Récupération et nettoyage des variables
        $nom = trim($_POST['nom']);
        $description = trim($_POST['description']);
        $date_debut = trim($_POST['date_debut']);
        $date_fin_prevue = trim($_POST['date_fin_prevue']);
        $statut = trim($_POST['statut']);
        $id_resp = intval($_POST['id_resp']);
        $id = intval($_POST['id']);

        // Création d'une instance de la classe Projet
        $projet = new projet(pdo: $pdo, nom: $nom, description: $description, date_debut: $date_debut, date_fin_prevue: $date_fin_prevue, statut: $statut, id_resp: $id_resp);

        // Mise à jour du projet
        $success = $projet->updateProjet($id);

        // Vérification et retour
        if ($success) {
            $titre="Modification du Projet";
        
            $texte="l'admine a modifie le projet $nom";
             // Préparation et exécution de la requête
            $sql = "INSERT INTO notification (titre, texte, id_createur,id_projet) VALUES ( :titre, :texte, :id_createur, :id_projet)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':titre' => $titre,
                ':texte' => $texte,
                ':id_createur' => $id_admin,
                ':id_projet' => $id,
            ]);
            header('Location:projet_admin.php');         } else {
            echo "Échec de la mise à jour";
        }
    }
}
?>
