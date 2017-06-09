-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Jeu 18 Août 2016 à 11:18
-- Version du serveur :  10.1.13-MariaDB
-- Version de PHP :  5.6.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `graphe`
--
CREATE DATABASE IF NOT EXISTS `graphe` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `graphe`;

-- --------------------------------------------------------

--
-- Structure de la table `edge`
--

CREATE TABLE `edge` (
  `e_from` int(11) NOT NULL,
  `e_to` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `edge`
--

INSERT INTO `edge` (`e_from`, `e_to`) VALUES
(1, 2),
(1, 6),
(2, 1),
(2, 4),
(2, 5),
(3, 6),
(3, 8),
(4, 2),
(4, 5),
(4, 6),
(5, 2),
(5, 4),
(5, 7),
(6, 1),
(6, 3),
(6, 4),
(6, 9),
(7, 5),
(7, 11),
(8, 3),
(8, 12),
(9, 6),
(9, 10),
(9, 12),
(10, 9),
(10, 13),
(11, 7),
(11, 14),
(12, 8),
(12, 9),
(12, 17),
(12, 18),
(13, 10),
(13, 18),
(13, 19),
(14, 11),
(14, 16),
(15, 16),
(15, 19),
(16, 14),
(16, 15),
(17, 12),
(17, 18),
(17, 22),
(18, 12),
(18, 13),
(18, 17),
(18, 20),
(19, 13),
(19, 15),
(19, 20),
(20, 18),
(20, 19),
(20, 21),
(20, 23),
(20, 24),
(21, 20),
(21, 24),
(22, 17),
(22, 25),
(23, 20),
(23, 25),
(24, 20),
(24, 21),
(25, 22),
(25, 23);

-- --------------------------------------------------------

--
-- Structure de la table `node`
--

CREATE TABLE `node` (
  `n_id` int(11) NOT NULL,
  `n_x` int(11) NOT NULL,
  `n_y` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `node`
--

INSERT INTO `node` (`n_id`, `n_x`, `n_y`) VALUES
(1, 2, 9),
(2, 3, 9),
(3, 1, 8),
(4, 3, 8),
(5, 4, 8),
(6, 2, 7),
(7, 5, 7),
(8, 0, 6),
(9, 2, 6),
(10, 3, 6),
(11, 6, 6),
(12, 1, 5),
(13, 4, 5),
(14, 7, 5),
(15, 6, 4),
(16, 7, 4),
(17, 1, 3),
(18, 3, 3),
(19, 5, 3),
(20, 4, 2),
(21, 6, 2),
(22, 1, 1),
(23, 4, 1),
(24, 5, 1),
(25, 3, 0);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `edge`
--
--  ALTER TABLE `edge`
--    ADD PRIMARY KEY (`e_from`,`e_to`),
--    ADD KEY `e_to` (`e_to`);
ALTER TABLE `edge`
  ADD PRIMARY KEY (`e_from`,`e_to`);

--
-- Index pour la table `node`
--
ALTER TABLE `node`
  ADD PRIMARY KEY (`n_id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `node`
--
ALTER TABLE `node`
  MODIFY `n_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `edge`
--
ALTER TABLE `edge`
  ADD CONSTRAINT `edge_ibfk_1` FOREIGN KEY (`e_from`) REFERENCES `node` (`n_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `edge_ibfk_2` FOREIGN KEY (`e_to`) REFERENCES `node` (`n_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
