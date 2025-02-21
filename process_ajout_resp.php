<?php
include 'connexion_bd.php';
require_once 'Classes/utilisateur.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit'])) {
        $email = trim($_POST['email']);
        $mdp = trim($_POST['mdp']);
        $nom = trim($_POST['nom']);
        $prenom = trim($_POST['prenom']);
        $role = trim($_POST['role']);


        $user = new utilisateur($pdo,$nom, $prenom, $email, $role);
        $user->setPwd($mdp);
    $true=$user->insert();
       if($true){
header('Location: home_admin.php');       }
       else{
        echo"mission failed";
       }
    }
}

?>