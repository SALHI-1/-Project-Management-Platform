<?php
include 'connexion_bd.php';
?>

<?php
$sql1 = "SELECT id,nom FROM utilisateur WHERE role = 'Responsable'";
$stm = $pdo->prepare($sql1);
$stm->execute();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Projet</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gradient-to-br from-violet-100 via-blue-100 to-violet-100 flex items-center justify-center">
    <div class="bg-white shadow-2xl rounded-lg p-8 max-w-2xl w-full">
        <h2 class="text-2xl font-bold text-violet-700 text-center mb-6">Ajouter un Projet</h2>

        <form action="process_ajout_proj.php" method="POST" class="space-y-6">
            <!-- Champ Nom -->
            <div>
                <label for="nom" class="block text-sm font-medium text-gray-700">Nom :</label>
                <input type="text" id="nom" name="nom" required
                    class="w-full mt-1 p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-violet-500 focus:border-violet-500">
            </div>

            <!-- Champ Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Description :</label>
                <textarea id="description" name="description" required
                    class="w-full mt-1 p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-violet-500 focus:border-violet-500"></textarea>
            </div>

            <!-- Date de Début -->
            <div>
                <label for="date_debut" class="block text-sm font-medium text-gray-700">Date de Début :</label>
                <input type="date" id="date_debut" name="date_debut" required
                    class="w-full mt-1 p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-violet-500 focus:border-violet-500">
            </div>

            <!-- Date de Fin -->
            <div>
                <label for="date_fin" class="block text-sm font-medium text-gray-700">Date de Fin :</label>
                <input type="date" id="date_fin" name="date_fin" required
                    class="w-full mt-1 p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-violet-500 focus:border-violet-500">
            </div>

            <!-- Statut -->
            <div>
                <label for="statut" class="block text-sm font-medium text-gray-700">Statut :</label>
                <select id="statut" name="statut" required
                    class="w-full mt-1 p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-violet-500 focus:border-violet-500">
                    <option value="En_cours">En cours</option>
                    <option value="Terminé">Terminé</option>
                    <option value="Annulé">Annulé</option>
                    <option value="Suspendue">Suspendue</option>
                </select>
            </div>

            <!-- Responsable -->
            <div>
                <label for="responsables" class="block text-sm font-medium text-gray-700">Responsables :</label>
                <select id="responsables" name="responsables" required
                    class="w-full mt-1 p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-violet-500 focus:border-violet-500">
                    <?php
                    $sql_responsables = "SELECT id, nom FROM utilisateur WHERE role = 'responsable'";
                    $stm_resp = $pdo->prepare($sql_responsables);
                    $stm_resp->execute();
                    while ($user = $stm_resp->fetch(PDO::FETCH_ASSOC)): ?>
                        <option value="<?= htmlspecialchars($user['id']) ?>"><?= htmlspecialchars($user['nom']) ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <!-- Bouton Ajouter -->
            <div class="text-center">
                <button type="submit" name="submit"
                    class="w-full px-6 py-3 text-white font-bold rounded-full shadow-xl bg-gradient-to-r from-violet-500 to-blue-500 hover:from-violet-600 hover:to-blue-600 transform hover:scale-105 transition duration-300 ease-in-out focus:outline-none focus:ring-4 focus:ring-violet-300">
                    Ajouter
                </button>
            </div>
        </form>
    </div>
</body>

</html>
