<?php
include 'connexion_bd.php';
require_once 'Classes/utilisateur.php';

?>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = trim($_POST['email']);
        $nom = trim($_POST['nom']);
        $prenom = trim($_POST['prenom']);
        $mdp = trim($_POST['mdp']);
        $id = intval($_POST['id']);

        

        $user = new utilisateur($pdo,$nom, $prenom, $email);
      if(!empty($mdp))  {
        $user->setPwd($mdp);
        $true=$user->updateProfile_with_mdp($id);
       
    }
    else{
        $true=$user->updateProfile_no_mdp($id);

    }

    if($true){
header('Location: profile.php');
        exit;
    }
    else{
     echo"mission failed";

    }
    
}

?>