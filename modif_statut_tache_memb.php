<?php

include 'connexion_bd.php';
include 'classes/tache.php';

session_start();
$membre_id=$_SESSION['id_membre'] ;
$membre_nom=$_SESSION['nom_membre'] ;


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_tache'], $_POST['statut'])) {
    $id_tache = $_POST['id_tache'];
    $statut = $_POST['statut'];
    $nom=$_POST['nom_tache'];
    
    $tache = new tache(
        $pdo,
        $statut,
   );
   
           // Mise à jour du projet
           $success = $tache->update_statue_tache($id_tache,$statut);
   
           // Vérification et retour
           if ($success) {
               $titre="Modification d'une Tache";
           
               $texte="le membre $membre_nom a modifie le statut de la tache $nom";
                // Préparation et exécution de la requête
               $sql = "INSERT INTO notification (titre, texte, id_createur,id_tache) VALUES ( :titre, :texte, :id_createur, :id_tache)";
               $stmt = $pdo->prepare($sql);
               $stmt->execute([
                   ':titre' => $titre,
                   ':texte' => $texte,
                   ':id_createur' => $membre_id,
                   ':id_tache' => $id_tache,
               ]);
   header('Location: home_membre.php');        } else {
               echo "Échec de la mise à jour";
           }
       }

?>
