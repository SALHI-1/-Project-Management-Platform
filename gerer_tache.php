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
WHERE 
    projet.id_resp = ? ";

$stm = $pdo->prepare($sql1);
$stm->execute([$id]); // Le paramètre doit être passé dans un tableau
$taches = $stm->fetchAll(PDO::FETCH_ASSOC);


//récipérer notifications
$sql2 = "SELECT 
   notification.*
FROM 
    notification
JOIN 
    tache ON notification.id_tache = tache.id
JOIN 
    projet ON tache.id_projet = projet.id
JOIN 
    utilisateur ON notification.id_createur=utilisateur.id  
WHERE 
    projet.id_resp = ? AND utilisateur.role='Membre'
ORDER BY notification.date_notification DESC
    ";

$stmt = $pdo->prepare($sql2);
$stmt->execute([$id]); // Le paramètre doit être passé dans un tableau
$notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);

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





<!-- Main Layout -->
<div class="max-w-9xl mx-auto py-6 px-4 flex flex-col lg:flex-row gap-6">
    <!-- Projects Section -->
    <div class="w-full lg:w-2/3">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php if (is_array($taches) && count($taches) > 0): ?>
                <?php foreach ($taches as $tache): ?>
                    <div class="bg-white shadow-lg rounded-lg p-6">
                        <h2 class="text-lg bg-gray-200 font-bold text-center text-blue-900 mb-2">
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
                            <span class="text-l text-blue-900"><strong><?php echo htmlspecialchars($tache['nom_projet']); ?></strong></span>
                        </p>
                        <p>
                            <strong class="text-sm text-gray-500">Membre associé :</strong>
                            <span class="text-l text-blue-900"><strong><?php echo htmlspecialchars($tache['nom_responsable_tache']); ?></strong></span>
                        </p>
                        <div class="space-x-8 ">
                            <a href="modif_tache.php?id=<?php echo $tache['id']; ?>" 
                               class="text-blue-500 hover:text-blue-700 font-bold">Modifier</a>
                            <a href="supp_tach.php?delete=<?php echo $tache['id']; ?>" 
                               class="text-red-500 hover:text-red-700 font-bold">Supprimer</a>
                        </div>
                               <!-- Bouton pour ouvrir le modal -->
        <button 
            onclick="openModal(<?php echo htmlspecialchars($tache['id']); ?>)" 
            class="bg-blue-900 text-white px-4 py-2 rounded-lg hover:bg-violet-700 transition mt-4">
            Ajouter un commentaire
        </button>
    
        <!-- Modal spécifique à chaque tâche -->
        <div id="modal-<?php echo $tache['id']; ?>" class="fixed top-0 left-0 w-full h-full bg-black bg-opacity-50 flex items-center justify-center hidden">
            <div class="bg-white rounded-lg shadow-lg w-1/2 p-6">
                <h3 class="text-lg font-bold mb-4 text-violet-600">Commentaires pour <?php echo htmlspecialchars($tache['nom_tache']); ?></h3>
                
                <!-- Liste des commentaires -->
                <div class="mb-4">
                    <?php
                    $sql2 = "SELECT commentaire.*, utilisateur.nom as auteur FROM utilisateur  JOIN commentaire ON utilisateur.id=commentaire.id_auteur WHERE commentaire.id_tache = ?";
                    $sttm = $pdo->prepare($sql2);
                    $sttm->execute([$tache['id']]);
                    $commentaires = $sttm->fetchAll(PDO::FETCH_ASSOC);
    
                    foreach ($commentaires as $commentaire): ?>
                        <div class="border-b py-2">
                            <p><?php echo htmlspecialchars($commentaire['texte']); ?></p>
                            <p class="text-sm text-gray-500">Envoyé Par : <?php echo htmlspecialchars($commentaire['auteur']); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
    
                <!-- Formulaire pour ajouter un commentaire -->
                <form action="ajouter_commentaire_resp.php" method="post">
                    <input type="hidden" name="id_tache" value="<?php echo htmlspecialchars($tache['id']); ?>">
                    <input type="hidden" name="nom_tache" value="<?php echo htmlspecialchars($tache['nom_tache']); ?>">

                    <input type="hidden" name="membre_id" value="<?php echo htmlspecialchars($id); ?>">

                    <textarea 
                        name="texte" 
                        rows="3" 
                        class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-600" 
                        placeholder="Écrivez votre commentaire ici..." 
                        required></textarea>
                    <button 
                        type="submit" 
                        class="bg-blue-900 text-white px-4 py-2 rounded-lg hover:bg-blue-500 transition mt-4">
                        Envoyer
                    </button>
                </form>
    
                <!-- Bouton pour fermer le modal -->
                <button 
                    onclick="closeModal(<?php echo htmlspecialchars($tache['id']); ?>)" 
                    class="mt-4 bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                    Fermer
                </button>
            </div>
        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center text-gray-500">Aucune tache trouvé.</p>
            <?php endif; ?>
        
        <div class="bg-white  shadow-lg rounded-lg p-6 flex items-center justify-center mt-6" style="min-height: 200px;">
            <a href="ajouter_tache.php" 
               class="text-green-500 hover:text-blue-700 font-bold text-center">Ajouter</a>
        </div>
    </div>
    </div>

    <!-- Sidebar des notifications -->
    <div class="w-full lg:w-1/3 bg-white shadow-lg rounded-lg p-6 h-screen">
        <h2 class="text-lg font-bold text-blue-900 mb-4">Notifications</h2>
        <div class="space-y-4 overflow-y-auto h-[calc(100%-5rem)]">
            <?php if (is_array($notifications) && count($notifications) > 0): ?>
                <?php foreach ($notifications as $notification): ?>
                    <div class="bg-gray-100 p-3 rounded-lg shadow-sm">
                        <p class="text-sm text-gray-800 font-medium mb-1"><?php echo htmlspecialchars($notification['titre']); ?></p>
                        <p class="text-xs text-gray-500"><?php echo htmlspecialchars($notification['texte']); ?></p>
                        <p class="text-xs text-gray-400 text-right"><?php echo htmlspecialchars($notification['date_notification']); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-gray-500">Aucune notification trouvée.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    // Fonction pour ouvrir le modal d'une tâche spécifique
function openModal(idTache) {
    document.getElementById(`modal-${idTache}`).classList.remove('hidden'); // Affiche le modal
}

// Fonction pour fermer le modal d'une tâche spécifique
function closeModal(idTache) {
    document.getElementById(`modal-${idTache}`).classList.add('hidden'); // Cache le modal
}

</script>
</body>
</html>