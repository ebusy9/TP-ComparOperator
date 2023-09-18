-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : dim. 17 sep. 2023 à 17:27
-- Version du serveur : 8.0.30
-- Version de PHP : 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `comparoperator`
--

-- --------------------------------------------------------

--
-- Structure de la table `author`
--

CREATE TABLE `author` (
  `author_id` int NOT NULL,
  `author_name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `author`
--

INSERT INTO `author` (`author_id`, `author_name`) VALUES
(1, 'Michel'),
(2, 'René'),
(3, 'Paul'),
(17213, 'testtest'),
(53509, 'pepa'),
(86786, 'jean');

-- --------------------------------------------------------

--
-- Structure de la table `certificate`
--

CREATE TABLE `certificate` (
  `tour_operator_id` int NOT NULL,
  `expires_at` datetime NOT NULL,
  `signatory` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `certificate`
--

INSERT INTO `certificate` (`tour_operator_id`, `expires_at`, `signatory`) VALUES
(1, '2022-02-09 14:50:07', 'Jean Bertrand'),
(2, '2023-02-03 14:50:07', 'Bernard Michel');

-- --------------------------------------------------------

--
-- Structure de la table `destination`
--

CREATE TABLE `destination` (
  `destination_id` int NOT NULL,
  `destination_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `destination_img` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `destination`
--

INSERT INTO `destination` (`destination_id`, `destination_name`, `destination_img`) VALUES
(105579, 'tunis', 'assets/destination_img/tunis2ad39566ee108.jpg'),
(349307, 'londres', 'assets/destination_img/londresacdac51dd9dcf.jpeg'),
(871161, 'rome', 'assets/destination_img/romeb8587a61d75e2.jpg'),
(876183, 'monaco', 'assets/destination_img/monaco53e637018a30d.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `offer_destination`
--

CREATE TABLE `offer_destination` (
  `offer_destination_id` int NOT NULL,
  `destination_id` int NOT NULL,
  `price` int NOT NULL,
  `tour_operator_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `offer_destination`
--

INSERT INTO `offer_destination` (`offer_destination_id`, `destination_id`, `price`, `tour_operator_id`) VALUES
(75827, 105579, 8796, 1),
(704554, 876183, 9669, 2);

-- --------------------------------------------------------

--
-- Structure de la table `review`
--

CREATE TABLE `review` (
  `review_id` int NOT NULL,
  `message` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `score` int NOT NULL,
  `tour_operator_id` int NOT NULL,
  `author_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `review`
--

INSERT INTO `review` (`review_id`, `message`, `score`, `tour_operator_id`, `author_id`) VALUES
(1, 'Super voyage, prestation au top !!', 5, 2, 1),
(4, 'arnaque!!!! a fuire!!!', 1, 2, 2),
(633307, 'ça va pour le prix...!', 3, 2, 3),
(656586, 'Ceci est un test', 4, 1, 17213);

-- --------------------------------------------------------

--
-- Structure de la table `tour_operator`
--

CREATE TABLE `tour_operator` (
  `tour_operator_id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `tour_operator_img` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `tour_operator`
--

INSERT INTO `tour_operator` (`tour_operator_id`, `name`, `link`, `tour_operator_img`) VALUES
(1, 'Salaun Holidays', 'https://www.salaun-holidays.com/', 'assets/to_logo/salaun_holidays1fea92ecfe77e.jpg'),
(2, 'Fram', 'https://www.fram.fr/', 'assets/to_logo/fram2e89cb33cb318.png'),
(3, 'Heliades', 'https://www.heliades.fr/', 'assets/to_logo/heliadesb7eaa1b9fc2b9.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `user_id` int NOT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `registration_date` datetime NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`user_id`, `login`, `password`, `username`, `registration_date`, `is_admin`) VALUES
(120999, 'yrty', '$2y$10$VSyUSguPZ8w12FQzPvuoHui2iI0HwgRwDoiM7DdAC0GdcQBCKuWyS', 'tutyuu', '2023-09-16 22:09:12', 0),
(141805, 'okkoko', '$2y$10$fNvT1nNGdcDGazb2gA3XzOlIeszcmH7hNwW6TScPvOx5.2FuUfcjK', 'bsdfr', '2023-09-16 22:03:34', 0),
(527632, 'erte', '$2y$10$8yDstUYIg7NUtEJi5exYyuQIiDsD47MeFTEYu2R2dS6cbUgl.5qca', 'tere', '2023-09-16 22:09:18', 0),
(836747, 'trtr', '$2y$10$oHStyZXW605VBUmZ3gUmhuLdwL/lR2KMbUIp2ZnxhfUVrwzqtm7TW', 'tr', '2023-09-16 22:09:03', 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `author`
--
ALTER TABLE `author`
  ADD PRIMARY KEY (`author_id`);

--
-- Index pour la table `certificate`
--
ALTER TABLE `certificate`
  ADD PRIMARY KEY (`tour_operator_id`);

--
-- Index pour la table `destination`
--
ALTER TABLE `destination`
  ADD PRIMARY KEY (`destination_id`),
  ADD UNIQUE KEY `destination_name` (`destination_name`);

--
-- Index pour la table `offer_destination`
--
ALTER TABLE `offer_destination`
  ADD PRIMARY KEY (`offer_destination_id`),
  ADD KEY `destination_tour_operator` (`tour_operator_id`),
  ADD KEY `destination_id` (`destination_id`);

--
-- Index pour la table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `review_tour_operator` (`tour_operator_id`),
  ADD KEY `review_author` (`author_id`);

--
-- Index pour la table `tour_operator`
--
ALTER TABLE `tour_operator`
  ADD PRIMARY KEY (`tour_operator_id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `login` (`login`,`username`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `author`
--
ALTER TABLE `author`
  MODIFY `author_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=823229;

--
-- AUTO_INCREMENT pour la table `destination`
--
ALTER TABLE `destination`
  MODIFY `destination_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=962271;

--
-- AUTO_INCREMENT pour la table `offer_destination`
--
ALTER TABLE `offer_destination`
  MODIFY `offer_destination_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=704555;

--
-- AUTO_INCREMENT pour la table `review`
--
ALTER TABLE `review`
  MODIFY `review_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=656587;

--
-- AUTO_INCREMENT pour la table `tour_operator`
--
ALTER TABLE `tour_operator`
  MODIFY `tour_operator_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=977337;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=836748;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `certificate`
--
ALTER TABLE `certificate`
  ADD CONSTRAINT `certificate_tour_operator` FOREIGN KEY (`tour_operator_id`) REFERENCES `tour_operator` (`tour_operator_id`);

--
-- Contraintes pour la table `offer_destination`
--
ALTER TABLE `offer_destination`
  ADD CONSTRAINT `destination_tour_operator` FOREIGN KEY (`tour_operator_id`) REFERENCES `tour_operator` (`tour_operator_id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `offer_destination_ibfk_1` FOREIGN KEY (`destination_id`) REFERENCES `destination` (`destination_id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Contraintes pour la table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_author` FOREIGN KEY (`author_id`) REFERENCES `author` (`author_id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `review_tour_operator` FOREIGN KEY (`tour_operator_id`) REFERENCES `tour_operator` (`tour_operator_id`) ON DELETE CASCADE ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
