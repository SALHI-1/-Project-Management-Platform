-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 25 juin 2025 à 20:52
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gestion de projet`
--

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

CREATE TABLE `commentaire` (
  `id` int(11) NOT NULL,
  `texte` text NOT NULL,
  `date` datetime DEFAULT current_timestamp(),
  `id_tache` int(11) NOT NULL,
  `id_auteur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `commentaire`
--

INSERT INTO `commentaire` (`id`, `texte`, `date`, `id_tache`, `id_auteur`) VALUES
(20, 'CC', '2025-01-03 19:24:10', 11, 7),
(21, 'salam', '2025-01-03 19:30:09', 11, 7),
(22, 'salam2', '2025-01-03 19:33:33', 11, 4),
(23, 'salam2', '2025-01-03 19:35:27', 11, 7),
(24, 'salam3', '2025-01-03 19:35:58', 11, 4),
(25, 'cc1', '2025-01-03 19:40:26', 11, 4),
(26, 'oki', '2025-01-03 19:44:00', 11, 4),
(27, 'sfy', '2025-01-03 19:48:53', 11, 7),
(28, 'sfy1', '2025-01-04 01:21:30', 11, 4),
(29, 'sf2', '2025-01-04 01:22:28', 11, 7),
(30, 'cc1', '2025-01-04 01:28:07', 11, 7),
(31, 'SALAM', '2025-02-05 15:57:08', 9, 4),
(32, 'Salam:)', '2025-02-05 15:57:44', 9, 7);

-- --------------------------------------------------------

--
-- Structure de la table `notification`
--

