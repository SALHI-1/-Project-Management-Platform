<?php
session_start();
include 'connexion_bd.php';


// Vérification de l'existence de l'ID dans la session
if (!isset($_SESSION['id_resp'])) {
    session_unset();
    session_destroy();
    header('Location: login.php'); // Redirige vers la page de connexion si l'utilisateur n'est pas authentifié
    exit();
}
$id=$_SESSION['id_resp'];

try {
    // Préparation et exécution de la requête
    $sql = "SELECT * FROM utilisateur WHERE id = :id";
    $stm = $pdo->prepare($sql);
    $stm->bindParam(':id', $id, PDO::PARAM_INT);
    $stm->execute();
    $resp = $stm->fetch(PDO::FETCH_ASSOC); // Récupération des données d'admine

    // Si l'utilisateur n'existe pas, redirection
    if (!$resp) {
        header('Location: logout.php'); // Déconnecte et redirige en cas d'invalidité de l'admine
        exit();
    }
} catch (PDOException $e) {
    // Gestion des erreurs
    die("Erreur : " . $e->getMessage());
}

$sql1 = "SELECT * FROM projet WHERE id_resp = ?";
$stm = $pdo->prepare($sql1);
$stm->execute([$id]); // Le paramètre doit être passé dans un tableau
$projets = $stm->fetchAll(PDO::FETCH_ASSOC);


//récupérer les notifications des projets
$sql2 = "SELECT notification.* 
FROM notification JOIN projet ON notification.id_projet=projet.id join utilisateur on notification.id_createur=utilisateur.id 
WHERE projet.id_resp = ? 
AND utilisateur.role='Administrateur'
ORDER BY date_notification DESC
";
$sttm = $pdo->prepare($sql2);
$sttm->execute([$id]); // Le paramètre doit être passé dans un tableau
$notifications = $sttm->fetchAll(PDO::FETCH_ASSOC);



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body >
        <!-- Barre de navigation -->
        <nav class="bg-blue-900 shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="" class="text-white font-bold text-lg">Responsable Dashboard</a>
                </div>
                <!-- Menu -->
                <div class="hidden md:flex space-x-4">
                    <a href="home_resp.php" class="text-white hover:bg-blue-700 px-3 py-2 rounded">Mes Projets</a>
                    <a href="gerer_tache.php" class="text-white hover:bg-blue-700 px-3 py-2 rounded">Liste des taches</a>
                    <a href="logout.php" class="text-white hover:bg-blue-700 px-3 py-2 rounded">se déconnecter</a>
                </div>
              
            </div>
        </div>
        
    </nav>





    <div class="max-w-9xl mx-auto py-6 px-4 flex gap-4">
        <!-- Projects Section -->
        <div class="w-2/3">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
     
    
        <?php if (is_array($projets) && count($projets) > 0) {
            foreach($projets as $projet): ?>
                        <div class="bg-white shadow-lg rounded-lg  p-6">
                            <h2 class="text-lg font-bold text-blue-900 mb-2"><?php echo htmlspecialchars($projet['nom']); ?></h2>
                            <p class="text-gray-600 italic mb-4"><?php echo htmlspecialchars($projet['description']); ?></p>
                            <div class="text-sm text-gray-500">
                                <p><strong>Date Début:</strong> <?php echo htmlspecialchars($projet['date_debut']); ?></p>
                                <p><strong>Date Fin:</strong> <?php echo htmlspecialchars($projet['date_fin_prevue']); ?></p>
                            </div>
                            <div class="mt-4 flex justify-between items-center">
                                <span class="px-2 py-1 rounded-full <?php 
                                echo $projet['statut'] === 'Terminé' ? 'bg-green-100 text-green-800' : ($projet['statut'] === 'Annulé' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800'); ?>">
                                    <?php echo htmlspecialchars($projet['statut']); ?>
                                </span>
               
                                <div class="space-x-1">
                                    <a href="modif_projet_resp.php?id=<?php echo $projet['id']; ?>" 
                                       class="text-blue-700 hover:text-blue-700 font-bold">Modifier</a>
                                   
                                </div>
                            </div>
                        </div>
               
                        <?php endforeach;?>
                        <?php
                } else { ?>
                    <p class="text-center text-gray-500">Aucun projet trouvé.</p>
                <?php } ?>
            </div>
        </div>
        
        <!-- Div des notifications -->
        <div class="w-1/3 bg-white shadow-lg rounded-lg p-6 h-screen">
        <h2 class="text-lg font-bold text-blue-900 mb-4">Notifications</h2>
        <div class="space-y-4 overflow-y-auto h-[calc(100%-5rem)]">
            <?php if (is_array($notifications) && count($notifications) > 0) {
                foreach ($notifications as $notification): ?>
                    <div class="bg-gray-100 p-3 rounded-lg shadow-sm">
                        <p class="text-sm text-gray-800 font-medium mb-1"><?php echo htmlspecialchars($notification['titre']); ?></p>
                        <p class="text-xs text-gray-500"><?php echo htmlspecialchars($notification['texte']); ?></p>
                        <p class="text-xs text-gray-400 text-right"><?php echo htmlspecialchars($notification['date_notification']); ?></p>
                    </div>
                <?php endforeach;
            } else { ?>
                <p class="text-gray-500">Aucune notification trouvée.</p>
            <?php } ?>
        </div>
    </div>
</div>
</body>
</html>