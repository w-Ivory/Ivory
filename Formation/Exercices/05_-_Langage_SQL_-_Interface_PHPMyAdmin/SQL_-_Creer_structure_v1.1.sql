-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Lun 25 Juillet 2016 à 17:15
-- Version du serveur :  10.1.13-MariaDB
-- Version de PHP :  7.0.5

-- --------------------------------------------------------

--
-- Structure de la table `conversation`
--

CREATE TABLE `conversation` (
  `c_id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `c_date` datetime NOT NULL,
  `c_termine` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELATIONS POUR LA TABLE `conversation`:
--

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

CREATE TABLE `message` (
  `m_id` int(11) NOT NULL AUTO_INCREMENT,
  `m_contenu` varchar(2040) NOT NULL,
  `m_date` datetime NOT NULL,
  `m_auteur_fk` int(11) NOT NULL,
  `m_conversation_fk` int(11) NOT NULL,
  PRIMARY KEY (`m_id`),
  KEY `m_auteur_fk` (`m_auteur_fk`),
  KEY `m_conversation_fk` (`m_conversation_fk`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELATIONS POUR LA TABLE `message`:
--   `m_auteur_fk`
--       `user` -> `u_id`
--   `m_conversation_fk`
--       `conversation` -> `c_id`
--

-- --------------------------------------------------------

--
-- Structure de la table `rang`
--

CREATE TABLE `rang` (
  `r_id` int(11) NOT NULL AUTO_INCREMENT,
  `r_libelle` varchar(255) NOT NULL,
  PRIMARY KEY (`r_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELATIONS POUR LA TABLE `rang`:
--

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `u_id` int(11) NOT NULL AUTO_INCREMENT,
  `u_login` varchar(30) NOT NULL,
  `u_prenom` varchar(255) DEFAULT NULL,
  `u_nom` varchar(255) DEFAULT NULL,
  `u_date_naissance` date DEFAULT NULL,
  `u_date_inscription` datetime NOT NULL,
  `u_rang_fk` int(11) NOT NULL,
  PRIMARY KEY (`u_id`),
  KEY `u_rang_fk` (`u_rang_fk`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELATIONS POUR LA TABLE `user`:
--   `u_rang_fk`
--       `rang` -> `r_id`
--

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `message_ibfk_1` FOREIGN KEY (`m_auteur_fk`) REFERENCES `user` (`u_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `message_ibfk_2` FOREIGN KEY (`m_conversation_fk`) REFERENCES `conversation` (`c_id`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`u_rang_fk`) REFERENCES `rang` (`r_id`) ON UPDATE CASCADE;