CREATE TABLE `notification` (
  `id` int(11) NOT NULL,
  `titre` varchar(100) NOT NULL,
  `texte` text NOT NULL,
  `id_createur` int(11) NOT NULL,
  `id_projet` int(11) DEFAULT NULL,
  `id_tache` int(11) DEFAULT NULL,
  `date_notification` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `notification`
--

INSERT INTO `notification` (`id`, `titre`, `texte`, `id_createur`, `id_projet`, `id_tache`, `date_notification`) VALUES
(3, 'Modification du Projet', 'le responsable Saaymo a modifie le projet BIM', 4, 14, NULL, '2025-01-03 00:50:39'),
(4, 'Modification du Projet', 'l\'admine a modifie le projet Marjane', 1, 15, NULL, '2025-01-03 01:56:00'),
(8, 'Modification du Projet', 'le responsable Saaymo a modifie le projet BIM', 4, 14, NULL, '2025-01-03 16:24:31'),
(10, 'Ajoutation d\'une Tache', 'le responsable Saaymo a ajouté la tache LOGIN', 4, NULL, 9, '2025-01-03 16:42:09'),
(16, 'Ajoutation d\'une Tache', 'le responsable Saaymo a ajouté la tache uigui', 4, NULL, 11, '2025-01-03 17:06:16'),
(17, 'Suppression d\'une Tache', 'le responsable Saaymo a supprimé la tache uigui', 4, NULL, 11, '2025-01-03 17:06:26'),
(30, 'Modification d\'une Tache', 'le membre wa3er a modifie le statut de la tache uigui', 7, NULL, 11, '2025-01-03 18:01:00'),
(35, 'Ajoutation d\'un Commentaire', 'le responsable Saaymo a ajouté un commentaire à la tache uigui', 4, NULL, 11, '2025-01-03 19:44:00'),
(36, 'Ajoutation d\'un Commentaire', 'le Membre wa3er a ajouté un commentaire à la tache ', 7, NULL, 11, '2025-01-03 19:48:53'),
(37, 'Modification d\'une Tache', 'le membre wa3er a modifie le statut de la tache uigui', 7, NULL, 11, '2025-01-03 23:20:24'),
(38, 'Modification d\'une Tache', 'le membre wa3er a modifie le statut de la tache uigui', 7, NULL, 11, '2025-01-03 23:20:42'),
(39, 'Modification d\'une Tache', 'le membre wa3er a modifie le statut de la tache uigui', 7, NULL, 11, '2025-01-03 23:20:48'),
(40, 'Modification du Projet', 'l\'admine a modifie le projet Marjane', 1, 15, NULL, '2025-01-04 01:20:32'),
(41, 'Ajoutation d\'un Commentaire', 'le responsable Saaymo a ajouté un commentaire à la tache uigui', 4, NULL, 11, '2025-01-04 01:21:30'),
(42, 'Ajoutation d\'un Commentaire', 'le Membre wa3er a ajouté un commentaire à la tache ', 7, NULL, 11, '2025-01-04 01:22:28'),
(43, 'Ajoutation d\'un Commentaire', 'le Membre wa3er a ajouté un commentaire à la tache uigui', 7, NULL, 11, '2025-01-04 01:28:07'),
(44, 'Modification d\'une Tache', 'le membre wa3er a modifie le statut de la tache uigui', 7, NULL, 11, '2025-01-04 11:05:34'),
(45, 'Ajoutation d\'un Commentaire', 'le responsable Saaymo a ajouté un commentaire à la tache LOGIN', 4, NULL, 9, '2025-02-05 15:57:08'),
(46, 'Ajoutation d\'un Commentaire', 'le Membre Saad a ajouté un commentaire à la tache LOGIN', 7, NULL, 9, '2025-02-05 15:57:44');

-- --------------------------------------------------------

--
-- Structure de la table `projet`
--

CREATE TABLE `projet` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `date_debut` date NOT NULL,
  `date_fin_prevue` date NOT NULL,
  `statut` enum('En_cours','Terminé','Annulé','Suspendue') NOT NULL,
  `id_resp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `projet`
--

INSERT INTO `projet` (`id`, `nom`, `description`, `date_debut`, `date_fin_prevue`, `statut`, `id_resp`) VALUES
(4, 'yuvyu', 'uuç', '2024-12-23', '2024-12-27', 'Annulé', 4),
(11, 'Oracle', 'ON doit Terminer ce projet en plus vite possible!', '2025-01-02', '2025-01-17', 'En_cours', 4),
(12, 'e-commerce', 'veuillez travailler sur ce projet il est très important', '2025-01-03', '2025-02-01', 'En_cours', 8),
(14, 'BIM', 'Site web e_commerce', '2024-12-13', '2025-01-02', 'Terminé', 4),
(15, 'Marjane', 'un site web e-commerce', '2025-01-02', '2025-01-30', 'Annulé', 4);

-- --------------------------------------------------------

--
-- Structure de la table `tache`
--

CREATE TABLE `tache` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `date_debut` date NOT NULL,
  `date_fin_prevue` date NOT NULL,
  `date_fin_reelle` date DEFAULT NULL,
  `statut` enum('A_faire','En_cours','Terminé','Bloquée') NOT NULL,
  `priorite` enum('Haute','Moyenne','Basse') NOT NULL,
  `id_projet` int(11) NOT NULL,
  `id_affectataire` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `tache`
--

INSERT INTO `tache` (`id`, `nom`, `description`, `date_debut`, `date_fin_prevue`, `date_fin_reelle`, `statut`, `priorite`, `id_projet`, `id_affectataire`) VALUES
(9, 'LOGIN', 'Créer une page LOGIN avec tailwind', '2025-01-10', '2025-01-04', '0000-00-00', 'En_cours', 'Haute', 14, 7),
(11, 'uigui', '_hjpk', '2025-01-10', '2025-01-08', '0000-00-00', 'En_cours', 'Basse', 14, 7);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `email` varchar(150) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `role` enum('Administrateur','Responsable','Membre') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `nom`, `prenom`, `email`, `mdp`, `role`) VALUES
(1, 'SALHII', 'SALHII', 'mohammedsalhi@gmail.com', '$2y$10$c9rtUZb3BPzm/Q1HEA5/DOuo/R1iH007k2r3peprWjwuHWFFJERN6', 'Administrateur'),
(2, 'SAID', 'CHAKIBI', 'simosalhi3@gmail.com', '$2y$10$c9rtUZb3BPzm/Q1HEA5/DOuo/R1iH007k2r3peprWjwuHWFFJERN6', 'Responsable'),
(3, 'QATIB', 'LAILI', 'mohammedsalhi3@gmail.com', '$2y$10$c9rtUZb3BPzm/Q1HEA5/DOuo/R1iH007k2r3peprWjwuHWFFJERN6', 'Membre'),
(4, 'Saaymo', 'kouchi', 'simosalhi2@gmail.com', '$2y$10$c9rtUZb3BPzm/Q1HEA5/DOuo/R1iH007k2r3peprWjwuHWFFJERN6', 'Responsable'),
(6, '9ari', 'ma9arich', 'mohammedsalhi1@gmail.com', '$2y$10$c9rtUZb3BPzm/Q1HEA5/DOuo/R1iH007k2r3peprWjwuHWFFJERN6', 'Membre'),
(7, 'Saad', 'Malini', 'mohammedsalhi2@gmail.com', '$2y$10$c9rtUZb3BPzm/Q1HEA5/DOuo/R1iH007k2r3peprWjwuHWFFJERN6', 'Membre'),
(8, 'KARIM', 'KARIM', 'simosalhi1@gmail.com', '$2y$10$c9rtUZb3BPzm/Q1HEA5/DOuo/R1iH007k2r3peprWjwuHWFFJERN6', 'Responsable');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_tache` (`id_tache`),
  ADD KEY `id_auteur` (`id_auteur`);

--
-- Index pour la table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_createur` (`id_createur`),
  ADD KEY `id_projet` (`id_projet`),
  ADD KEY `notification_ibfk_3` (`id_tache`);

--
-- Index pour la table `projet`
--
ALTER TABLE `projet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_responsable` (`id_resp`);

--
-- Index pour la table `tache`
--
ALTER TABLE `tache`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_projet` (`id_projet`),
  ADD KEY `id_affectataire` (`id_affectataire`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `email_2` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `commentaire`
--
ALTER TABLE `commentaire`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT pour la table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT pour la table `projet`
--
ALTER TABLE `projet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `tache`
--
ALTER TABLE `tache`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD CONSTRAINT `commentaire_ibfk_1` FOREIGN KEY (`id_tache`) REFERENCES `tache` (`id`),
  ADD CONSTRAINT `commentaire_ibfk_2` FOREIGN KEY (`id_auteur`) REFERENCES `utilisateur` (`id`);

--
-- Contraintes pour la table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `notification_ibfk_1` FOREIGN KEY (`id_createur`) REFERENCES `utilisateur` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notification_ibfk_2` FOREIGN KEY (`id_projet`) REFERENCES `projet` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notification_ibfk_3` FOREIGN KEY (`id_tache`) REFERENCES `tache` (`id`) ON DELETE NO ACTION;

--
-- Contraintes pour la table `projet`
--
ALTER TABLE `projet`
  ADD CONSTRAINT `projet_ibfk_1` FOREIGN KEY (`id_resp`) REFERENCES `utilisateur` (`id`);

--
-- Contraintes pour la table `tache`
--
ALTER TABLE `tache`
  ADD CONSTRAINT `tache_ibfk_1` FOREIGN KEY (`id_projet`) REFERENCES `projet` (`id`),
  ADD CONSTRAINT `tache_ibfk_2` FOREIGN KEY (`id_affectataire`) REFERENCES `utilisateur` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
