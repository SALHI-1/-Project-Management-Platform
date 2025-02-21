<?php
include 'connexion_bd.php';
require_once 'Classes/utilisateur.php';

?>

<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit'])) {
        $email = trim($_POST['email']);
        $nom = trim($_POST['nom']);
        $prenom = trim($_POST['prenom']);
        $role = trim($_POST['role']);
        $mdp = trim($_POST['mdp']);
        $id = intval($_POST['id']);


        $user = new utilisateur($pdo,$nom, $prenom, $email,$role);
      if(!empty($mdp))  {
    $user->setPwd($mdp);
        $true=$user->updateUser_with_mdp($id);

      
    }
    else{
        $true=$user->updateUser_no_mdp($id);

    }
    if($true){
header('Location: home_admin.php');       }
       else{
        echo"mission failed";
       }

    }
}

?>