Le groupe 5 n'a pas encore de taverne attribuée. Trouver les taverne idéales, c'est à dire les taverne dans la ville de départ de leur tunnel, ayant assez de chambres pour les accueillir.

SELECT `taverne`.*, (`taverne`.`t_chambres` - COUNT(`nain`.`n_id`)) AS libres
FROM `groupe` AS Orig INNER JOIN `tunnel` ON Orig.`g_tunnel_fk` = `tunnel`.`t_id`
INNER JOIN `taverne` ON `t_villedepart_fk` = `t_ville_fk` OR `t_progres` >= 100 AND `t_villearrivee_fk` = `t_ville_fk`
LEFT JOIN `groupe` ON `taverne`.`t_id` = `groupe`.`g_taverne_fk`
LEFT JOIN `nain` ON `groupe`.`g_id` = `nain`.`n_groupe_fk`
WHERE Orig.`g_id` = 5
GROUP BY `taverne`.`t_id`
HAVING libres >= (SELECT COUNT(`nain`.`n_id`) FROM `nain` WHERE `nain`.`n_groupe_fk` = 5)