-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : mar. 22 mars 2022 à 13:58
-- Version du serveur : 5.7.33
-- Version de PHP : 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `comparo_full`
--

-- --------------------------------------------------------

--
-- Structure de la table `author`
--

CREATE TABLE `author` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `author`
--

INSERT INTO `author` (`id`, `name`) VALUES
(1, 'Michel'),
(2, 'René'),
(3, 'Paul');

-- --------------------------------------------------------

--
-- Structure de la table `certificate`
--

CREATE TABLE `certificate` (
  `tour_operator_id` int(11) NOT NULL,
  `expires_at` datetime NOT NULL,
  `signatory` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `certificate`
--

INSERT INTO `certificate` (`tour_operator_id`, `expires_at`, `signatory`) VALUES
(1, '2022-02-09 14:50:07', 'Jean Bertrand'),
(2, '2023-01-02 14:50:07', 'Bernard Michel');

-- --------------------------------------------------------

--
-- Structure de la table `destination`
--

CREATE TABLE `destination` (
  `id` int(11) NOT NULL,
  `location` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `tour_operator_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `destination`
--

INSERT INTO `destination` (`id`, `location`, `price`, `tour_operator_id`) VALUES
(1, 'Rome', 1650, 2),
(2, 'Londres', 1100, 2),
(3, 'Monaco', 1390, 1),
(4, 'Tunis', 2390, 3);

-- --------------------------------------------------------

--
-- Structure de la table `review`
--

CREATE TABLE `review` (
  `id` int(11) NOT NULL,
  `message` varchar(255) NOT NULL,
  `tour_operator_id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `review`
--

INSERT INTO `review` (`id`, `message`, `tour_operator_id`, `author_id`) VALUES
(1, 'Super voyage, prestation au top !!', 2, 1),
(2, 'Tout est inclus dans le prix, c\'est cool, je recommande', 3, 3),
(3, 'Un peu cher, mais ça vaut le coup', 2, 3),
(4, 'arnaque!!!! a fuire!!!', 2, 2);

-- --------------------------------------------------------

--
-- Structure de la table `score`
--

CREATE TABLE `score` (
  `id` int(11) NOT NULL,
  `value` int(11) NOT NULL,
  `tour_operator_id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `score`
--

INSERT INTO `score` (`id`, `value`, `tour_operator_id`, `author_id`) VALUES
(1, 5, 2, 1),
(2, 4, 3, 3),
(3, 1, 2, 2);

-- --------------------------------------------------------

--
-- Structure de la table `tour_operator`
--

CREATE TABLE `tour_operator` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tour_operator`
--

INSERT INTO `tour_operator` (`id`, `name`, `link`) VALUES
(1, 'Salaun Holidays', 'https://www.salaun-holidays.com/'),
(2, 'Fram', 'https://www.fram.fr/'),
(3, 'Heliades', 'https://www.heliades.fr/');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `author`
--
ALTER TABLE `author`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `certificate`
--
ALTER TABLE `certificate`
  ADD PRIMARY KEY (`tour_operator_id`);

--
-- Index pour la table `destination`
--
ALTER TABLE `destination`
  ADD PRIMARY KEY (`id`),
  ADD KEY `destination_tour_operator` (`tour_operator_id`);

--
-- Index pour la table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`id`),
  ADD KEY `review_tour_operator` (`tour_operator_id`),
  ADD KEY `review_author` (`author_id`);

--
-- Index pour la table `score`
--
ALTER TABLE `score`
  ADD PRIMARY KEY (`id`),
  ADD KEY `score_tour_operator` (`tour_operator_id`),
  ADD KEY `score_author` (`author_id`);

--
-- Index pour la table `tour_operator`
--
ALTER TABLE `tour_operator`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `author`
--
ALTER TABLE `author`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `destination`
--
ALTER TABLE `destination`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `review`
--
ALTER TABLE `review`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `score`
--
ALTER TABLE `score`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `tour_operator`
--
ALTER TABLE `tour_operator`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `certificate`
--
ALTER TABLE `certificate`
  ADD CONSTRAINT `certificate_tour_operator` FOREIGN KEY (`tour_operator_id`) REFERENCES `tour_operator` (`id`);

--
-- Contraintes pour la table `destination`
--
ALTER TABLE `destination`
  ADD CONSTRAINT `destination_tour_operator` FOREIGN KEY (`tour_operator_id`) REFERENCES `tour_operator` (`id`);

--
-- Contraintes pour la table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_author` FOREIGN KEY (`author_id`) REFERENCES `author` (`id`),
  ADD CONSTRAINT `review_tour_operator` FOREIGN KEY (`tour_operator_id`) REFERENCES `tour_operator` (`id`);

--
-- Contraintes pour la table `score`
--
ALTER TABLE `score`
  ADD CONSTRAINT `score_author` FOREIGN KEY (`author_id`) REFERENCES `author` (`id`),
  ADD CONSTRAINT `score_tour_operator` FOREIGN KEY (`tour_operator_id`) REFERENCES `tour_operator` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
