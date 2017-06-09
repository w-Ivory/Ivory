-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 12, 2017 at 04:50 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 7.0.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `portfolio3w`
--

-- --------------------------------------------------------

--
-- Table structure for table `allowed_to`
--
-- Creation: May 12, 2017 at 02:34 PM
--

DROP TABLE IF EXISTS `allowed_to`;
CREATE TABLE IF NOT EXISTS `allowed_to` (
  `role` varchar(25) NOT NULL COMMENT 'superadmin | administrator | seo | contributor | subscriber',
  `capability` varchar(25) NOT NULL,
  PRIMARY KEY (`role`,`capability`),
  KEY (`role`),
  KEY (`capability`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELATIONS FOR TABLE `allowed_to`:
--   `capability`
--       `capability` -> `keyword`
--   `role`
--       `role` -> `keyword`
--

--
-- Truncate table before insert `allowed_to`
--

TRUNCATE TABLE `allowed_to`;
-- --------------------------------------------------------

--
-- Table structure for table `capability`
--
-- Creation: May 12, 2017 at 02:34 PM
--

DROP TABLE IF EXISTS `capability`;
CREATE TABLE IF NOT EXISTS `capability` (
  `keyword` varchar(25) NOT NULL,
  `denomination` varchar(50) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`keyword`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELATIONS FOR TABLE `capability`:
--

--
-- Truncate table before insert `capability`
--

TRUNCATE TABLE `capability`;
-- --------------------------------------------------------

--
-- Table structure for table `media`
--
-- Creation: May 12, 2017 at 02:34 PM
--

DROP TABLE IF EXISTS `media`;
CREATE TABLE IF NOT EXISTS `media` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uri` varchar(255) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `mime` varchar(255) NOT NULL,
  `upload_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'DEFAULT CURRENT_TIME',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELATIONS FOR TABLE `media`:
--

--
-- Truncate table before insert `media`
--

TRUNCATE TABLE `media`;
-- --------------------------------------------------------

--
-- Table structure for table `post`
--
-- Creation: May 12, 2017 at 02:34 PM
--

DROP TABLE IF EXISTS `post`;
CREATE TABLE IF NOT EXISTS `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `content` longtext NOT NULL,
  `excerpt` text NOT NULL,
  `release_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'DEFAULT CURRENT_TIME',
  `tab` int(11) NOT NULL DEFAULT 0 COMMENT 'DEFAULT 0',
  `type` varchar(25) NOT NULL COMMENT 'post_type : category | post | page',
  `status` varchar(25) NOT NULL COMMENT 'post_status : draft | pending | publish | revision | trash',
  `access` varchar(25) NOT NULL COMMENT 'post_access : private | protected | public',
  `format` varchar(25) NOT NULL COMMENT 'post_format : nav_menu | gallery | image | audio | video | quote | link | code',
  `parent` int(11) NOT NULL,
  `author` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY (`type`),
  KEY (`status`),
  KEY (`access`),
  KEY (`format`),
  KEY (`parent`),
  KEY (`author`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELATIONS FOR TABLE `post`:
--   `access`
--       `term` -> `keyword`
--   `author`
--       `user` -> `email`
--   `format`
--       `term` -> `keyword`
--   `parent`
--       `post` -> `id`
--   `status`
--       `term` -> `keyword`
--   `type`
--       `term` -> `keyword`
--

--
-- Truncate table before insert `post`
--

TRUNCATE TABLE `post`;
-- --------------------------------------------------------

--
-- Table structure for table `published_on`
--
-- Creation: May 12, 2017 at 02:34 PM
--

DROP TABLE IF EXISTS `published_on`;
CREATE TABLE IF NOT EXISTS `published_on` (
  `media` int(11) NOT NULL,
  `post` int(11) NOT NULL,
  PRIMARY KEY (`media`,`post`),
  KEY (`media`),
  KEY (`post`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELATIONS FOR TABLE `published_on`:
--   `media`
--       `media` -> `id`
--   `post`
--       `post` -> `id`
--

--
-- Truncate table before insert `published_on`
--

TRUNCATE TABLE `published_on`;
-- --------------------------------------------------------

--
-- Table structure for table `role`
--
-- Creation: May 12, 2017 at 02:34 PM
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `keyword` varchar(25) NOT NULL COMMENT 'superadmin | administrator | seo | contributor | subscriber',
  `denomination` varchar(50) NOT NULL,
  `power` int(11) NOT NULL,
  PRIMARY KEY (`keyword`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELATIONS FOR TABLE `role`:
--

--
-- Truncate table before insert `role`
--

TRUNCATE TABLE `role`;

-- --------------------------------------------------------

--
-- Table structure for table `taxonomy`
--
-- Creation: May 12, 2017 at 02:34 PM
--

DROP TABLE IF EXISTS `taxonomy`;
CREATE TABLE IF NOT EXISTS `taxonomy` (
  `keyword` varchar(25) NOT NULL COMMENT 'post_type | post_status | post_format | post_access',
  `denomination` varchar(50) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`keyword`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='A taxonomy is a way to group things together';

--
-- RELATIONS FOR TABLE `taxonomy`:
--

--
-- Truncate table before insert `taxonomy`
--

TRUNCATE TABLE `taxonomy`;
-- --------------------------------------------------------

--
-- Table structure for table `term`
--
-- Creation: May 12, 2017 at 02:34 PM
--

DROP TABLE IF EXISTS `term`;
CREATE TABLE IF NOT EXISTS `term` (
  `keyword` varchar(25) NOT NULL COMMENT 'post_type : category | post | page post_status : draft | pending | publish | revision | trash post_access : private | protected | public post_format : nav_menu | gallery | image | audio | video | quote | link | code',
  `denomination` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `taxonomy` varchar(25) NOT NULL COMMENT 'post_type | post_status | post_format | post_access',
  PRIMARY KEY (`keyword`),
  KEY (`taxonomy`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELATIONS FOR TABLE `term`:
--   `taxonomy`
--       `taxonomy` -> `keyword`
--

--
-- Truncate table before insert `term`
--

TRUNCATE TABLE `term`;
-- --------------------------------------------------------

--
-- Table structure for table `user`
--
-- Creation: May 12, 2017 at 02:34 PM
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `email` varchar(100) NOT NULL,
  `login` varchar(50) DEFAULT NULL,
  `password` varchar(50) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `registration_date` datetime NOT NULL,
  `last_connection_date` datetime DEFAULT NULL,
  `status` tinyint(1) NOT NULL COMMENT '-1 (waiting for validation) 0 (deactivated) 1 (activated) 9 (banished)',
  `avatar` int(11) NOT NULL,
  `token` varchar(75) DEFAULT NULL,
  `role` varchar(25) NOT NULL COMMENT 'superadmin | administrator | seo | contributor | subscriber',
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELATIONS FOR TABLE `user`:
--   `role`
--       `role` -> `keyword`
--

--
-- Truncate table before insert `user`
--

TRUNCATE TABLE `user`;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `allowed_to`
--
ALTER TABLE `allowed_to`
  ADD CONSTRAINT `FK_allowed_to_capability` FOREIGN KEY (`capability`) REFERENCES `capability` (`keyword`),
  ADD CONSTRAINT `FK_allowed_to_role` FOREIGN KEY (`role`) REFERENCES `role` (`keyword`);

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `FK_post_access` FOREIGN KEY (`access`) REFERENCES `term` (`keyword`),
  ADD CONSTRAINT `FK_post_author` FOREIGN KEY (`author`) REFERENCES `user` (`email`),
  ADD CONSTRAINT `FK_post_format` FOREIGN KEY (`format`) REFERENCES `term` (`keyword`),
  ADD CONSTRAINT `FK_post_parent` FOREIGN KEY (`parent`) REFERENCES `post` (`id`),
  ADD CONSTRAINT `FK_post_status` FOREIGN KEY (`status`) REFERENCES `term` (`keyword`),
  ADD CONSTRAINT `FK_post_type` FOREIGN KEY (`type`) REFERENCES `term` (`keyword`);

--
-- Constraints for table `published_on`
--
ALTER TABLE `published_on`
  ADD CONSTRAINT `FK_media_published_on` FOREIGN KEY (`media`) REFERENCES `media` (`id`),
  ADD CONSTRAINT `FK_published_on_post` FOREIGN KEY (`post`) REFERENCES `post` (`id`);

--
-- Constraints for table `term`
--
ALTER TABLE `term`
  ADD CONSTRAINT `FK_term_taxonomy` FOREIGN KEY (`taxonomy`) REFERENCES `taxonomy` (`keyword`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `FK_user_role` FOREIGN KEY (`role`) REFERENCES `role` (`keyword`),
  ADD CONSTRAINT `FK_user_avatar` FOREIGN KEY (`avatar`) REFERENCES `media` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;