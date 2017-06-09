USE `forum`;

# INSERTION
INSERT INTO `rang` ( `r_libelle` ) VALUES ( "SuperAdmin" );
INSERT INTO `rang` ( `r_libelle` ) VALUES ( "Admin" );
INSERT INTO `rang` ( `r_id`, `r_libelle` ) VALUES ( 12, "Invité" );

INSERT INTO `user` ( `u_login`, `u_prenom`, `u_date_inscription`, `u_rang_fk` ) VALUES
( "the_boss_du_34", "Moi et moi seul", "2017-03-07 11:46:56", 1 ),
( "the_subboss_du_34", "L'autre", NOW(), 2 ),
( "the_subboss_du_34", "L'autre 2", NOW(), 2 );

# MODIFICATION
UPDATE `user` SET `u_rang_fk`=3 WHERE `u_rang_fk`>3;

# SUPPRESSION
DELETE FROM `user` WHERE `u_prenom`="L'autre" OR `u_prenom`="L'autre 2";

# SELECTION
SELECT * FROM `user`;
SELECT * FROM `rang` WHERE `r_id`=2;
SELECT `u_prenom`, `u_nom` FROM `user`;
SELECT `u_prenom`, `u_nom` FROM `user` WHERE `u_rang_fk`<2;
# SELECTION AVEC JOINTURE
SELECT `u_prenom`, `u_nom`, `r_libelle` FROM `user` JOIN `rang` ON `u_rang_fk`=`r_id` WHERE `u_rang_fk`<2;




# https://sql.sh/