<?php
include 'connexion_bd.php';
require_once 'Classes/projet.php';
session_start();
// Vérification de l'existence de l'ID dans la session
if (!isset($_SESSION['id_resp']) && !isset($_SESSION['nom_resp'])) {
    session_unset();
    session_destroy();
    header('Location: login.php'); // Redirige vers la page de connexion si l'utilisateur n'est pas authentifié
    exit();
}
$id_resp=$_SESSION['id_resp'];
$nom_resp=$_SESSION['nom_resp'];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit'])) {
        // Récupération et nettoyage des variables
        $nom = trim($_POST['nom']);
        $description = trim($_POST['description']);
        $date_debut = trim($_POST['date_debut']);
        $date_fin_prevue = trim($_POST['date_fin_prevue']);
        $statut = trim($_POST['statut']);
        $id = intval($_POST['id']);

        // Création d'une instance de la classe Projet
        $projet = new projet(pdo: $pdo, nom: $nom, description: $description, date_debut: $date_debut, date_fin_prevue: $date_fin_prevue, statut: $statut);

        // Mise à jour du projet
        $success = $projet->updateProjetResp($id);

       



        // Vérification et retour
        if ($success) {

        $titre="Modification du Projet";
        
        $texte="le responsable $nom_resp a modifie le projet $nom";
         // Préparation et exécution de la requête
        $sql = "INSERT INTO notification (titre, texte, id_createur,id_projet) VALUES ( :titre, :texte, :id_createur, :id_projet)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':titre' => $titre,
            ':texte' => $texte,
            ':id_createur' => $id_resp,
            ':id_projet' => $id,
        ]);

            header('Location:home_resp.php'); 
                } else {
            echo "Échec de la mise à jour";
        }
    }
}
?>
