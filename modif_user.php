<?php
include 'connexion_bd.php';

$user_id = $_GET['id'];


$sql = "SELECT * FROM utilisateur WHERE id = :id";
$stm = $pdo->prepare($sql);
$stm->bindParam(':id', $user_id, PDO::PARAM_INT);
$stm->execute();
$current_data = $stm->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier utilisateur</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-violet-100 via-blue-100 to-violet-100 min-h-screen flex items-center justify-center">
    <div class="bg-white shadow-lg rounded-lg max-w-lg w-full p-6">
        <h2 class="text-2xl font-bold text-center text-violet-700 mb-6">Modifier utilisateur</h2>

        <form action="process_modif.php" method="POST" class="space-y-6">
            <!-- Nom -->
            <div>
                <label for="nom" class="block text-sm font-medium text-gray-700">Nom</label>
                <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($current_data['nom']); ?>" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-violet-500 focus:border-violet-500">
            </div>

            <!-- Prénom -->
            <div>
                <label for="prenom" class="block text-sm font-medium text-gray-700">Prénom</label>
                <input type="text" id="prenom" name="prenom" value="<?php echo htmlspecialchars($current_data['prenom']); ?>"
                    required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-violet-500 focus:border-violet-500">
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($current_data['email']); ?>"
                    required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-violet-500 focus:border-violet-500">
            </div>

            <!-- Mot de passe -->
            <div>
                <label for="mdp" class="block text-sm font-medium text-gray-700">PASSWORD</label>
                <input type="password" id="mdp" name="mdp"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-violet-500 focus:border-violet-500">
            </div>

            <!-- Rôle -->
            <div>
                <label for="role" class="block text-sm font-medium text-gray-700">Rôle</label>
                <select id="role" name="role" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-violet-500 focus:border-violet-500">
                    <option value="responsable" <?php echo $current_data['role'] == 'Responsable' ? 'selected' : ''; ?>>
                        Responsable</option>
                    <option value="membre" <?php echo $current_data['role'] == 'Membre' ? 'selected' : ''; ?>>Membre</option>
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
                <a href="home_admin.php"
                    class="inline-block w-full px-6 py-3 text-white font-bold rounded-full shadow-xl bg-gradient-to-r from-blue-500 to-violet-500 hover:from-blue-600 hover:to-violet-600 transform hover:scale-105 transition duration-300 ease-in-out focus:outline-none focus:ring-4 focus:ring-blue-300">
                    Retour
                </a>
            </div>
        </form>
    </div>
</body>

</html>
