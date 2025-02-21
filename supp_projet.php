<?php
include 'connexion_bd.php';
include 'Classes/projet.php';
$user_id = $_GET['delete'];
?>

<?php



$user = new projet($pdo);
$true=$user->delet_projet($user_id);
if($true){
header('Location: projet_admin.php');   }
   else{
    echo"mission failed";
   }

?>