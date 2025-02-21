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

$id = $_SESSION['id_admin'];

// Récupération des données de l'utilisateur
try {
    $sql = "SELECT * FROM utilisateur WHERE id = :id";
    $stm = $pdo->prepare($sql);
    $stm->bindParam(':id', $id, PDO::PARAM_INT);
    $stm->execute();
    $user = $stm->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        header('Location: logout.php'); // Déconnecte si l'utilisateur est introuvable
        exit();
    }
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}

// Déterminer la couleur selon le rôle
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le Profil</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gradient-to-b from-blue-50 via-violet-100 to-blue-50 flex items-center justify-center">
    

<div class="w-full max-w-md bg-white text-gray-800 rounded-lg shadow-lg p-6">
    <h1 class="text-4xl font-extrabold text-center py-4 text-gray-800">
    
    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-500 to-violet-500">
        <?php echo htmlspecialchars($user['nom'] . ' ' . $user['prenom']); ?>
    </span>
</h1>
        
        <form action="process_modif_profil.php" method="POST" class="space-y-4">
        
        
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($user['id']); ?>">
    
        
        <!-- Nom -->
            <div>
                <label for="nom" class="block font-semibold text-gray-700">Nom</label>
                <input type="text" id="nom" name="nom" 
                    value="<?php echo htmlspecialchars($user['nom']); ?>" 
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500" required>
            </div>
            <!-- Prénom -->
            <div>
                <label for="prenom" class="block font-semibold text-gray-700">Prénom</label>
                <input type="text" id="prenom" name="prenom" 
                    value="<?php echo htmlspecialchars($user['prenom']); ?>" 
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500" required>
            </div>
            <!-- Email -->
            <div>
                <label for="email" class="block font-semibold text-gray-700">Email</label>
                <input type="email" id="email" name="email" 
                    value="<?php echo htmlspecialchars($user['email']); ?>" 
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500" required>
            </div>
            <!-- Mot de passe -->
            <div>
                <label for="password" class="block font-semibold text-gray-700">Mot de passe</label>
                <input type="password" id="password" name="mdp" 
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500" >
            </div>

            <div class="text-center space-y-6">
                <!-- Bouton Enregistrer -->
                <button type="submit" name="submit"
                    class="w-full px-6 py-3 text-white font-bold rounded-full shadow-xl bg-gradient-to-r from-violet-500 to-blue-500 hover:from-violet-600 hover:to-blue-600 transform hover:scale-105 transition duration-300 ease-in-out focus:outline-none focus:ring-4 focus:ring-violet-300">
                    Enregistrer
                </button>

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
