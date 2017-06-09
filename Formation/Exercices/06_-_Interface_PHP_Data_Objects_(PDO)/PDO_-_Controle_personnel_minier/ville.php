<?php
if( !( isset( $_GET['id'] ) && is_numeric( $_GET['id'] ) ) ) :
    header( 'Location:404.php' ); // On redirige vers la page d'erreur 404.
    exit;
else :
/**
 * On inclut les fichiers de configuration
**/
require( './ini.php' );
require( './common.php' );
/** **/
$_pdo = connectDB(); // On appelle la fonction de connexion

$_str_query = 'SELECT `ville`.`v_id` AS "ID", `ville`.`v_nom` AS "Nom", `ville`.`v_superficie` AS "Superficie",
GROUP_CONCAT( DISTINCT CONCAT( `nain`.`n_id`, ",", `nain`.`n_nom` ) ORDER BY `nain`.`n_nom` ASC SEPARATOR ";") AS "Nains originaires de ",
GROUP_CONCAT( DISTINCT CONCAT( `taverne`.`t_id`, ",", `taverne`.`t_nom` ) ORDER BY `taverne`.`t_nom` ASC SEPARATOR ";") AS "Tavernes se trouvant à ",
GROUP_CONCAT( DISTINCT CONCAT( start.`v_id`, ",", start.`v_nom`, ",", tunnelStart.`t_progres` ) ORDER BY tunnelStart.`t_progres` DESC SEPARATOR ";") AS "Reliant ",
GROUP_CONCAT( DISTINCT CONCAT( finish.`v_id`, ",", finish.`v_nom`, ",", tunnelFinish.`t_progres` ) ORDER BY tunnelFinish.`t_progres` DESC SEPARATOR ";") AS "Depuis "
FROM `ville`
LEFT JOIN `nain` ON `ville`.`v_id`=`nain`.`n_ville_fk`
LEFT JOIN `taverne` ON `ville`.`v_id`=`taverne`.`t_ville_fk`
LEFT JOIN `tunnel` tunnelStart ON `ville`.`v_id`=tunnelStart.`t_villedepart_fk`
LEFT JOIN `ville` start ON tunnelStart.`t_villearrivee_fk`=start.`v_id`
LEFT JOIN `tunnel` tunnelFinish ON `ville`.`v_id`=tunnelFinish.`t_villearrivee_fk`
LEFT JOIN `ville` finish ON tunnelFinish.`t_villedepart_fk`=finish.`v_id`
WHERE `ville`.`v_id`=:idville
GROUP BY `ville`.`v_id`'; // On définit la chaîne de caractères représentant la requête.
$_arr_options = array(
    'idville'   => array(
        'VAL'   => $_GET['id'],
        'TYPE'  => PDO::PARAM_INT
    )
);
$_arr_datas = executeQuery( $_pdo, $_str_query, $_arr_options );
if( count( $_arr_datas )<1 ) :
    header( 'Location:404.php' ); // On redirige vers la page d'erreur 404.
    exit;
endif;

$sitename = isset( $_arr_datas[0]['Nom'] ) ? $_arr_datas[0]['Nom'] : 'Ville';
include( './inc/head.php' ); // On inclut le fichier d'en-tête
?>

