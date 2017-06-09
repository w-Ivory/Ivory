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
  `c_id` int(11) NOT NULL,
  `c_date` datetime NOT NULL,
  `c_termine` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- INDEX POUR LA TABLE `conversation`:
--
ALTER TABLE `conversation` ADD PRIMARY KEY(`c_id`), CHANGE `c_id` `c_id` INT(11) NOT NULL AUTO_INCREMENT;

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

CREATE TABLE `message` (
  `m_id` int(11) NOT NULL,
  `m_contenu` varchar(2040) NOT NULL,
  `m_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- INDEX POUR LA TABLE `message`:
--
ALTER TABLE `message` ADD PRIMARY KEY(`m_id`), CHANGE `m_id` `m_id` INT(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `message` ADD `m_auteur_fk` int(11) NOT NULL AFTER `m_date`, ADD INDEX(`m_auteur_fk`);
ALTER TABLE `message` ADD `m_conversation_fk` int(11) NOT NULL AFTER `m_auteur_fk`, ADD INDEX(`m_conversation_fk`);

-- --------------------------------------------------------

--
-- Structure de la table `rang`
--

CREATE TABLE `rang` (
  `r_id` int(11) NOT NULL,
  `r_libelle` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- INDEX POUR LA TABLE `rang`:
--
ALTER TABLE `rang` ADD PRIMARY KEY(`r_id`), CHANGE `r_id` `r_id` INT(11) NOT NULL AUTO_INCREMENT;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `u_id` int(11) NOT NULL,
  `u_login` varchar(30) NOT NULL,
  `u_prenom` varchar(255) DEFAULT NULL,
  `u_nom` varchar(255) DEFAULT NULL,
  `u_date_naissance` date DEFAULT NULL,
  `u_date_inscription` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- INDEX POUR LA TABLE `rang`:
--
ALTER TABLE `user` ADD PRIMARY KEY(`u_id`), CHANGE `u_id` `u_id` INT(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `user` ADD `u_rang_fk` int(11) NOT NULL AFTER `u_date_inscription`, ADD INDEX(`u_rang_fk`);

-- --------------------------------------------------------

--
-- Contraintes pour les tables exportées
--

--
--
-- RELATIONS POUR LA TABLE `message`:
--   `m_auteur_fk`
--       `user` -> `u_id`
--   `m_conversation_fk`
--       `conversation` -> `c_id`
--
ALTER TABLE `message` ADD FOREIGN KEY (`m_conversation_fk`) REFERENCES `conversation`(`c_id`) ON DELETE RESTRICT ON UPDATE CASCADE;
ALTER TABLE `message` ADD FOREIGN KEY (`m_auteur_fk`) REFERENCES `user`(`u_id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- RELATIONS POUR LA TABLE `user`:
--   `u_rang_fk`
--       `rang` -> `r_id`
--
ALTER TABLE `user` ADD FOREIGN KEY (`u_rang_fk`) REFERENCES `rang`(`r_id`) ON DELETE RESTRICT ON UPDATE CASCADE;