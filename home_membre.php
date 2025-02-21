<?php
session_start();
include 'connexion_bd.php';

// Vérification de l'existence de l'ID dans la session
if (!isset($_SESSION['id_membre'])) {
    session_unset();
    session_destroy();
    header('Location: login.php'); // Redirige vers la page de connexion si l'utilisateur n'est pas authentifié
    exit();
}
$id=$_SESSION['id_membre'];

try {
    // Préparation et exécution de la requête
    $sql = "SELECT * FROM utilisateur WHERE id = :id";
    $stm = $pdo->prepare($sql);
    $stm->bindParam(':id', $id, PDO::PARAM_INT);
    $stm->execute();
    $membre = $stm->fetch(PDO::FETCH_ASSOC); // Récupération des données d'admine

    // Si l'utilisateur n'existe pas, redirection
    if (!$membre) {
        header('Location: logout.php'); // Déconnecte et redirige en cas d'invalidité de l'admine
        exit();
    }
} catch (PDOException $e) {
    // Gestion des erreurs
    die("Erreur : " . $e->getMessage());
}
//selecter les taches associées
$sql1 = "SELECT tache.* ,projet.nom as nom_projet FROM projet  JOIN tache ON projet.id=tache.id_projet WHERE tache.id_affectataire  = ? ";
$sttm = $pdo->prepare($sql1);
$sttm->execute([$id]); // Le paramètre doit être passé dans un tableau
$taches = $sttm->fetchAll(PDO::FETCH_ASSOC);

