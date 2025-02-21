<?php

include 'connexion_bd.php';
require_once 'Classes/commentaire.php';

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
    $id_tache = trim($_POST['id_tache']);
    $text = trim($_POST['texte']);
    $date = date('Y-m-d H:i:s');    
    $id_auteur = intval($_POST['membre_id']);
    $nom_tache = trim($_POST['nom_tache']);

    

    $comment = new commentaire($pdo,$text,$date,$id_auteur,$id_tache);
    $true=$comment->insert();
       if($true){
        $titre="Ajoutation d'un Commentaire";
        
        $texte_not="le responsable $nom_owner a ajouté un commentaire à la tache {$nom_tache}";
         // Préparation et exécution de la requête
        $sql = "INSERT INTO notification (titre, texte, id_createur,id_tache) VALUES ( :titre, :texte, :id_createur, :id_tache)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':titre' => $titre,
            ':texte' => $texte_not,
            ':id_createur' => $id_owner,
            ':id_tache' => $id_tache,
        ]);
        header('Location: gerer_tache.php');
        exit;
       }
       else{
        echo"mission failed";
       }
    
}
?>