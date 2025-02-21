<?php
include 'connexion_bd.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Responsable</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-violet-100 via-blue-100 to-violet-100 flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-lg p-8 max-w-lg w-full">
        <h1 class="text-2xl font-bold text-violet-700 text-center mb-6">Ajouter un Responsable</h1>
        <form action="process_ajout_resp.php" method="POST" class="space-y-4">
            <div>
                <label for="nom" class="block text-sm font-medium text-gray-700">Nom :</label>
                <input type="text" id="nom" name="nom" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
            </div>
            <div>
                <label for="prenom" class="block text-sm font-medium text-gray-700">Prénom :</label>
                <input type="text" id="prenom" name="prenom" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email :</label>
                <input type="email" id="email" name="email" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
            </div>
            <div>
                <label for="mdp" class="block text-sm font-medium text-gray-700">Mot de passe :</label>
                <input type="password" id="mdp" name="mdp" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
            </div>
            <div>
                <label for="role" class="block text-sm font-medium text-gray-700">Rôle :</label>
                <select id="role" name="role" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                    <option value="responsable">Responsable</option>
                    <option value="membre">Membre d'équipe</option>
                </select>
            </div>
            <div>
                <button type="submit" name="submit"
                    class="w-full px-6 py-3 text-white font-bold rounded-full shadow-xl bg-gradient-to-r from-violet-500 to-blue-500 hover:from-violet-600 hover:to-blue-600 transform hover:scale-105 transition duration-300 ease-in-out focus:outline-none focus:ring-4 focus:ring-violet-300">
                    Ajouter
                </button>
            </div>
        </form>
    </div>
</body>
</html>
