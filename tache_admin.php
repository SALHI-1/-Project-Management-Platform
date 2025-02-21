<?php
session_start();
include 'connexion_bd.php';

// Vérification de l'existence de l'ID dans la session
if (!isset($_SESSION['id_admin'])) {
    session_unset();
    session_destroy();
    header('Location: login.php'); // Redirige vers la page de connexion si l'utilisateur n'est pas authentifié
    exit();
}
$id=$_SESSION['id_admin'];

try {
    // Préparation et exécution de la requête
    $sql = "SELECT * FROM utilisateur WHERE id = :id";
    $stm = $pdo->prepare($sql);
    $stm->bindParam(':id', $id, PDO::PARAM_INT);
    $stm->execute();
    $admin = $stm->fetch(PDO::FETCH_ASSOC); // Récupération des données d'admine

    // Si l'utilisateur n'existe pas, redirection
    if (!$admin) {
        header('Location: logout.php'); // Déconnecte et redirige en cas d'invalidité de l'admine
        exit();
    }
} catch (PDOException $e) {
    // Gestion des erreurs
    die("Erreur : " . $e->getMessage());
}

$sql1 = "SELECT 
    tache.id,
    tache.nom AS nom_tache,
    tache.description AS description_tache,
    tache.date_debut,
    tache.date_fin_prevue,
    tache.date_fin_reelle,
    tache.statut,
    tache.priorite,
    projet.nom AS nom_projet,
    utilisateur.nom AS nom_responsable_tache
FROM 
    tache
JOIN 
    projet ON tache.id_projet = projet.id
JOIN 
    utilisateur ON tache.id_affectataire = utilisateur.id
 ";

$stm = $pdo->prepare($sql1);
$stm->execute(); 
$taches = $stm->fetchAll(PDO::FETCH_ASSOC);



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
           <!-- Navigation Bar -->
    <nav class="bg-gradient-to-r from-violet-700 to-violet-500 shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="" class="text-yellow-300 font-extrabold text-3xl tracking-wider">M.<?= $admin['nom'].'  '.$admin['prenom'] ?></a>
                </div>
                <!-- Menu -->
                <div class="hidden md:flex space-x-4">
                <a href="profile.php" class="text-yellow-300 hover:bg-violet-600 px-4 py-2 rounded-lg text-lg font-medium">Mon Compte</a>
                    <a href="projet_admin.php" class="text-yellow-300 hover:bg-violet-600 px-4 py-2 rounded-lg text-lg font-medium">Les Projets</a>
                    <a href="tache_admin.php" class="text-yellow-300 hover:bg-violet-600 px-4 py-2 rounded-lg text-lg font-medium">Les Taches</a>
                    <a href="home_admin.php" class="text-yellow-300 hover:bg-violet-600 px-4 py-2 rounded-lg text-lg font-medium">Liste des Employés</a>
                    <a href="logout.php" class="text-yellow-300 hover:bg-violet-600 px-4 py-2 rounded-lg text-lg font-medium">Se Déconnecter</a>
                    
                </div>
            </div>
        </div>
    </nav>






<!-- Main Layout -->
<div class="max-w-9xl mx-auto py-6 px-4 flex flex-col lg:flex-row gap-6">
    <!-- Projects Section -->
    <div class="w-full lg:w-2/3">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php if (is_array($taches) && count($taches) > 0): ?>
                <?php foreach ($taches as $tache): ?>
                    <div class="bg-white shadow-lg rounded-lg p-6">
                        <h2 class="text-lg bg-gray-200 font-bold text-center from-violet-700 mb-2">
                            <?php echo htmlspecialchars($tache['nom_tache']); ?>
                        </h2>
                        <h2 class="text-lg text-gray-500"><strong>Description :</strong></h2>
                        <p class="text-gray-600 underline mb-4"><?php echo htmlspecialchars($tache['description_tache']); ?></p>
                        <div class="text-sm text-gray-500">
                            <p><strong>Date Début :</strong> <?php echo htmlspecialchars($tache['date_debut']); ?></p>
                            <p><strong>Date Fin Prévue :</strong> <?php echo htmlspecialchars($tache['date_fin_prevue']); ?></p>
                            <p><strong>Date Fin Réelle :</strong> <?php echo $tache['date_fin_reelle'] ? htmlspecialchars($tache['date_fin_reelle']) : '--/--/----'; ?></p>
                        </div>
                        <br>
                        <span class="px-2 py-1 rounded-full <?php 
                            echo $tache['statut'] === 'Terminé' ? 'bg-green-100 text-green-800' : 
                                ($tache['statut'] === 'Annulé' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800'); ?>">
                            Statut : <?php echo htmlspecialchars($tache['statut']); ?>
                        </span>
                        <br><br>
                        <span class="px-2 py-1 rounded-full <?php 
                            echo $tache['priorite'] === 'Haute' ? 'bg-red-100 text-white-800' : 
                                ($tache['priorite'] === 'Moyenne' ? 'bg-blue-100 text-white-800' : 'bg-yellow-100 text-white-800'); ?>">
                            Priorité : <?php echo htmlspecialchars($tache['priorite']); ?>
                        </span>
                        <br><br>
                        <p>
                            <strong class="text-sm text-gray-500">Projet associé :</strong>
                            <span class="text-l text-violet-700"><strong><?php echo htmlspecialchars($tache['nom_projet']); ?></strong></span>
                        </p>
                        <p>
                            <strong class="text-sm text-gray-500">Membre associé :</strong>
                            <span class="text-l text-violet-700"><strong><?php echo htmlspecialchars($tache['nom_responsable_tache']); ?></strong></span>
                        </p>
                    
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center text-gray-500">Aucune tache trouvé.</p>
            <?php endif; ?>
        
        
    </div>
    </div>


</div>


</body>
</html>