SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE IF NOT EXISTS `cours_administration` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `cours_administration`;

DROP TABLE IF EXISTS `capability`;
CREATE TABLE IF NOT EXISTS `capability` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lbl` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

TRUNCATE TABLE `capability`;
INSERT INTO `capability` (`id`, `lbl`) VALUES(1, 'Lister');
INSERT INTO `capability` (`id`, `lbl`) VALUES(2, 'Ajouter');
INSERT INTO `capability` (`id`, `lbl`) VALUES(3, 'Editer');
INSERT INTO `capability` (`id`, `lbl`) VALUES(4, 'Modifier');
INSERT INTO `capability` (`id`, `lbl`) VALUES(5, 'Supprimer');
INSERT INTO `capability` (`id`, `lbl`) VALUES(6, 'Publier');

DROP TABLE IF EXISTS `rel_role_capability`;
CREATE TABLE IF NOT EXISTS `rel_role_capability` (
  `role` int(11) NOT NULL,
  `capability` int(11) NOT NULL,
  PRIMARY KEY (`role`,`capability`),
  KEY `capability` (`capability`),
  KEY `role` (`role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

TRUNCATE TABLE `rel_role_capability`;
INSERT INTO `rel_role_capability` (`role`, `capability`) VALUES(1, 1);
INSERT INTO `rel_role_capability` (`role`, `capability`) VALUES(1, 2);
INSERT INTO `rel_role_capability` (`role`, `capability`) VALUES(1, 3);
INSERT INTO `rel_role_capability` (`role`, `capability`) VALUES(1, 4);
INSERT INTO `rel_role_capability` (`role`, `capability`) VALUES(1, 5);
INSERT INTO `rel_role_capability` (`role`, `capability`) VALUES(1, 6);
INSERT INTO `rel_role_capability` (`role`, `capability`) VALUES(2, 1);
INSERT INTO `rel_role_capability` (`role`, `capability`) VALUES(2, 3);
INSERT INTO `rel_role_capability` (`role`, `capability`) VALUES(2, 4);
INSERT INTO `rel_role_capability` (`role`, `capability`) VALUES(3, 1);
INSERT INTO `rel_role_capability` (`role`, `capability`) VALUES(4, 1);
INSERT INTO `rel_role_capability` (`role`, `capability`) VALUES(4, 3);

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lbl` varchar(50) NOT NULL,
  `power` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

TRUNCATE TABLE `role`;
INSERT INTO `role` (`id`, `lbl`, `power`) VALUES(1, 'Super Admin', 1);
INSERT INTO `role` (`id`, `lbl`, `power`) VALUES(2, 'Admin', 10);
INSERT INTO `role` (`id`, `lbl`, `power`) VALUES(3, 'Invité', 100);
INSERT INTO `role` (`id`, `lbl`, `power`) VALUES(4, 'Éditeur', 50);

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(50) NOT NULL,
  `pwd` varchar(50) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `role_fk` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `role_fk` (`role_fk`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

TRUNCATE TABLE `user`;
INSERT INTO `user` (`id`, `login`, `pwd`, `lastname`, `firstname`, `role_fk`) VALUES(1, 'su', 'su@pwd', 'Objectif 3W', 'Webmaster', 1);
INSERT INTO `user` (`id`, `login`, `pwd`, `lastname`, `firstname`, `role_fk`) VALUES(2, 'admin', 'admin@pwd', 'Nebuchadnezzar', 'Morpheus', 2);
INSERT INTO `user` (`id`, `login`, `pwd`, `lastname`, `firstname`, `role_fk`) VALUES(3, 'user', 'user@pwd', 'Anderson', 'Thomas A.', 3);
INSERT INTO `user` (`id`, `login`, `pwd`, `lastname`, `firstname`, `role_fk`) VALUES(4, 'editeur', 'edit@pwd', 'Objectif 3W', 'Éditeur', 4);


ALTER TABLE `rel_role_capability`
  ADD CONSTRAINT `rel_role_capability_ibfk_1` FOREIGN KEY (`role`) REFERENCES `role` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `rel_role_capability_ibfk_2` FOREIGN KEY (`capability`) REFERENCES `capability` (`id`) ON UPDATE CASCADE;

ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`role_fk`) REFERENCES `role` (`id`) ON UPDATE CASCADE;
USE `phpmyadmin`;

TRUNCATE TABLE `pma__column_info`;
TRUNCATE TABLE `pma__table_uiprefs`;
TRUNCATE TABLE `pma__tracking`;
TRUNCATE TABLE `pma__column_info`;
TRUNCATE TABLE `pma__table_uiprefs`;
TRUNCATE TABLE `pma__tracking`;
TRUNCATE TABLE `pma__column_info`;
TRUNCATE TABLE `pma__table_uiprefs`;
TRUNCATE TABLE `pma__tracking`;
TRUNCATE TABLE `pma__column_info`;
TRUNCATE TABLE `pma__table_uiprefs`;
TRUNCATE TABLE `pma__tracking`;
TRUNCATE TABLE `pma__bookmark`;
TRUNCATE TABLE `pma__relation`;
TRUNCATE TABLE `pma__savedsearches`;
TRUNCATE TABLE `pma__central_columns`;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
