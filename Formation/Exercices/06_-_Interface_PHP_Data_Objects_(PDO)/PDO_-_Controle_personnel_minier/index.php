<?php
/**
 * On inclut les fichiers de configuration
**/
require( './ini.php' );
require( './common.php' );
/** **/
$_pdo = connectDB(); // On appelle la fonction de connexion

include( './inc/head.php' ); // On inclut le fichier d'en-tête
?>

<section role="main" id="home">
    <article role="article">
        <header class="header">
            <h1 class="title-lvl1">Tableau de bord</h1>
        </header>
        <p>Ceci est une page bonus non optimisée car plusieurs requêtes pourraient être rassemblées et ainsi être plus économes en ressources.</p>
        <ul class="grid-wrapper widgets">
            <li class="grid12 x6 item before" data-id="nains">
                <ul>
                    <?php
                    $_str_query = 'SELECT COUNT(`n_id`) AS TotalNains FROM `nain`'; // On définit la chaîne de caractères représentant la requête.
                    $_arr_datas = executeQuery( $_pdo, $_str_query );

                    if( isset( $_arr_datas ) && is_array( $_arr_datas ) && count( $_arr_datas )>0 ) :
                    ?>
                    <li class="text-justify"><span class="lbl">Nombre total de nains</span> <span class="value"><?php echo $_arr_datas[0]['TotalNains']; ?></span></li>
                    <?php endif; ?>
                    <?php
                    $_str_query = 'SELECT COUNT(`n_id`) AS TotalVacances FROM `nain` WHERE `n_groupe_fk` IS NULL'; // On définit la chaîne de caractères représentant la requête.
                    $_arr_datas = executeQuery( $_pdo, $_str_query );

                    if( isset( $_arr_datas ) && is_array( $_arr_datas ) && count( $_arr_datas )>0 ) :
                    ?>
                    <li class="text-justify"><span class="lbl">Nombre de nains en vacances</span> <span class="value"><?php echo $_arr_datas[0]['TotalVacances']; ?></span></li>
                    <?php endif; ?>
                    <?php
                    $_str_query = 'SELECT AVG(`n_barbe`) AS MoyenneBarbes FROM `nain`'; // On définit la chaîne de caractères représentant la requête.
                    $_arr_datas = executeQuery( $_pdo, $_str_query );

                    if( isset( $_arr_datas ) && is_array( $_arr_datas ) && count( $_arr_datas )>0 ) :
                    ?>
                    <li class="text-justify"><span class="lbl">Longueur moyenne des barbes</span> <span class="value"><?php echo round( $_arr_datas[0]['MoyenneBarbes'], 3 ); ?></span></li>
                    <?php endif; ?>
                    <?php
                    $_str_query = 'SELECT `n_id`, `n_nom` FROM `nain` ORDER BY `n_nom` ASC'; // On définit la chaîne de caractères représentant la requête.
                    $_arr_datas = executeQuery( $_pdo, $_str_query );

                    if( isset( $_arr_datas ) && is_array( $_arr_datas ) && count( $_arr_datas )>0 ) :
                    ?>
                    <li class="text-justify">
                        <span class="lbl">Voir la fiche de</span>
                        <span class="value">
                            <ul class="list">
                                <li><span class="title">Choisissez un nain</span>
                                    <ul class="">
                                        <?php foreach( $_arr_datas as $item ) : ?>
                                        <li><a href="<?php echo ( defined( 'DOMAIN' ) ? DOMAIN : '' ); ?>nain.php?id=<?php echo $item['n_id']; ?>" title=""><?php echo $item['n_nom']; ?></a></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </li>
                            </ul>
                        </span>
                    </li>
                    <?php endif; ?>
                </ul>
            </li>
            <li class="grid12 x6 item before" data-id="groupes">
                <ul>
                    <?php
                    $_str_query = 'SELECT COUNT(`g_id`) AS TotalGroupes FROM `groupe`'; // On définit la chaîne de caractères représentant la requête.
                    $_arr_datas = executeQuery( $_pdo, $_str_query );

                    if( isset( $_arr_datas ) && is_array( $_arr_datas ) && count( $_arr_datas )>0 ) :
                    ?>
                    <li class="text-justify"><span class="lbl">Nombre total de groupes</span> <span class="value"><?php echo $_arr_datas[0]['TotalGroupes']; ?></span></li>
                    <?php endif; ?>
                    <?php
                    $_str_query = 'SELECT COUNT(DISTINCT `g_tunnel_fk`) AS TotalTravaux FROM `groupe`'; // On définit la chaîne de caractères représentant la requête.
                    $_arr_datas = executeQuery( $_pdo, $_str_query );

                    if( isset( $_arr_datas ) && is_array( $_arr_datas ) && count( $_arr_datas )>0 ) :
                    ?>
                    <li class="text-justify"><span class="lbl">Nombre de tunnels en travaux</span> <span class="value"><?php echo $_arr_datas[0]['TotalTravaux']; ?></span></li>
                    <?php endif; ?>
                    <?php
                    $_str_query = 'SELECT AVG( TotalNains ) AS MoyenneNains FROM ( SELECT COUNT(`n_id`) AS TotalNains FROM `nain` GROUP BY `n_groupe_fk` ) AS totaux'; // On définit la chaîne de caractères représentant la requête.
                    $_arr_datas = executeQuery( $_pdo, $_str_query );

                    if( isset( $_arr_datas ) && is_array( $_arr_datas ) && count( $_arr_datas )>0 ) :
                    ?>
                    <li class="text-justify"><span class="lbl">Nombre moyen de nains par groupe</span> <span class="value"><?php echo round( $_arr_datas[0]['MoyenneNains'], 3 ); ?></span></li>
                    <?php endif; ?>
                    <?php
                    $_str_query = 'SELECT `g_id` FROM `groupe` ORDER BY `g_id` ASC'; // On définit la chaîne de caractères représentant la requête.
                    $_arr_datas = executeQuery( $_pdo, $_str_query );

                    if( isset( $_arr_datas ) && is_array( $_arr_datas ) && count( $_arr_datas )>0 ) :
                    ?>
                    <li class="text-justify">
                        <span class="lbl">Voir la fiche de</span>
                        <span class="value">
                            <ul class="list">
                                <li><span class="title">Choisissez un groupe</span>
                                    <ul class="">
                                        <?php foreach( $_arr_datas as $item ) : ?>
                                        <li><a href="<?php echo ( defined( 'DOMAIN' ) ? DOMAIN : '' ); ?>groupe.php?id=<?php echo $item['g_id']; ?>" title=""><?php echo $item['g_id']; ?></a></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </li>
                            </ul>
                        </span>
                    </li>
                    <?php endif; ?>
                </ul>
            </li>
            <li class="grid12 x6 item before" data-id="tavernes">
                <ul>
                    <?php
                    $_str_query = 'SELECT COUNT(`t_id`) AS TotalTavernes FROM `taverne`'; // On définit la chaîne de caractères représentant la requête.
                    $_arr_datas = executeQuery( $_pdo, $_str_query );

                    if( isset( $_arr_datas ) && is_array( $_arr_datas ) && count( $_arr_datas )>0 ) :
                    ?>
                    <li class="text-justify"><span class="lbl">Nombre total de tavernes</span> <span class="value"><?php echo $_arr_datas[0]['TotalTavernes']; ?></span></li>
                    <?php endif; ?>
                    <?php
                    $_str_query = 'SELECT COUNT(DISTINCT `g_taverne_fk`) AS TotalOccupation FROM `groupe`'; // On définit la chaîne de caractères représentant la requête.
                    $_arr_datas = executeQuery( $_pdo, $_str_query );

                    if( isset( $_arr_datas ) && is_array( $_arr_datas ) && count( $_arr_datas )>0 ) :
                    ?>
                    <li class="text-justify"><span class="lbl">Nombre de tavernes occupées</span> <span class="value"><?php echo $_arr_datas[0]['TotalOccupation']; ?></span></li>
                    <?php endif; ?>
                    <?php
                    $_str_query = 'SELECT AVG( TotalNains ) AS MoyenneNains FROM ( SELECT COUNT(`n_id`) AS TotalNains FROM `nain` INNER JOIN `groupe` ON `nain`.`n_groupe_fk`=`groupe`.`g_id` RIGHT JOIN `taverne` ON `groupe`.`g_taverne_fk`=`taverne`.`t_id` GROUP BY `t_id` ) AS totaux'; // On définit la chaîne de caractères représentant la requête.
                    $_arr_datas = executeQuery( $_pdo, $_str_query );

                    if( isset( $_arr_datas ) && is_array( $_arr_datas ) && count( $_arr_datas )>0 ) :
                    ?>
                    <li class="text-justify"><span class="lbl">Nombre moyen de nains par tavernes</span> <span class="value"><?php echo round( $_arr_datas[0]['MoyenneNains'], 3 ); ?></span></li>
                    <?php endif; ?>
                    <?php
                    $_str_query = 'SELECT `t_id`, `t_nom` FROM `taverne` ORDER BY `t_nom` ASC'; // On définit la chaîne de caractères représentant la requête.
                    $_arr_datas = executeQuery( $_pdo, $_str_query );

                    if( isset( $_arr_datas ) && is_array( $_arr_datas ) && count( $_arr_datas )>0 ) :
                    ?>
                    <li class="text-justify">
                        <span class="lbl">Voir la fiche de</span>
                        <span class="value">
                            <ul class="list">
                                <li><span class="title">Choisissez une taverne</span>
                                    <ul class="">
                                        <?php foreach( $_arr_datas as $item ) : ?>
                                        <li><a href="<?php echo ( defined( 'DOMAIN' ) ? DOMAIN : '' ); ?>taverne.php?id=<?php echo $item['t_id']; ?>" title=""><?php echo $item['t_nom']; ?></a></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </li>
                            </ul>
                        </span>
                    </li>
                    <?php endif; ?>
                </ul>
            </li>
            <li class="grid12 x6 item before" data-id="villes">
                <ul>
                    <?php
                    $_str_query = 'SELECT COUNT(`v_id`) AS TotalVilles FROM `ville`'; // On définit la chaîne de caractères représentant la requête.
                    $_arr_datas = executeQuery( $_pdo, $_str_query );

                    if( isset( $_arr_datas ) && is_array( $_arr_datas ) && count( $_arr_datas )>0 ) :
                    ?>
                    <li class="text-justify"><span class="lbl">Nombre total de villes</span> <span class="value"><?php echo $_arr_datas[0]['TotalVilles']; ?></span></li>
                    <?php endif; ?>
                    <?php
                    $_str_query = 'SELECT AVG(`v_superficie`) AS MoyenneSuperficie FROM `ville`'; // On définit la chaîne de caractères représentant la requête.
                    $_arr_datas = executeQuery( $_pdo, $_str_query );

                    if( isset( $_arr_datas ) && is_array( $_arr_datas ) && count( $_arr_datas )>0 ) :
                    ?>
                    <li class="text-justify"><span class="lbl">Superficie moyenne des villes</span> <span class="value"><?php echo round( $_arr_datas[0]['MoyenneSuperficie'], 2 ); ?></span></li>
                    <?php endif; ?>
                    <?php
                    $_str_query = 'SELECT COUNT(DISTINCT `v_id`) AS TotalVilles FROM `ville` INNER JOIN `taverne` ON `ville`.`v_id`=`taverne`.`t_ville_fk`'; // On définit la chaîne de caractères représentant la requête.
                    $_arr_datas = executeQuery( $_pdo, $_str_query );

                    if( isset( $_arr_datas ) && is_array( $_arr_datas ) && count( $_arr_datas )>0 ) :
                    ?>
                    <li class="text-justify"><span class="lbl">Nombre de villes où se trouvent une taverne</span> <span class="value"><?php echo $_arr_datas[0]['TotalVilles']; ?></span></li>
                    <?php endif; ?>
                    <?php
                    $_str_query = 'SELECT `v_id`, `v_nom` FROM `ville` ORDER BY `v_nom` ASC'; // On définit la chaîne de caractères représentant la requête.
                    $_arr_datas = executeQuery( $_pdo, $_str_query );

                    if( isset( $_arr_datas ) && is_array( $_arr_datas ) && count( $_arr_datas )>0 ) :
                    ?>
                    <li class="text-justify">
                        <span class="lbl">Voir la fiche de</span>
                        <span class="value">
                            <ul class="list">
                                <li><span class="title">Choisissez une ville</span>
                                    <ul class="">
                                        <?php foreach( $_arr_datas as $item ) : ?>
                                        <li><a href="<?php echo ( defined( 'DOMAIN' ) ? DOMAIN : '' ); ?>ville.php?id=<?php echo $item['v_id']; ?>" title=""><?php echo $item['v_nom']; ?></a></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </li>
                            </ul>
                        </span>
                    </li>
                    <?php endif; ?>
                </ul>
            </li>
        </ul>
    </article>
</section>

<?php include( './inc/foot.php' ); // On inclut le fichier de pied de page