//récupérer les notifications 
//je dois régler cette requête pour récupérer les notifications concernants les taches de ce user et seulement les notifications crée par le responsable
$sql2 = "SELECT notification.*  FROM notification  JOIN tache ON notification.id_tache=tache.id join utilisateur ON notification.id_createur=utilisateur.id   WHERE tache.id_affectataire = ? AND role='Responsable' ORDER BY date_notification DESC";
$stttm = $pdo->prepare($sql2);
$stttm->execute([$id]); // Le paramètre doit être passé dans un tableau
$notifications = $stttm->fetchAll(PDO::FETCH_ASSOC);


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
        <nav class="bg-blue-600 shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="" class="text-white font-bold text-lg"><?= $membre['nom'] ?></a>
                </div>
                <!-- Menu -->
                <div class="hidden md:flex space-x-4">
                    <a href="home_membre.php" class="text-white hover:bg-blue-700 px-3 py-2 rounded">Mes Taches</a>
                    <a href="logout.php" class="text-white hover:bg-blue-700 px-3 py-2 rounded">se déconnecter</a>
                </div>
              
            </div>
        </div>
        
    </nav>





  <!-- Main Layout -->
  <div class=" w-9xl mx-auto py-6 px-4 flex gap-4">
 <!-- Projects Section -->
 <div class="w-2/3">

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php if (is_array($taches) && count($taches) > 0) {
     foreach ($taches as $tache): ?>
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-lg bg-gray-200 font-bold text-center text-violet-600 mb-2">
            <?php echo htmlspecialchars($tache['nom']); ?>
        </h2>
        <h2 class="text-lg text-gray-500"><strong>Description : </strong></h2>
        <p class="text-gray-600 underline mb-4"><?php echo htmlspecialchars($tache['description']); ?></p>
        <div class="text-sm text-gray-500">
            <p><strong>Date Début:</strong> <?php echo htmlspecialchars($tache['date_debut']); ?></p>
            <p><strong>Date Fin Prévue:</strong> <?php echo htmlspecialchars($tache['date_fin_prevue']); ?></p>
            <p><strong>Date Fin Réelle:</strong> <?php echo $tache['date_fin_reelle'] != NULL ? $tache['date_fin_reelle'] : '--/--/----'; ?></p>
            <br>
            <span class="px-2 py-1 rounded-full <?php 
                echo $tache['statut'] === 'Terminé' ? 'bg-green-100 text-green-800' : ($tache['statut'] === 'Bloquée' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800'); ?>">
                Statue : <?php echo htmlspecialchars($tache['statut']); ?>
            </span>
            <button 
    onclick="openStatusModal(<?php echo htmlspecialchars($tache['id']); ?>)" 
    class="ml-2 bg-blue-500 text-white px-2 py-0.5 rounded hover:bg-blue-600 text-sm">
    Modifier
</button>

            <!-- Modal pour modifier le statut -->
<div id="status-modal-<?php echo $tache['id']; ?>" class="fixed top-0 left-0 w-full h-full bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-lg w-1/3 p-6">
        <h3 class="text-lg font-bold mb-4 text-blue-600">Modifier le statut pour <?php echo htmlspecialchars($tache['nom']); ?></h3>
        <form action="modif_statut_tache_memb.php" method="post">
            <input type="hidden" name="id_tache" value="<?php echo htmlspecialchars($tache['id']); ?>">
            <input type="hidden" name="nom_tache" value="<?php echo htmlspecialchars($tache['nom']); ?>">
            <label for="statut" class="block mb-2 text-sm font-medium text-gray-700">Nouveau statut</label>
            <select 
                name="statut" 
                id="statut" 
                class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600" 
                required>
                <option value="A_faire" <?php echo $tache['statut'] === 'A_faire' ? 'selected' : ''; ?>>A faire</option>
                <option value="En_cours" <?php echo $tache['statut'] === 'En_cours' ? 'selected' : ''; ?>>En cours</option>
                <option value="Terminé" <?php echo $tache['statut'] === 'Terminé' ? 'selected' : ''; ?>>Terminé</option>
                <option value="Bloquée" <?php echo $tache['statut'] === 'Bloquée' ? 'selected' : ''; ?>>Bloquée</option>

            </select>
            <button 
                type="submit" 
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition mt-4">
                Sauvegarder
            </button>
        </form>
        <button 
            onclick="closeStatusModal(<?php echo htmlspecialchars($tache['id']); ?>)" 
            class="mt-4 bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
            Fermer
        </button>
    </div>
</div>
<!--fin modale --> 
            <br><br>
            <span class="px-2 py-1 rounded-full <?php 
                echo $tache['priorite'] === 'Haute' ? 'bg-red-100 text-white-800' : ($tache['priorite'] === 'Moyenne' ? 'bg-blue-100 text-white-800' : 'bg-yellow-100 text-white-800'); ?>">
                Priorité : <?php echo htmlspecialchars($tache['priorite']); ?>
            </span>
            <br><br>
            <p>
                <strong class="text-sm text-gray-500">Projet associé : </strong>
                <span class="text-l text-violet-600"><strong><?php echo htmlspecialchars($tache['nom_projet']); ?></strong></span>
            </p>
        </div>
    
        <!-- Bouton pour ouvrir le modal -->
        <button 
            onclick="openModal(<?php echo htmlspecialchars($tache['id']); ?>)" 
            class="bg-violet-600 text-white px-4 py-2 rounded-lg hover:bg-violet-700 transition mt-4">
            Ajouter un commentaire
        </button>
    
        <!-- Modal spécifique à chaque tâche -->
        <div id="modal-<?php echo $tache['id']; ?>" class="fixed top-0 left-0 w-full h-full bg-black bg-opacity-50 flex items-center justify-center hidden">
            <div class="bg-white rounded-lg shadow-lg w-1/2 p-6">
                <h3 class="text-lg font-bold mb-4 text-violet-600">Commentaires pour <?php echo htmlspecialchars($tache['nom']); ?></h3>
                
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
                            <p class="text-sm text-gray-500"> Envoyé Par : <?php echo htmlspecialchars($commentaire['auteur']); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
    
                <!-- Formulaire pour ajouter un commentaire -->
                <form action="ajouter_commentaire_membre.php" method="post">
                    <input type="hidden" name="id_tache" value="<?php echo htmlspecialchars($tache['id']); ?>">
                    <input type="hidden" name="nom_tache" value="<?php echo htmlspecialchars($tache['nom']); ?>">
                    <input type="hidden" name="membre_id" value="<?php echo htmlspecialchars($membre['id']); ?>">

                    <textarea 
                        name="texte" 
                        rows="3" 
                        class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-600" 
                        placeholder="Écrivez votre commentaire ici..." 
                        required></textarea>
                    <button 
                        type="submit" 
                        class="bg-violet-600 text-white px-4 py-2 rounded-lg hover:bg-violet-700 transition mt-4">
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
    <?php endforeach; 
    
                } else { ?>
                    <p class="text-center text-gray-500">Aucune tache trouvé.</p>
                <?php } ?>
            </div>
        </div>

            <!-- Notifications Section -->
            <div class="w-1/3 bg-white shadow-lg rounded-lg p-6 h-screen">
            <h2 class="text-lg font-bold text-violet-600 mb-4">Notifications</h2>
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
            <script>
    // Fonction pour ouvrir le modal d'une tâche spécifique
function openModal(idTache) {
    document.getElementById(`modal-${idTache}`).classList.remove('hidden'); // Affiche le modal
}

// Fonction pour fermer le modal d'une tâche spécifique
function closeModal(idTache) {
    document.getElementById(`modal-${idTache}`).classList.add('hidden'); // Cache le modal
}



// Fonction pour ouvrir le modal du statut
function openStatusModal(idTache) {
    document.getElementById(`status-modal-${idTache}`).classList.remove('hidden');
}

// Fonction pour fermer le modal du statut
function closeStatusModal(idTache) {
    document.getElementById(`status-modal-${idTache}`).classList.add('hidden');
}

</script>
</body>
</html>