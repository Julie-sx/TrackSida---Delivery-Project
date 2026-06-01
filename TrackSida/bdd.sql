-- phpMyAdmin SQL Dumpsysmonsterpadeltracksida
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Hôte : rdqicartracksida.mysql.db
-- Généré le : dim. 31 mai 2026 à 18:41
-- Version du serveur : 8.4.8-8
-- Version de PHP : 8.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `rdqicartracksida`
--
CREATE DATABASE IF NOT EXISTS `tracksida` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `tracksida`;

-- --------------------------------------------------------

--
-- Structure de la table `blogs`
--

CREATE TABLE `blogs` (
  `id_blog` int NOT NULL,
  `blog_name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `blog_url` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `blogs`
--

INSERT INTO `blogs` (`id_blog`, `blog_name`, `description`, `blog_url`, `date`) VALUES
(1, 'La Chasse Aux IST', '', 'LaChasseAuxIST/', '2026-05-28 12:01:56');

-- --------------------------------------------------------

--
-- Structure de la table `declarations_ist`
--

CREATE TABLE `declarations_ist` (
  `id_declaration` int UNSIGNED NOT NULL,
  `id_utilisateur` int UNSIGNED NOT NULL,
  `id_ist` int UNSIGNED NOT NULL,
  `date_diagnostic` date DEFAULT NULL,
  `commentaire` text,
  `date_declaration` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `ist`
--

CREATE TABLE `ist` (
  `id_ist` int UNSIGNED NOT NULL,
  `nom` varchar(100) NOT NULL,
  `description` text,
  `symptomes` text,
  `transmission` text,
  `traitement` text,
  `prevention` text,
  `est_publie` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `logs_activite`
--

CREATE TABLE `logs_activite` (
  `id_log` int UNSIGNED NOT NULL,
  `id_utilisateur` int UNSIGNED DEFAULT NULL,
  `action` varchar(100) NOT NULL,
  `details` json DEFAULT NULL,
  `ip` varchar(45) DEFAULT NULL,
  `date_action` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `messages_notification`
--

CREATE TABLE `messages_notification` (
  `id_message` int UNSIGNED NOT NULL,
  `id_notification` int UNSIGNED NOT NULL,
  `sujet` varchar(255) DEFAULT NULL,
  `corps` text NOT NULL,
  `langue` varchar(10) NOT NULL DEFAULT 'fr'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `notifications_anonymes`
--

CREATE TABLE `notifications_anonymes` (
  `id_notification` int UNSIGNED NOT NULL,
  `id_declaration` int UNSIGNED NOT NULL,
  `id_partenaire` int UNSIGNED NOT NULL,
  `canal` enum('email','sms','lien') NOT NULL DEFAULT 'email',
  `statut` enum('en_attente','envoyee','echec','lue') NOT NULL DEFAULT 'en_attente',
  `token_unique` varchar(255) NOT NULL,
  `date_envoi` datetime DEFAULT NULL,
  `date_lecture` datetime DEFAULT NULL,
  `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `partenaires`
--

CREATE TABLE `partenaires` (
  `id_partenaire` int UNSIGNED NOT NULL,
  `id_utilisateur` int UNSIGNED NOT NULL,
  `surnom` varchar(100) DEFAULT NULL,
  `email_partenaire` varchar(150) DEFAULT NULL,
  `telephone` varchar(30) DEFAULT NULL,
  `date_contact` date DEFAULT NULL,
  `notes` text,
  `date_ajout` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `partenaires`
--

INSERT INTO `partenaires` (`id_partenaire`, `id_utilisateur`, `surnom`, `email_partenaire`, `telephone`, `date_contact`, `notes`, `date_ajout`) VALUES
(1, 1, 'Melvin', 'mel@email.com', NULL, NULL, 'homme de ma vie', '2026-05-21 05:24:47'),
(2, 1, 'Melvin', 'mel@email.com', NULL, NULL, 'homme de ma vie', '2026-05-21 05:24:48'),
(3, 1, 'Melvin', 'mel@email.com', NULL, NULL, 'homme de ma vie', '2026-05-21 05:24:49');

-- --------------------------------------------------------

--
-- Structure de la table `tags`
--

CREATE TABLE `tags` (
  `id_tag` int NOT NULL,
  `tag_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `tags`
--

INSERT INTO `tags` (`id_tag`, `tag_name`) VALUES
(1, 'Prévention'),
(2, 'Dépistage'),
(3, 'Essais cliniques'),
(4, 'Épidémiologie'),
(5, 'Traitements'),
(6, 'Vaccination'),
(7, 'PrEP'),
(8, 'Contraception'),
(9, 'Symptômes'),
(10, 'Infections Virales'),
(11, 'Infections Bactériennes');

-- --------------------------------------------------------

--
-- Structure de la table `tags_list`
--

CREATE TABLE `tags_list` (
  `id_blog` int NOT NULL,
  `id_tag` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `tags_list`
--

INSERT INTO `tags_list` (`id_blog`, `id_tag`) VALUES
(1, 1),
(1, 2);

-- --------------------------------------------------------

--
-- Structure de la table `tokens_session`
--

CREATE TABLE `tokens_session` (
  `id_token` int UNSIGNED NOT NULL,
  `id_utilisateur` int UNSIGNED NOT NULL,
  `token` varchar(512) NOT NULL,
  `ip_creation` varchar(45) DEFAULT NULL,
  `user_agent` varchar(512) DEFAULT NULL,
  `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_expiration` datetime NOT NULL,
  `est_revoque` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id_utilisateur` int UNSIGNED NOT NULL,
  `pseudo` varchar(50) NOT NULL,
  `email` varchar(150) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `date_naissance` date DEFAULT NULL,
  `genre` enum('homme','femme','non_binaire','autre','non_renseigne') NOT NULL DEFAULT 'non_renseigne',
  `date_inscription` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `derniere_connexion` datetime DEFAULT NULL,
  `est_actif` tinyint(1) NOT NULL DEFAULT '1',
  `token_email` varchar(255) DEFAULT NULL,
  `email_verifie` tinyint(1) NOT NULL DEFAULT '0',
  `niveau` int NOT NULL DEFAULT '0',
  `image` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id_utilisateur`, `pseudo`, `email`, `mot_de_passe`, `date_naissance`, `genre`, `date_inscription`, `derniere_connexion`, `est_actif`, `token_email`, `email_verifie`, `niveau`, `image`) VALUES
(1, 'Elliot Langermann', 'elliot.langermann@efrei.net', '56624cf37b6ef8911d5cb2c16353ad36', '2007-01-01', 'homme', '2026-05-07 14:49:30', NULL, 1, NULL, 1, 10, NULL),
(2, 'Arthur Morineau', 'a.m@arth.fr', 'ee2d445b04f212f75bbd1e32bcb8d81a8636b4699d1ce502306e6ef1c4538545', NULL, 'homme', '2026-05-28 06:11:20', NULL, 1, NULL, 0, 10, NULL),
(3, 'Melvin CHAIGNEAU', 'Chaigneau75@yahoo.com', '959caa8afa6ff1e8de1e9b246dafb50b3306955c64810fb928fb74433f35bf3d', NULL, '', '2026-05-28 13:05:38', NULL, 1, NULL, 0, 0, NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id_blog`);

--
-- Index pour la table `declarations_ist`
--
ALTER TABLE `declarations_ist`
  ADD PRIMARY KEY (`id_declaration`),
  ADD KEY `fk_decl_ist` (`id_ist`),
  ADD KEY `idx_decl_user` (`id_utilisateur`);

--
-- Index pour la table `ist`
--
ALTER TABLE `ist`
  ADD PRIMARY KEY (`id_ist`),
  ADD UNIQUE KEY `nom` (`nom`);

--
-- Index pour la table `logs_activite`
--
ALTER TABLE `logs_activite`
  ADD PRIMARY KEY (`id_log`),
  ADD KEY `fk_log_utilisateur` (`id_utilisateur`),
  ADD KEY `idx_log_action` (`action`),
  ADD KEY `idx_log_date` (`date_action`);

--
-- Index pour la table `messages_notification`
--
ALTER TABLE `messages_notification`
  ADD PRIMARY KEY (`id_message`),
  ADD UNIQUE KEY `id_notification` (`id_notification`);

--
-- Index pour la table `notifications_anonymes`
--
ALTER TABLE `notifications_anonymes`
  ADD PRIMARY KEY (`id_notification`),
  ADD UNIQUE KEY `token_unique` (`token_unique`),
  ADD KEY `fk_notif_declaration` (`id_declaration`),
  ADD KEY `fk_notif_partenaire` (`id_partenaire`),
  ADD KEY `idx_notif_statut` (`statut`);

--
-- Index pour la table `partenaires`
--
ALTER TABLE `partenaires`
  ADD PRIMARY KEY (`id_partenaire`),
  ADD KEY `idx_partenaire_user` (`id_utilisateur`);

--
-- Index pour la table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id_tag`);

--
-- Index pour la table `tags_list`
--
ALTER TABLE `tags_list`
  ADD PRIMARY KEY (`id_blog`,`id_tag`),
  ADD KEY `link` (`id_tag`);

--
-- Index pour la table `tokens_session`
--
ALTER TABLE `tokens_session`
  ADD PRIMARY KEY (`id_token`),
  ADD UNIQUE KEY `token` (`token`),
  ADD KEY `fk_token_utilisateur` (`id_utilisateur`),
  ADD KEY `idx_token_expiration` (`date_expiration`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id_utilisateur`),
  ADD UNIQUE KEY `pseudo` (`pseudo`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id_blog` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `declarations_ist`
--
ALTER TABLE `declarations_ist`
  MODIFY `id_declaration` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `ist`
--
ALTER TABLE `ist`
  MODIFY `id_ist` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `logs_activite`
--
ALTER TABLE `logs_activite`
  MODIFY `id_log` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `messages_notification`
--
ALTER TABLE `messages_notification`
  MODIFY `id_message` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `notifications_anonymes`
--
ALTER TABLE `notifications_anonymes`
  MODIFY `id_notification` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `partenaires`
--
ALTER TABLE `partenaires`
  MODIFY `id_partenaire` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `tags`
--
ALTER TABLE `tags`
  MODIFY `id_tag` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `tokens_session`
--
ALTER TABLE `tokens_session`
  MODIFY `id_token` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id_utilisateur` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `declarations_ist`
--
ALTER TABLE `declarations_ist`
  ADD CONSTRAINT `fk_decl_ist` FOREIGN KEY (`id_ist`) REFERENCES `ist` (`id_ist`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_decl_utilisateur` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateurs` (`id_utilisateur`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `logs_activite`
--
ALTER TABLE `logs_activite`
  ADD CONSTRAINT `fk_log_utilisateur` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateurs` (`id_utilisateur`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `messages_notification`
--
ALTER TABLE `messages_notification`
  ADD CONSTRAINT `fk_msg_notification` FOREIGN KEY (`id_notification`) REFERENCES `notifications_anonymes` (`id_notification`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `notifications_anonymes`
--
ALTER TABLE `notifications_anonymes`
  ADD CONSTRAINT `fk_notif_declaration` FOREIGN KEY (`id_declaration`) REFERENCES `declarations_ist` (`id_declaration`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_notif_partenaire` FOREIGN KEY (`id_partenaire`) REFERENCES `partenaires` (`id_partenaire`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `partenaires`
--
ALTER TABLE `partenaires`
  ADD CONSTRAINT `fk_partenaire_utilisateur` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateurs` (`id_utilisateur`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `tags_list`
--
ALTER TABLE `tags_list`
  ADD CONSTRAINT `isF` FOREIGN KEY (`id_blog`) REFERENCES `blogs` (`id_blog`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `link` FOREIGN KEY (`id_tag`) REFERENCES `tags` (`id_tag`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `tokens_session`
--
ALTER TABLE `tokens_session`
  ADD CONSTRAINT `fk_token_utilisateur` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateurs` (`id_utilisateur`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
