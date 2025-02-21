<?php
//j'ai importé ça du fichier modif_projet j'ai pas encore modifier

include 'connexion_bd.php';

$tache_id = $_GET['id']; // ID du tach
//Slecter la rache spécifier : 
    $sql1 = "SELECT 
    tache.*,
    projet.nom AS nom_projet,
    utilisateur.nom AS nom_responsable_tache,
    projet.id_resp
FROM 
    tache
JOIN 
    projet ON tache.id_projet = projet.id
JOIN 
    utilisateur ON tache.id_affectataire = utilisateur.id
WHERE 
    tache.id = ? ";

$stm = $pdo->prepare($sql1);
$stm->execute([$tache_id]); 
$tache = $stm->fetch(PDO::FETCH_ASSOC);

//selectionner les membres existent : 
$sql1 = "SELECT id,nom FROM utilisateur Where role='Membre' ";
$stttm = $pdo->prepare($sql1);
$stttm->execute();

//selecter les projet existent
$sql1 = "SELECT id,nom FROM projet  ";
$sttm = $pdo->prepare($sql1);
$sttm->execute();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier tâche</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-gray-100 via-blue-100 to-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white shadow-lg rounded-lg max-w-6xl w-full p-6">
        <h2 class="text-2xl font-bold text-center text-blue-900 mb-6">Modifier tâche</h2>

        <form action="process_modif_tache.php" method="POST" class="space-y-6">
            <div class="grid grid-cols-2 gap-6">
                <!-- Partie gauche -->
                <div>
                    <label for="nom" class="block text-sm font-medium text-gray-700">Nom</label>
                    <textarea id="nom" name="nom" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500"><?php echo htmlspecialchars($tache['nom']); ?></textarea>

                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea id="description" name="description" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500"><?php echo htmlspecialchars($tache['description']); ?></textarea>

                    <label for="date_debut" class="block text-sm font-medium text-gray-700">Date de Début</label>
                    <input type="date" id="date_debut" name="date_debut"
                        value="<?php echo htmlspecialchars($tache['date_debut']); ?>" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                
                        <label for="date_fin_prevue" class="block text-sm font-medium text-gray-700">Date de Fin Prévue</label>
                    <input type="date" id="date_fin_prevue" name="date_fin_prevue"
                        value="<?php echo htmlspecialchars($tache['date_fin_prevue']); ?>" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500">

                        

                    </div>

                <!-- Partie droite -->
                <div>
                <label for="date_fin_prevue" class="block text-sm font-medium text-gray-700">Date de Fin Réelle</label>
                    <input type="date" id="date_fin_prevue" name="date_fin_reelle"
                        value="<?php echo htmlspecialchars($tache['date_fin_reelle']); ?>" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        
                    <label for="statut" class="block text-sm font-medium text-gray-700">Statut</label>
                    <select id="statut" name="statut" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="A_faire" <?php echo $tache['statut'] == 'A_faire' ? 'selected' : ''; ?>>A faire</option>
                        <option value="En_cours" <?php echo $tache['statut'] == 'En_cours' ? 'selected' : ''; ?>>En cours</option>
                        <option value="Terminé" <?php echo $tache['statut'] == 'Terminé' ? 'selected' : ''; ?>>Terminé</option>
                        <option value="Bloquée" <?php echo $tache['statut'] == 'Bloquée' ? 'selected' : ''; ?>>Bloquée</option>
                    </select>

                    <label for="priorite" class="block text-sm font-medium text-gray-700">Priorité</label>
                    <select id="priorite" name="priorite" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="Haute" <?php echo $tache['priorite'] == 'Haute' ? 'selected' : ''; ?>>Haute</option>
                        <option value="Moyenne" <?php echo $tache['priorite'] == 'Moyenne' ? 'selected' : ''; ?>>Moyenne</option>
                        <option value="Basse" <?php echo $tache['priorite'] == 'Basse' ? 'selected' : ''; ?>>Basse</option>
                    </select>

                    <label for="dep_projet" class="block text-sm font-medium text-gray-700">Déplacer la tâche à un autre projet</label>
                    <select id="dep_projet" name="dep_projet" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <?php while ($projets = $sttm->fetch(PDO::FETCH_ASSOC)): ?>
                            <option value="<?= htmlspecialchars($projets['id']) ?>" 
                                <?= $projets['nom'] === $tache['nom_projet'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($projets['nom']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>

                    <label for="responsables" class="block text-sm font-medium text-gray-700">Responsable</label>
                    <select id="responsables" name="id_resp" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <?php while ($user = $stttm->fetch(PDO::FETCH_ASSOC)): ?>
                            <option value="<?= htmlspecialchars($user['id']) ?>" 
                                <?= ($tache['nom_responsable_tache'] == $user['nom']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($user['nom']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
            </div>

            <!-- ID caché -->
            <input type="hidden" name="id" value="<?= $tache['id'] ?>">

            <!-- Bouton Enregistrer -->
            <div class="text-center">
                <button type="submit" name="submit"
                    class="w-full bg-gradient-to-br from-blue-900 to-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gradient-to-br hover:from-blue-800 hover:to-gray-500 transform hover:scale-105 transition duration-300 ease-in-out focus:outline-none focus:ring-4 focus:ring-blue-300">
                    Enregistrer les modifications
                </button>
            </div>
        </form>
    </div>
</body>

</html>
