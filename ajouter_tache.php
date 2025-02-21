<?php
include 'connexion_bd.php';

session_start();
$id=$_SESSION['id_resp'];
?>
 

<?php

//selectionnner les membres existent
$sql1 = "SELECT id,nom FROM utilisateur Where role='Membre' ";
$stm = $pdo->prepare($sql1);
$stm->execute();

//selectionner les projets existent : 
$sql1 = "SELECT id,nom FROM projet Where id_resp= ? ";
$sttm = $pdo->prepare($sql1);
$sttm->execute([$id]);


?>



<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une tâche</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-gray-100 via-blue-100 to-gray-100 min-h-screen flex items-center justify-center">

                <div class="bg-white shadow-lg rounded-lg max-w-6xl w-full p-6">
        <h2 class="text-2xl font-bold text-center text-blue-900 mb-6">Ajouter une tâche</h2>
                            <form action="process_ajout_tache.php" method="POST">

        <div class="grid grid-cols-2 gap-6">

            <!-- Partie gauche -->
            <div>
                <label for="nom" class="block text-sm font-medium text-gray-700">Nom</label>
                <input type="text" id="nom" name="nom" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500 mb-4">

                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea id="description" name="description" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500 mb-4"></textarea>

                <label for="date_debut" class="block text-sm font-medium text-gray-700">Date de Début</label>
                <input type="date" id="date_debut" name="date_debut" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500 mb-4">

                <label for="statut" class="block text-sm font-medium text-gray-700">Statut</label>
                <select id="statut" name="statut" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500 mb-4">
                    <option value="A_faire">A faire</option>
                    <option value="En_cours">En cours</option>
                    <option value="Terminé">Terminé</option>
                    <option value="Suspendue">Suspendue</option>
                </select>
            </div>

            <!-- Partie droite -->
            <div>
                <label for="date_fin_prevue" class="block text-sm font-medium text-gray-700">Date de Fin Prévue</label>
                <input type="date" id="date_fin_prevue" name="date_fin_prevue" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500 mb-4">

                <label for="priorite" class="block text-sm font-medium text-gray-700">Priorité</label>
                <select id="priorite" name="priorite" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500 mb-4">
                    <option value="Haute">Haute</option>
                    <option value="Moyenne">Moyenne</option>
                    <option value="Basse">Basse</option>
                </select>

                <label for="projet_owner" class="block text-sm font-medium text-gray-700">Projet de cette tâche</label>
                <select id="projet_owner" name="projet_owner" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500 mb-4">
                    <?php while ($projet_owner = $sttm->fetch(PDO::FETCH_ASSOC)): ?>
                        <option value="<?= htmlspecialchars($projet_owner['id']) ?>"><?= htmlspecialchars($projet_owner['nom']) ?></option>
                    <?php endwhile; ?>
                </select>

                <label for="responsables" class="block text-sm font-medium text-gray-700">Responsable de cette tâche</label>
                <select id="responsables" name="responsables" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500 mb-4">
                    <?php while ($membre = $stm->fetch(PDO::FETCH_ASSOC)): ?>
                        <option value="<?= htmlspecialchars($membre['id']) ?>"><?= htmlspecialchars($membre['nom']) ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
        </div>

        <!-- Bouton Ajouter -->
        <div class="text-center mt-6">
            <button type="submit" name="submit"
                class="w-full bg-gradient-to-br from-blue-900 to-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gradient-to-br hover:from-blue-800 hover:to-gray-500 transform hover:scale-105 transition duration-300 ease-in-out focus:outline-none focus:ring-4 focus:ring-blue-300">
                Ajouter
            </button>

        </div>
                </form>

    </div>
</body>

</html>
