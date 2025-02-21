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

<body class="bg-gradient-to-br from-gray-100 via-blue-100 to-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white shadow-lg rounded-lg max-w-lg w-full p-6">
        <h2 class="text-2xl font-bold text-center text-blue-900 mb-6">Modifier Projet</h2>

        <form action="process_modif_projet_resp.php" method="POST" class="space-y-6">
            <!-- Nom -->
            <div>
                <label for="nom" class="block text-sm font-medium text-gray-700">Nom</label>
                <textarea id="nom" name="nom" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500"><?php echo htmlspecialchars($current_data['nom']); ?></textarea>
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea id="description" name="description" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500"><?php echo htmlspecialchars($current_data['description']); ?></textarea>
            </div>

            <!-- Date de Début -->
            <div>
                <label for="date_debut" class="block text-sm font-medium text-gray-700">Date de Début</label>
                <input type="date" id="date_debut" name="date_debut"
                    value="<?php echo htmlspecialchars($current_data['date_debut']); ?>" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Date de Fin Prévue -->
            <div>
                <label for="date_fin_prevue" class="block text-sm font-medium text-gray-700">Date de Fin</label>
                <input type="date" id="date_fin_prevue" name="date_fin_prevue"
                    value="<?php echo htmlspecialchars($current_data['date_fin_prevue']); ?>" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Statut -->
            <div>
                <label for="statut" class="block text-sm font-medium text-gray-700">Statut</label>
                <select id="statut" name="statut" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <option value="En_cours" <?php echo $current_data['statut'] == 'En_cours' ? 'selected' : ''; ?>>En cours</option>
                    <option value="Terminé" <?php echo $current_data['statut'] == 'Terminé' ? 'selected' : ''; ?>>Terminé</option>
                    <option value="Annulé" <?php echo $current_data['statut'] == 'Annulé' ? 'selected' : ''; ?>>Annulé</option>
                    <option value="Suspendue" <?php echo $current_data['statut'] == 'Suspendue' ? 'selected' : ''; ?>>Suspendue</option>
                </select>
            </div>

            <!-- ID caché -->
            <input type="hidden" name="id" value="<?= $current_data['id'] ?>">

            <input type="hidden" name="id_resp" value="<?= $current_data['id_resp'] ?>">

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
