<?php
include 'connexion_bd.php';

$projet_id = $_GET['id']; // ID du projet

$sql = "SELECT * FROM projet WHERE id = :id";
$stm = $pdo->prepare($sql);
$stm->bindParam(':id', $projet_id, PDO::PARAM_INT);
$stm->execute();
$current_data = $stm->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Projet</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gradient-to-br from-violet-100 via-blue-100 to-violet-100 flex items-center justify-center">
    <div class="bg-white shadow-2xl rounded-lg p-8 max-w-2xl w-full">
        <h2 class="text-2xl font-bold text-violet-700 text-center mb-6">Modifier Projet</h2>

        <form action="process_modif_projet.php" method="POST" class="space-y-6">
            <!-- Champ Nom -->
            <div>
    <label for="nom" class="block text-sm font-medium text-gray-700">Nom :</label>
    <input type="text" id="nom" name="nom" required
        value="<?php echo htmlspecialchars($current_data['nom']); ?>"
        class="w-full mt-1 p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-violet-500 focus:border-violet-500">
</div>


            <!-- Champ Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Description :</label>
                <textarea id="description" name="description" required
                    class="w-full mt-1 p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-violet-500 focus:border-violet-500"><?php echo htmlspecialchars($current_data['description']); ?></textarea>
            </div>

            <!-- Date de Début -->
            <div>
                <label for="date_debut" class="block text-sm font-medium text-gray-700">Date de Début :</label>
                <input type="date" id="date_debut" name="date_debut"
                    value="<?php echo htmlspecialchars($current_data['date_debut']); ?>" required
                    class="w-full mt-1 p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-violet-500 focus:border-violet-500">
            </div>

            <!-- Date de Fin -->
            <div>
                <label for="date_fin_prevue" class="block text-sm font-medium text-gray-700">Date de Fin :</label>
                <input type="date" id="date_fin_prevue" name="date_fin_prevue"
                    value="<?php echo htmlspecialchars($current_data['date_fin_prevue']); ?>" required
                    class="w-full mt-1 p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-violet-500 focus:border-violet-500">
            </div>

            <!-- Statut -->
            <div>
                <label for="statut" class="block text-sm font-medium text-gray-700">Statut :</label>
                <select id="statut" name="statut" required
                    class="w-full mt-1 p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-violet-500 focus:border-violet-500">
                    <option value="En_cours" <?php echo $current_data['statut'] == 'En_cours' ? 'selected' : ''; ?>>En
                        cours</option>
                    <option value="Terminé" <?php echo $current_data['statut'] == 'Terminé' ? 'selected' : ''; ?>>
                        Terminé</option>
                    <option value="Annulé" <?php echo $current_data['statut'] == 'Annulé' ? 'selected' : ''; ?>>
                        Annulé</option>
                    <option value="Suspendue" <?php echo $current_data['statut'] == 'Suspendue' ? 'selected' : ''; ?>>
                        Suspendue</option>
                </select>
            </div>

            <!-- Responsable -->
            <div>
                <label for="responsables" class="block text-sm font-medium text-gray-700">Responsable :</label>
                <select id="responsables" name="id_resp" required
                    class="w-full mt-1 p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-violet-500 focus:border-violet-500">
                    <?php
                    $sql_responsables = "SELECT id, nom FROM utilisateur WHERE role = 'responsable'";
                    $stm_resp = $pdo->prepare($sql_responsables);
                    $stm_resp->execute();
                    while ($user = $stm_resp->fetch(PDO::FETCH_ASSOC)): ?>
                    <option value="<?= htmlspecialchars($user['id']) ?>"
                        <?php echo $current_data['id_resp'] == $user['id'] ? 'selected' : ''; ?>>
                        <?= htmlspecialchars($user['nom']) ?>
                    </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <!-- ID caché -->
            <input type="hidden" name="id" value="<?= $current_data['id'] ?>">

            <!-- Bouton Enregistrer -->
            <div class="text-center">
                <button type="submit" name="submit"
                    class="w-full px-6 py-3 text-white font-bold rounded-full shadow-xl bg-gradient-to-r from-violet-500 to-blue-500 hover:from-violet-600 hover:to-blue-600 transform hover:scale-105 transition duration-300 ease-in-out focus:outline-none focus:ring-4 focus:ring-violet-300">
                    Enregistrer les modifications
                </button><br><br>
                <!-- Bouton Retour -->
                <a href="projet_admin.php"
                    class="inline-block w-full px-6 py-3 text-white font-bold rounded-full shadow-xl bg-gradient-to-r from-blue-500 to-violet-500 hover:from-blue-600 hover:to-violet-600 transform hover:scale-105 transition duration-300 ease-in-out focus:outline-none focus:ring-4 focus:ring-blue-300">
                    Retour
                </a>
            </div>
        </form>
    </div>
</body>

</html>