<section role="main" id="villes">
    <article role="article">
        <header class="header">
            <h1 class="title-lvl1">Tableau de bord</h1>
            <nav role="navigation">
                <ul class="menu-ariane">
                    <li><a href="<?php echo ( defined( 'DOMAIN' ) ? DOMAIN : '' ); ?>" title="">Tableau de bord</a></li>
                    <li><a href="<?php echo ( defined( 'DOMAIN' ) ? DOMAIN : '' ); ?>villes.php" title="">Ville</a></li>
                    <li><?php echo isset( $sitename ) ? $sitename : ''; ?></li>
                </ul>
            </nav>
        </header>
        <ul class="grid-wrapper widgets">
            <li class="grid12 x6 item before" data-id="<?php echo isset( $sitename ) ? $sitename : ''; ?>">
                <ul>
                    <?php
                    if( isset( $_arr_datas ) && is_array( $_arr_datas ) && count( $_arr_datas )>0 ) :
                        foreach( $_arr_datas[0] as $key=>$item ) :
                            switch( $key ) :
                                case 'Nains originaires de ':
                                case 'Tavernes se trouvant à ':
                                case 'Depuis ':
                                case 'Reliant ':
                                    break;
                                default:
                    ?>
                    <li class="text-justify"><span class="lbl"><?php echo $key; ?></span> <span class="value"><?php echo $item; ?></span></li>
                    <?php
                            endswitch;
                        endforeach;
                    endif;
                    ?>
                </ul>
            </li>
            <li class="grid12 x6 item before" data-id="Reliée à">
                <ul>
                    <?php
                    if( isset( $_arr_datas ) && is_array( $_arr_datas ) && count( $_arr_datas )>0 ) :
                        foreach( $_arr_datas[0] as $key=>$item ) :
                            switch( $key ) :
                                case 'Depuis ':
                                case 'Reliant ':
                                    foreach( explode( ';', $item ) as $tunnel ) : $tunnel = explode( ',', $tunnel );
                    ?>
                    <li class="text-justify"><span class="lbl"><a class="link" href="<?php echo ( defined( 'DOMAIN' ) ? DOMAIN : '' ); ?>ville.php?id=<?php echo $tunnel[0]; ?>" title=""><?php echo $tunnel[1]; ?></a></span> <span class="value"><?php echo $tunnel[2]==100 ? 'Ouvert' : 'Creusé à : ' . $tunnel[2] . '%'; ?></span></li>
                    <?php
                                    endforeach;
                                    break;
                            endswitch;
                        endforeach;
                    endif;
                    ?>
                </ul>
            </li>
        </ul>
        <ul class="grid-wrapper widgets">
            <li class="grid12 x12 item before" data-id="Nains originaires de <?php echo isset( $sitename ) ? $sitename : ''; ?>">
                <ul>
                    <?php
                    if( isset( $_arr_datas ) && is_array( $_arr_datas ) && count( $_arr_datas )>0 ) :
                        foreach( $_arr_datas[0] as $key=>$item ) :
                            switch( $key ) :
                                case 'Nains originaires de ':
                                    foreach( explode( ';', $item ) as $nain ) : $nain = explode( ',', $nain );
                    ?>
                    <li style="display:inline-block;vertical-align:top;"><a class="link" href="<?php echo ( defined( 'DOMAIN' ) ? DOMAIN : '' ); ?>nain.php?id=<?php echo $nain[0]; ?>" title=""><?php echo $nain[1]; ?></a></li>
                    <?php
                                    endforeach;
                                    break;
                            endswitch;
                        endforeach;
                    endif;
                    ?>
                </ul>
            </li>
        </ul>
        <ul class="grid-wrapper widgets">
            <li class="grid12 x12 item before" data-id="Tavernes se trouvant à <?php echo isset( $sitename ) ? $sitename : ''; ?>">
                <ul>
                    <?php
                    if( isset( $_arr_datas ) && is_array( $_arr_datas ) && count( $_arr_datas )>0 ) :
                        foreach( $_arr_datas[0] as $key=>$item ) :
                            switch( $key ) :
                                case 'Tavernes se trouvant à ':
                                    foreach( explode( ';', $item ) as $taverne ) : $taverne = explode( ',', $taverne );
                    ?>
                    <li style="display:inline-block;vertical-align:top;"><a class="link" href="<?php echo ( defined( 'DOMAIN' ) ? DOMAIN : '' ); ?>taverne.php?id=<?php echo $taverne[0]; ?>" title=""><?php echo $taverne[1]; ?></a></li>
                    <?php
                                    endforeach;
                                    break;
                            endswitch;
                        endforeach;
                    endif;
                    ?>
                </ul>
            </li>
        </ul>
    </article>
</section>

<?php include( './inc/foot.php' ); // On inclut le fichier de pied de page
endif;