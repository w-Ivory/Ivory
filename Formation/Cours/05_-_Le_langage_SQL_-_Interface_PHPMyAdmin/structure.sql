# ------------------------------
# BASE DE DONNÉES
# ------------------------------
# Création
CREATE DATABASE IF NOT EXISTS `nom_de_ma_base` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
# Utilisation
USE `nom_de_ma_base`;
# Suppression
DROP DATABASE IF EXISTS `nom_de_ma_base`;

# ------------------------------
# TABLE (ENTITÉ)
# ------------------------------
# Création
CREATE TABLE IF NOT EXISTS `robe` (
`id_robe` INT(11) NOT NULL,
`libelle_robe` VARCHAR(50) NOT NULL DEFAULT ""
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
# Altération post-création de la table pour ajouter une clé primaire sur un champs
ALTER TABLE `robe` ADD PRIMARY KEY (`id_robe`);
# Altération post-création de la table modifier la structure d'un champs (attribut)
ALTER TABLE `robe` CHANGE `id_robe` `id_robe` INT(11) NOT NULL AUTO_INCREMENT;
# Altérations combinées post-création de la table pour ajouter une clé primaire sur un champs et modifier la structure d'un champs pour le mettre en incrémentation automatique
ALTER TABLE `robe` ADD PRIMARY KEY (`id_robe`), CHANGE `id_robe` `id_robe` INT(11) NOT NULL AUTO_INCREMENT; # /!\ Attention à l'ordre des instructions, l'incrémentation automatique ne peut se faire que sur une clé primaire

# Création avec actions combinées
CREATE TABLE IF NOT EXISTS `cheval` (
`num_enregistrement` INT(11) NOT NULL AUTO_INCREMENT,
`date_naissance` DATE NOT NULL DEFAULT "0000-00-00",
PRIMARY KEY (`num_enregistrement`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
# Altérations post-création de la table pour ajouter des champs
ALTER TABLE `cheval` ADD `id_robe` INT(11) NOT NULL AFTER `date_naissance`, ADD `id_race` INT(11) NOT NULL AFTER `id_robe`;
# Altérations post-création de la table pour ajouter une indexation sur des champs afin de placer des contraintes de clés étrangères pour les relations
ALTER TABLE `cheval` ADD INDEX( `id_robe`, `id_race`), ADD CONSTRAINT `constrainte_cheval_robe` FOREIGN KEY (`id_robe`) REFERENCES `robe` (`id_robe`) ON UPDATE CASCADE ON DELETE RESTRICT, ADD CONSTRAINT `constrainte_cheval_race` FOREIGN KEY (`id_race`) REFERENCES `nom_de_ma_base`.`race`(`id_race`) ON DELETE RESTRICT ON UPDATE CASCADE;