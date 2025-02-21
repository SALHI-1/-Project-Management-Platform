<?php
include 'connexion_bd.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération et nettoyage des entrées utilisateur
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));

    try {
        // Préparer la requête pour récupérer l'utilisateur par email
        $sql = "SELECT * FROM utilisateur WHERE email = ?";
        $stm = $pdo->prepare($sql);
        $stm->execute([$email]);

        // Récupération des données de l'utilisateur
        $user = $stm->fetch(PDO::FETCH_ASSOC);

        // Vérification si l'utilisateur existe
        if ($user && password_verify($password, $user['mdp'])) {
            // Initialisation de la session en fonction du rôle
            if ($user['role'] === 'Administrateur') {
                $_SESSION['id_admin'] = $user['id'];
                header('Location: home_admin.php');
                exit;
            } elseif ($user['role'] === 'Responsable') {
                $_SESSION['id_resp'] = $user['id'];
                $_SESSION['nom_resp'] = $user['nom'];

                header('Location: home_resp.php');
                exit;
            } else {
                $_SESSION['id_membre'] = $user['id'];
                $_SESSION['nom_membre'] = $user['nom'];

                header('Location: home_membre.php');
                exit;
            }
        } else {
            // En cas d'erreur de connexion
            echo "Email ou mot de passe incorrect.";
        }
    } catch (PDOException $e) {
        // Gestion des erreurs PDO
        echo "Erreur : " . $e->getMessage();
    }
}
?>
