<?php
include 'connexion_bd.php';
require_once 'Classes/projet.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom=trim($_POST['nom']);
    $description = trim($_POST['description']);
    $date_debut = trim($_POST['date_debut']) ;
    $date_fin_prevue	 =  trim($_POST['date_fin']) ;
    $statut = trim($_POST['statut']) ;
    $id_resp =  intval($_POST['responsables']) ;


        $projet = new projet(pdo: $pdo,nom: $nom, description: $description, date_debut: $date_debut, date_fin_prevue: $date_fin_prevue	, statut: $statut, id_resp: $id_resp);
    $true=$projet->insert();
       if($true){
header('Location:projet_admin.php'); 
      }
       else{
        echo"mission failed";
       }
    
}

?>