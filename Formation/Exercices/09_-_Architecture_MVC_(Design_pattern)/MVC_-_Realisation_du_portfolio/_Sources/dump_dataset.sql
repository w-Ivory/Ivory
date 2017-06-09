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

INSERT INTO `taxonomy`(`keyword`, `denomination`, `description`) VALUES ("post_type", "", "");
INSERT INTO `taxonomy`(`keyword`, `denomination`, `description`) VALUES ("post_status", "", "");
INSERT INTO `taxonomy`(`keyword`, `denomination`, `description`) VALUES ("post_access", "", "");
INSERT INTO `taxonomy`(`keyword`, `denomination`, `description`) VALUES ("post_format", "", "");

INSERT INTO `term`(`keyword`, `denomination`, `description`, `taxonomy`) VALUES ("category", "Category", "", "post_type");
INSERT INTO `term`(`keyword`, `denomination`, `description`, `taxonomy`) VALUES ("post", "Post", "", "post_type");
INSERT INTO `term`(`keyword`, `denomination`, `description`, `taxonomy`) VALUES ("page", "Page", "", "post_type");
INSERT INTO `term`(`keyword`, `denomination`, `description`, `taxonomy`) VALUES ("draft", "Draft", "", "post_status");
INSERT INTO `term`(`keyword`, `denomination`, `description`, `taxonomy`) VALUES ("pending", "Waiting for approval", "", "post_status");
INSERT INTO `term`(`keyword`, `denomination`, `description`, `taxonomy`) VALUES ("publish", "Published", "", "post_status");
INSERT INTO `term`(`keyword`, `denomination`, `description`, `taxonomy`) VALUES ("revision", "Auto-draft", "", "post_status");
INSERT INTO `term`(`keyword`, `denomination`, `description`, `taxonomy`) VALUES ("trash", "Trash", "", "post_status");
INSERT INTO `term`(`keyword`, `denomination`, `description`, `taxonomy`) VALUES ("private", "Private", "Only an Administrator can see this", "post_access");
INSERT INTO `term`(`keyword`, `denomination`, `description`, `taxonomy`) VALUES ("protected", "Protected", "Password protected", "post_access");
INSERT INTO `term`(`keyword`, `denomination`, `description`, `taxonomy`) VALUES ("public", "Public", "Everyone can see this", "post_access");
INSERT INTO `term`(`keyword`, `denomination`, `description`, `taxonomy`) VALUES ("nav_menu", "Navigation menu", "", "post_format");
INSERT INTO `term`(`keyword`, `denomination`, `description`, `taxonomy`) VALUES ("gallery", "Gallery", "", "post_format");
INSERT INTO `term`(`keyword`, `denomination`, `description`, `taxonomy`) VALUES ("image", "Image", "", "post_format");
INSERT INTO `term`(`keyword`, `denomination`, `description`, `taxonomy`) VALUES ("audio", "Audio player", "", "post_format");
INSERT INTO `term`(`keyword`, `denomination`, `description`, `taxonomy`) VALUES ("video", "Video player", "", "post_format");
INSERT INTO `term`(`keyword`, `denomination`, `description`, `taxonomy`) VALUES ("quote", "Blockquote", "", "post_format");
INSERT INTO `term`(`keyword`, `denomination`, `description`, `taxonomy`) VALUES ("link", "Link", "", "post_format");
INSERT INTO `term`(`keyword`, `denomination`, `description`, `taxonomy`) VALUES ("code", "Block code", "", "post_format");

INSERT INTO `capability`(`keyword`, `denomination`, `description`) VALUES ("edit_dashboard","","");
INSERT INTO `capability`(`keyword`, `denomination`, `description`) VALUES ("list_users","","");
INSERT INTO `capability`(`keyword`, `denomination`, `description`) VALUES ("edit_users","","");
INSERT INTO `capability`(`keyword`, `denomination`, `description`) VALUES ("create_users","","");
INSERT INTO `capability`(`keyword`, `denomination`, `description`) VALUES ("promote_users","","");
INSERT INTO `capability`(`keyword`, `denomination`, `description`) VALUES ("delete_users","","");
INSERT INTO `capability`(`keyword`, `denomination`, `description`) VALUES ("manage_options","","");
INSERT INTO `capability`(`keyword`, `denomination`, `description`) VALUES ("update_core","","");
INSERT INTO `capability`(`keyword`, `denomination`, `description`) VALUES ("update_plugins","","");
INSERT INTO `capability`(`keyword`, `denomination`, `description`) VALUES ("moderate_comments","","");
INSERT INTO `capability`(`keyword`, `denomination`, `description`) VALUES ("edit_comments","","");
INSERT INTO `capability`(`keyword`, `denomination`, `description`) VALUES ("delete_comments","","");
INSERT INTO `capability`(`keyword`, `denomination`, `description`) VALUES ("manage_categories","","");
INSERT INTO `capability`(`keyword`, `denomination`, `description`) VALUES ("upload_files","","");
INSERT INTO `capability`(`keyword`, `denomination`, `description`) VALUES ("edit_posts","","");
INSERT INTO `capability`(`keyword`, `denomination`, `description`) VALUES ("edit_others_posts","","");
INSERT INTO `capability`(`keyword`, `denomination`, `description`) VALUES ("edit_published_posts","","");
INSERT INTO `capability`(`keyword`, `denomination`, `description`) VALUES ("edit_private_posts","","");
INSERT INTO `capability`(`keyword`, `denomination`, `description`) VALUES ("publish_posts","","");
INSERT INTO `capability`(`keyword`, `denomination`, `description`) VALUES ("delete_posts","","");
INSERT INTO `capability`(`keyword`, `denomination`, `description`) VALUES ("delete_others_posts","","");
INSERT INTO `capability`(`keyword`, `denomination`, `description`) VALUES ("delete_published_posts","","");
INSERT INTO `capability`(`keyword`, `denomination`, `description`) VALUES ("delete_private_posts","","");
INSERT INTO `capability`(`keyword`, `denomination`, `description`) VALUES ("edit_pages","","");
INSERT INTO `capability`(`keyword`, `denomination`, `description`) VALUES ("edit_others_pages","","");
INSERT INTO `capability`(`keyword`, `denomination`, `description`) VALUES ("edit_published_pages","","");
INSERT INTO `capability`(`keyword`, `denomination`, `description`) VALUES ("edit_private_pages","","");
INSERT INTO `capability`(`keyword`, `denomination`, `description`) VALUES ("publish_pages","","");
INSERT INTO `capability`(`keyword`, `denomination`, `description`) VALUES ("delete_pages","","");
INSERT INTO `capability`(`keyword`, `denomination`, `description`) VALUES ("delete_others_pages","","");
INSERT INTO `capability`(`keyword`, `denomination`, `description`) VALUES ("delete_published_pages","","");
INSERT INTO `capability`(`keyword`, `denomination`, `description`) VALUES ("delete_private_pages","","");

INSERT INTO `role`(`keyword`, `denomination`, `power`) VALUES ("superadmin", "Super Administrator", 0);
INSERT INTO `role`(`keyword`, `denomination`, `power`) VALUES ("administrator", "Administrator", 1);
INSERT INTO `role`(`keyword`, `denomination`, `power`) VALUES ("seo", "SEO", 10);
INSERT INTO `role`(`keyword`, `denomination`, `power`) VALUES ("contributor", "Contributor", 100);
INSERT INTO `role`(`keyword`, `denomination`, `power`) VALUES ("subscriber", "Subscriber", 999999999);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;