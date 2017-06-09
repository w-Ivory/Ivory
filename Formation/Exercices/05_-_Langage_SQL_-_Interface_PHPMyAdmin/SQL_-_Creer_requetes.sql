#1
SELECT *
FROM `message`
WHERE `m_auteur_fk` = 10
ORDER BY `message`.`m_date` DESC
LIMIT 10;
#2
SELECT `u_nom`, `u_prenom`, `u_date_naissance`
FROM `user`
ORDER BY `user`.`u_date_naissance` ASC;
#3
SELECT *
FROM `user`
ORDER BY `user`.`u_date_inscription` DESC
LIMIT 5;
#4
SELECT `message`.`m_contenu`, `user`.`u_login`, `rang`.`r_libelle`
FROM `message`
INNER JOIN `user` ON `message`.`m_auteur_fk`= `user`.`u_id`
INNER JOIN `rang` ON `user`.`u_rang_fk`=`rang`.`r_id`
ORDER BY `message`.`m_date` DESC
LIMIT 20;
#5
# Version simple : les 5 derniers dans l'ensemble des résultats
SELECT *
FROM `message`
INNER JOIN `user` ON `message`.`m_auteur_fk`=`user`.`u_id`
INNER JOIN `rang` ON `user`.`u_rang_fk`=`rang`.`r_id`
WHERE `rang`.`r_libelle`="admin" AND (YEAR(NOW()) - YEAR(`user`.`u_date_naissance`))>18
ORDER BY `message`.`m_date` DESC
LIMIT 5;

SELECT *
FROM `message`
INNER JOIN `user` ON `message`.`m_auteur_fk`=`user`.`u_id`
INNER JOIN `rang` ON `user`.`u_rang_fk`=`rang`.`r_id`
WHERE `rang`.`r_libelle`="admin" AND ((NOW() - `user`.`u_date_naissance`)/365.25/24)>18
ORDER BY `message`.`m_date` DESC
LIMIT 5;
# Version complexe : les 5 derniers par utilisateur
SET @compteur=0;
SET @refPrecedente=0;

