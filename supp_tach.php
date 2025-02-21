<?php
include 'connexion_bd.php';
include 'Classes/tache.php';
$tache_id = $_GET['delete'];

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
?>

<?php



$tache = new tache($pdo);
//gérer notificaton
//récupérer les information de la tache
$sql = "SELECT * FROM tache WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $tache_id, PDO::PARAM_INT);
$stmt->execute();
$task = $stmt->fetch(PDO::FETCH_ASSOC);

            $titre="Suppression d'une Tache";  
            $texte="le responsable $nom_owner a supprimé la tache {$task['nom']}";
            $sql = "INSERT INTO notification (titre, texte, id_createur,id_tache) VALUES ( :titre, :texte, :id_createur, :id_tache)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':titre' => $titre,
                ':texte' => $texte,
                ':id_createur' => $id_owner,
                ':id_tache' => $tache_id,
            ]);
$true=$tache->delet_tache($tache_id);
if($true){
header('Location: gerer_tache.php');   }
   else{
    echo"mission failed";
   }

?>