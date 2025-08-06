-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 06 août 2025 à 13:27
-- Version du serveur : 10.11.10-MariaDB
-- Version de PHP : 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `u316670446_hunterrpg`
--

-- --------------------------------------------------------

--
-- Structure de la table `artefacts`
--

CREATE TABLE `artefacts` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `effet` text NOT NULL,
  `rarete` enum('commun','rare','epique','legendaire') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `captures`
--

CREATE TABLE `captures` (
  `id` int(11) NOT NULL,
  `joueur_id` int(11) NOT NULL,
  `creature_id` int(11) NOT NULL,
  `statut_id` int(11) NOT NULL,
  `niveau` int(11) NOT NULL,
  `nom_personnalise` varchar(50) DEFAULT NULL,
  `date_capture` datetime DEFAULT current_timestamp(),
  `enclos_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `creatures`
--

CREATE TABLE `creatures` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `rarete` enum('commun','peu_commun','rare','epique','legendaire') NOT NULL,
  `niveau_max` int(11) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `creatures`
--

INSERT INTO `creatures` (`id`, `nom`, `rarete`, `niveau_max`, `description`) VALUES
(1, 'Gobelin', 'commun', 20, 'Petit monstre agressif vivant en groupe.'),
(2, 'Loup', 'peu_commun', 25, 'Prédateur rapide et féroce.'),
(3, 'Griffon', 'rare', 40, 'Créature majestueuse mi-lion mi-aigle.'),
(4, 'Dragon', 'epique', 60, 'Bête légendaire crachant du feu.'),
(5, 'Phénix', 'legendaire', 70, 'Oiseau mythique renaissant de ses cendres.');

-- --------------------------------------------------------

--
-- Structure de la table `enchères`
--

CREATE TABLE `enchères` (
  `id` int(11) NOT NULL,
  `creature_id` int(11) NOT NULL,
  `vendeur_id` int(11) NOT NULL,
  `prix_depart` int(11) NOT NULL,
  `date_debut` datetime DEFAULT current_timestamp(),
  `date_fin` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `enclos`
--

CREATE TABLE `enclos` (
  `id` int(11) NOT NULL,
  `joueur_id` int(11) NOT NULL,
  `nom` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `guildes`
--

CREATE TABLE `guildes` (
  `id` int(11) NOT NULL,
  `rang` varchar(10) NOT NULL,
  `exp_requise` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `guildes`
--

INSERT INTO `guildes` (`id`, `rang`, `exp_requise`) VALUES
(1, 'F', 0),
(2, 'E', 100),
(3, 'D', 250),
(4, 'C', 500),
(5, 'B', 1000),
(6, 'A', 2000),
(7, 'S', 5000),
(8, 'SS', 10000),
(9, 'SSS', 20000),
(10, 'Ex', 50000);

-- --------------------------------------------------------

--
-- Structure de la table `inventaire_ressources`
--

CREATE TABLE `inventaire_ressources` (
  `id` int(11) NOT NULL,
  `joueur_id` int(11) NOT NULL,
  `ressource_id` int(11) NOT NULL,
  `quantite` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `joueurs`
--

CREATE TABLE `joueurs` (
  `id` int(11) NOT NULL,
  `pseudo` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `niveau` int(11) DEFAULT 1,
  `rang_guilde_id` int(11) DEFAULT NULL,
  `exp_guilde` int(11) DEFAULT 0,
  `ors` int(11) DEFAULT 0,
  `date_inscription` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `loot_ressources`
--

CREATE TABLE `loot_ressources` (
  `id` int(11) NOT NULL,
  `creature_id` int(11) NOT NULL,
  `ressource_id` int(11) NOT NULL,
  `probabilite` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `loot_ressources`
--

INSERT INTO `loot_ressources` (`id`, `creature_id`, `ressource_id`, `probabilite`) VALUES
(1, 1, 1, 0.7),
(2, 2, 2, 0.6),
(3, 3, 3, 0.4),
(4, 4, 4, 0.6),
(5, 4, 6, 0.01),
(6, 5, 5, 0.3);

-- --------------------------------------------------------

--
-- Structure de la table `recettes`
--

CREATE TABLE `recettes` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `recettes`
--

INSERT INTO `recettes` (`id`, `nom`, `description`) VALUES
(1, 'Épée du Loup', 'Arme légère fabriquée avec des griffes de loup.'),
(2, 'Armure draconique', 'Armure lourde fabriquée avec des écailles de dragon.'),
(3, 'Potion de renaissance', 'Potion rare fabriquée avec de la cendre de phénix.');

-- --------------------------------------------------------

--
-- Structure de la table `recette_ressources`
--

CREATE TABLE `recette_ressources` (
  `id` int(11) NOT NULL,
  `recette_id` int(11) NOT NULL,
  `ressource_id` int(11) NOT NULL,
  `quantite` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `recette_ressources`
--

INSERT INTO `recette_ressources` (`id`, `recette_id`, `ressource_id`, `quantite`) VALUES
(1, 1, 2, 5),
(2, 2, 4, 10),
(3, 3, 5, 3);

-- --------------------------------------------------------

--
-- Structure de la table `reproductions`
--

CREATE TABLE `reproductions` (
  `id` int(11) NOT NULL,
  `creature_parent1` int(11) NOT NULL,
  `creature_parent2` int(11) NOT NULL,
  `oeuf_statut_id` int(11) NOT NULL,
  `date_reproduction` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `ressources`
--

CREATE TABLE `ressources` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `ressources`
--

INSERT INTO `ressources` (`id`, `nom`, `description`) VALUES
(1, 'Peau de gobelin', 'Matériau de base pour artisanat.'),
(2, 'Griffe de loup', 'Utilisée pour fabriquer des armes légères.'),
(3, 'Plume de griffon', 'Ressource rare utilisée pour des objets magiques.'),
(4, 'Écaille de dragon', 'Matériau solide pour armures puissantes.'),
(5, 'Cendre de phénix', 'Ingrédient mythique pour des potions de résurrection.'),
(6, 'Œuf de dragon', 'Peut éclore pour obtenir un bébé dragon.');

-- --------------------------------------------------------

--
-- Structure de la table `statuts_creatures`
--

CREATE TABLE `statuts_creatures` (
  `id` int(11) NOT NULL,
  `nom` varchar(20) NOT NULL,
  `multiplicateur_stats` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `statuts_creatures`
--

INSERT INTO `statuts_creatures` (`id`, `nom`, `multiplicateur_stats`) VALUES
(1, 'Normal', 1),
(2, 'Élite', 1.2),
(3, 'Alpha', 1.5),
(4, 'Boss', 2);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `artefacts`
--
ALTER TABLE `artefacts`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `captures`
--
ALTER TABLE `captures`
  ADD PRIMARY KEY (`id`),
  ADD KEY `joueur_id` (`joueur_id`),
  ADD KEY `creature_id` (`creature_id`),
  ADD KEY `statut_id` (`statut_id`),
  ADD KEY `enclos_id` (`enclos_id`);

--
-- Index pour la table `creatures`
--
ALTER TABLE `creatures`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `enchères`
--
ALTER TABLE `enchères`
  ADD PRIMARY KEY (`id`),
  ADD KEY `creature_id` (`creature_id`),
  ADD KEY `vendeur_id` (`vendeur_id`);

--
-- Index pour la table `enclos`
--
ALTER TABLE `enclos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `joueur_id` (`joueur_id`);

--
-- Index pour la table `guildes`
--
ALTER TABLE `guildes`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `inventaire_ressources`
--
ALTER TABLE `inventaire_ressources`
  ADD PRIMARY KEY (`id`),
  ADD KEY `joueur_id` (`joueur_id`),
  ADD KEY `ressource_id` (`ressource_id`);

--
-- Index pour la table `joueurs`
--
ALTER TABLE `joueurs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `rang_guilde_id` (`rang_guilde_id`);

--
-- Index pour la table `loot_ressources`
--
ALTER TABLE `loot_ressources`
  ADD PRIMARY KEY (`id`),
  ADD KEY `creature_id` (`creature_id`),
  ADD KEY `ressource_id` (`ressource_id`);

--
-- Index pour la table `recettes`
--
ALTER TABLE `recettes`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `recette_ressources`
--
ALTER TABLE `recette_ressources`
  ADD PRIMARY KEY (`id`),
  ADD KEY `recette_id` (`recette_id`),
  ADD KEY `ressource_id` (`ressource_id`);

--
-- Index pour la table `reproductions`
--
ALTER TABLE `reproductions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `creature_parent1` (`creature_parent1`),
  ADD KEY `creature_parent2` (`creature_parent2`),
  ADD KEY `oeuf_statut_id` (`oeuf_statut_id`);

--
-- Index pour la table `ressources`
--
ALTER TABLE `ressources`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `statuts_creatures`
--
ALTER TABLE `statuts_creatures`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `artefacts`
--
ALTER TABLE `artefacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `captures`
--
ALTER TABLE `captures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `creatures`
--
ALTER TABLE `creatures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `enchères`
--
ALTER TABLE `enchères`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `enclos`
--
ALTER TABLE `enclos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `guildes`
--
ALTER TABLE `guildes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `inventaire_ressources`
--
ALTER TABLE `inventaire_ressources`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `joueurs`
--
ALTER TABLE `joueurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `loot_ressources`
--
ALTER TABLE `loot_ressources`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `recettes`
--
ALTER TABLE `recettes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `recette_ressources`
--
ALTER TABLE `recette_ressources`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `reproductions`
--
ALTER TABLE `reproductions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `ressources`
--
ALTER TABLE `ressources`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `statuts_creatures`
--
ALTER TABLE `statuts_creatures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `captures`
--
ALTER TABLE `captures`
  ADD CONSTRAINT `captures_ibfk_1` FOREIGN KEY (`joueur_id`) REFERENCES `joueurs` (`id`),
  ADD CONSTRAINT `captures_ibfk_2` FOREIGN KEY (`creature_id`) REFERENCES `creatures` (`id`),
  ADD CONSTRAINT `captures_ibfk_3` FOREIGN KEY (`statut_id`) REFERENCES `statuts_creatures` (`id`),
  ADD CONSTRAINT `captures_ibfk_4` FOREIGN KEY (`enclos_id`) REFERENCES `enclos` (`id`);

--
-- Contraintes pour la table `enchères`
--
ALTER TABLE `enchères`
  ADD CONSTRAINT `enchères_ibfk_1` FOREIGN KEY (`creature_id`) REFERENCES `captures` (`id`),
  ADD CONSTRAINT `enchères_ibfk_2` FOREIGN KEY (`vendeur_id`) REFERENCES `joueurs` (`id`);

--
-- Contraintes pour la table `enclos`
--
ALTER TABLE `enclos`
  ADD CONSTRAINT `enclos_ibfk_1` FOREIGN KEY (`joueur_id`) REFERENCES `joueurs` (`id`);

--
-- Contraintes pour la table `inventaire_ressources`
--
ALTER TABLE `inventaire_ressources`
  ADD CONSTRAINT `inventaire_ressources_ibfk_1` FOREIGN KEY (`joueur_id`) REFERENCES `joueurs` (`id`),
  ADD CONSTRAINT `inventaire_ressources_ibfk_2` FOREIGN KEY (`ressource_id`) REFERENCES `ressources` (`id`);

--
-- Contraintes pour la table `joueurs`
--
ALTER TABLE `joueurs`
  ADD CONSTRAINT `joueurs_ibfk_1` FOREIGN KEY (`rang_guilde_id`) REFERENCES `guildes` (`id`);

--
-- Contraintes pour la table `loot_ressources`
--
ALTER TABLE `loot_ressources`
  ADD CONSTRAINT `loot_ressources_ibfk_1` FOREIGN KEY (`creature_id`) REFERENCES `creatures` (`id`),
  ADD CONSTRAINT `loot_ressources_ibfk_2` FOREIGN KEY (`ressource_id`) REFERENCES `ressources` (`id`);

--
-- Contraintes pour la table `recette_ressources`
--
ALTER TABLE `recette_ressources`
  ADD CONSTRAINT `recette_ressources_ibfk_1` FOREIGN KEY (`recette_id`) REFERENCES `recettes` (`id`),
  ADD CONSTRAINT `recette_ressources_ibfk_2` FOREIGN KEY (`ressource_id`) REFERENCES `ressources` (`id`);

--
-- Contraintes pour la table `reproductions`
--
ALTER TABLE `reproductions`
  ADD CONSTRAINT `reproductions_ibfk_1` FOREIGN KEY (`creature_parent1`) REFERENCES `captures` (`id`),
  ADD CONSTRAINT `reproductions_ibfk_2` FOREIGN KEY (`creature_parent2`) REFERENCES `captures` (`id`),
  ADD CONSTRAINT `reproductions_ibfk_3` FOREIGN KEY (`oeuf_statut_id`) REFERENCES `statuts_creatures` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