SELECT *, @compteur:=IF(`message`.`m_auteur_fk`!=@refPrecedente, 1, @compteur+1) AS cpt, @refPrecedente:=`message`.`m_auteur_fk`
FROM `message`
WHERE `message`.`m_auteur_fk` IN (
    SELECT `user`.`u_id`
    FROM `user`
    INNER JOIN `rang` ON `user`.`u_rang_fk`=`rang`.`r_id`
    WHERE `rang`.`r_libelle`="admin"
    AND (YEAR(CURDATE()) - YEAR(`user`.`u_date_naissance`))>18
    AND `message`.`m_auteur_fk`=`user`.`u_id`
)
HAVING cpt < 6
ORDER BY `message`.`m_auteur_fk` ASC, `cpt` ASC, `message`.`m_date` DESC;
#6
SELECT `message`.`m_contenu`, `user`.`u_login`, `message`.`m_conversation_fk`
FROM `message`
INNER JOIN `user` ON `message`.`m_auteur_fk`=`user`.`u_id`
WHERE (YEAR(CURDATE()) - YEAR(`user`.`u_date_naissance`)) BETWEEN 18 AND 30
ORDER BY `m_date` DESC
LIMIT 10;
#7
SELECT CONCAT(`message`.`m_contenu`, ' - ', `message`.`m_date`, ' - ',`user`.`u_prenom`, ' ',`user`.`u_nom`)
FROM `message`
INNER JOIN `user` ON `message`.`m_auteur_fk`=`user`.`u_id`
WHERE `message`.`m_conversation_fk`=9;
#8
SELECT DISTINCT `message`.`m_conversation_fk`
FROM `message`
WHERE `message`.`m_auteur_fk`=10 AND `message`.`m_date` BETWEEN "2010-12-31" AND "2016-01-01";
#9
SELECT DISTINCT `m_auteur_fk`, `u_login`
FROM `message`
INNER JOIN `user` ON `message`.`m_auteur_fk`=`user`.`u_id`
WHERE `m_conversation_fk` IN (
	SELECT DISTINCT `m_conversation_fk`
	FROM `message`
	WHERE `m_auteur_fk`=8
)
ORDER BY `u_login` ASC;
#10
# Modèle non restrictif : on affiche tous les messages de chaque utilisateur ... même des utilisateurs supprimés
SELECT `m_auteur_fk`, `m_conversation_fk`, COUNT( DISTINCT `m_id` )
FROM `message`
GROUP BY `m_auteur_fk`, `m_conversation_fk`;
# Modèle restrictif : on affiche uniquement les messages des utilisateurs qui n'ont pas été supprimés dans la table des utilisateurs (cf la condition WHERE)
# Avec des sous-requêtes
SELECT `m_auteur_fk`, `m_conversation_fk`, COUNT( DISTINCT `m_id` )
FROM `message`
WHERE `m_conversation_fk` IN (
    SELECT DISTINCT `c_id`
    FROM `conversation`
    ORDER BY `c_id` ASC
) AND `m_auteur_fk` IN (
    SELECT DISTINCT `u_id`
    FROM `user`
    ORDER BY `u_id` ASC
)
GROUP BY `m_auteur_fk`, `m_conversation_fk`;
# Avec des jointures
SELECT `m_auteur_fk`, `m_conversation_fk`, COUNT( DISTINCT `m_id` )
FROM `message`
JOIN `conversation` ON `message`.`m_conversation_fk`=`conversation`.`c_id`
JOIN `user` ON `message`.`m_auteur_fk`=`user`.`u_id`
GROUP BY `m_auteur_fk`, `m_conversation_fk`;
#11
SELECT *
FROM `message`
INNER JOIN `conversation` ON `message`.`m_conversation_fk`=`conversation`.`c_id`
WHERE `message`.`m_date`<`conversation`.`c_date`
ORDER BY `message`.`m_conversation_fk` ASC, `message`.`m_date` ASC;
#12
SELECT `u_id`
FROM `user`
WHERE `u_id` NOT IN (
	SELECT `m_auteur_fk`
    FROM `message`
    INNER JOIN `conversation` ON `message`.`m_conversation_fk`=`conversation`.`c_id`
    WHERE `conversation`.`c_termine`=0
);
#13
SELECT *
FROM `message`
INNER JOIN `user` ON `message`.`m_auteur_fk`=`user`.`u_id`
INNER JOIN `rang` ON `user`.`u_rang_fk`=`rang`.`r_id`
INNER JOIN `conversation` ON `message`.`m_conversation_fk`=`conversation`.`c_id`
WHERE `rang`.`r_libelle`="admin"
AND YEAR(`user`.`u_date_inscription`)="2010"
AND `conversation`.`c_termine`=0;
#14
# Avec LIKE
SELECT *
FROM `message`
INNER JOIN `user` ON `message`.`m_auteur_fk`=`user`.`u_id`
INNER JOIN `rang` ON `user`.`u_rang_fk`=`rang`.`r_id`
WHERE `rang`.`r_libelle`="none"
AND (YEAR(NOW()) - YEAR(`user`.`u_date_naissance`))<18
AND `m_contenu` LIKE "%o%o%o%"
LIMIT 5;
# Avec REGEXP
SELECT *
FROM `message`
INNER JOIN `user` ON `message`.`m_auteur_fk`=`user`.`u_id`
INNER JOIN `rang` ON `user`.`u_rang_fk`=`rang`.`r_id`
WHERE `rang`.`r_libelle`="none"
AND (YEAR(NOW()) - YEAR(`user`.`u_date_naissance`))<18
AND `m_contenu` REGEXP "(.*o.*){3}"
LIMIT 5;
#15
# Jeu de test :
# Liste des derniers messages de l'utilisateur 88 pour chaque conversation à laquelle il a participé
SELECT *
FROM `message`
WHERE `message`.`m_auteur_fk` = 88
GROUP BY `message`.`m_conversation_fk`
ORDER BY `message`.`m_auteur_fk` ASC, `message`.`m_conversation_fk` ASC, `message`.`m_date` DESC;
# Nombre de message  pour la conversation 4 après la date de dernier message de l'utilisateur 88
SELECT COUNT(*) FROM `message`
WHERE `m_conversation_fk` = 4
AND `m_date` > "2013-11-15 11:09:08";
# Requête pour l'utilisateur 88
SELECT *
FROM `message` m
WHERE m.`m_date` > (
    SELECT MAX(`m_date`)
    FROM `message`
    WHERE `message`.`m_auteur_fk` = 88
    AND `message`.`m_conversation_fk` = m.`m_conversation_fk`
)
ORDER BY m.`m_conversation_fk` ASC, m.`m_date` DESC;