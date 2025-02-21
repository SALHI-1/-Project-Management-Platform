<?php
include 'connexion_bd.php';
include 'Classes/utilisateur.php';
$user_id = $_GET['delet'];
?>

<?php



$user = new utilisateur($pdo,);
$true=$user->delet_user($user_id);
if($true){
header('Location: home_admin.php');   }
   else{
    echo"mission failed";
   }

?>