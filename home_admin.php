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
$id=$_SESSION['id_admin'];

try {
    // Préparation et exécution de la requête
    $sql = "SELECT * FROM utilisateur WHERE id = :id";
    $stm = $pdo->prepare($sql);
    $stm->bindParam(':id', $id, PDO::PARAM_INT);
    $stm->execute();
    $admin = $stm->fetch(PDO::FETCH_ASSOC); // Récupération des données d'admine

    // Si l'utilisateur n'existe pas, redirection
    if (!$admin) {
        header('Location: logout.php'); // Déconnecte et redirige en cas d'invalidité de l'admine
        exit();
    }
} catch (PDOException $e) {
    // Gestion des erreurs
    die("Erreur : " . $e->getMessage());
}

$sql1 = "SELECT * FROM utilisateur WHERE role != 'Administrateur'";
$stm = $pdo->prepare($sql1);
$stm->execute();
$users = $stm->fetchAll(PDO::FETCH_ASSOC);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Navigation Bar -->
    <nav class="bg-gradient-to-r from-violet-700 to-violet-500 shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="" class="text-yellow-300 font-extrabold text-3xl tracking-wider">M.<?= $admin['nom'].'  '.$admin['prenom'] ?></a>
                </div>
                <!-- Menu -->
                <div class="hidden md:flex space-x-4">
                <a href="profile.php" class="text-yellow-300 hover:bg-violet-600 px-4 py-2 rounded-lg text-lg font-medium">Mon Compte</a>
                    <a href="projet_admin.php" class="text-yellow-300 hover:bg-violet-600 px-4 py-2 rounded-lg text-lg font-medium">Les Projets</a>
                    <a href="tache_admin.php" class="text-yellow-300 hover:bg-violet-600 px-4 py-2 rounded-lg text-lg font-medium">Les Taches</a>
                    <a href="home_admin.php" class="text-yellow-300 hover:bg-violet-600 px-4 py-2 rounded-lg text-lg font-medium">Liste des Employés</a>
                    <a href="logout.php" class="text-yellow-300 hover:bg-violet-600 px-4 py-2 rounded-lg text-lg font-medium">Se Déconnecter</a>
                    
                </div>
            </div>
        </div>
    </nav>

    <!-- Table Section -->
    <div class="max-w-7xl mx-auto py-6 px-4">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <table class="min-w-full bg-white border-collapse">
                <thead class="bg-violet-600 text-yellow-300">
                    <tr>
                        <th class="border-b border-violet-300 px-6 py-4 text-left font-bold">Nom</th>
                        <th class="border-b border-violet-300 px-6 py-4 text-left font-bold">Prénom</th>
                        <th class="border-b border-violet-300 px-6 py-4 text-left font-bold">Email</th>
                        <th class="border-b violet-gray-300 px-6 py-4 text-left font-bold">Rôle</th>
                        <th class="border-b violet-gray-300 px-6 py-4 text-left font-bold">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    <?php if (is_array($users) && count($users) > 0) {
                        foreach($users as $user): ?>
                            <tr class="bg-gray-100 hover:bg-violet-50 transition duration-200">
                                <td class="px-6 py-4 flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-violet-200 rounded-full flex items-center justify-center text-violet-700 font-bold">
                                        <?php echo strtoupper(substr(htmlspecialchars($user['nom']), 0, 1)); ?>
                                    </div>
                                    <span><?php echo htmlspecialchars($user['nom']); ?></span>
                                </td>
                                <td class=" px-6 py-4"><?php echo htmlspecialchars($user['prenom']); ?></td>
                                <td class=" px-6 py-4"><?php echo htmlspecialchars($user['email']); ?></td>
                                <td class=" px-6 py-4">
                                    <span class="bg-violet-100 text-violet-700 px-2 py-1 rounded-full text-xs font-bold">
                                        <?php echo htmlspecialchars($user['role']); ?>
                                    </span>
                                </td>
                                <td class="border-gray-300 px-6 py-4  space-x-2">
                                    <a href="supp_user.php?delet=<?php echo $user['id']; ?>" class="text-red-500 hover:text-red-700 font-bold">Supprimer</a>
                                    <a href="modif_user.php?id=<?php echo $user['id']; ?>" class="text-violet-500 hover:text-blue-700 font-bold">Modifier</a>
                                </td>
                            </tr>
                        <?php endforeach;
                    } else { ?>
                        <tr>
                            <td colspan="5" class="text-center text-gray-500 px-6 py-4">Aucun Responsable trouvé.</td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td colspan="5" class="text-center text-gray-500 px-6 py-4">
                            <a href="ajouter_resp.php" class="text-violet-500 hover:text-blue-700 font-bold">Ajouter</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
