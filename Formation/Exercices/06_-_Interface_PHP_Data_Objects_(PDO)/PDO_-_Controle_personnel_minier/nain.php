<?php
require( './ini.php' );

if( !( isset( $_GET['id'] ) && is_numeric( $_GET['id'] ) ) ) :
    header( 'Location:' . DOMAIN . '404.php' ); // On redirige vers la page d'erreur 404.
    exit;
else :
/**
 * On inclut les fichiers de configuration
**/
require( './common.php' );
/** **/
$_pdo = connectDB(); // On appelle la fonction de connexion

if( isset( $_POST['group'] ) && ( is_numeric( $_POST['group'] ) || ( is_null( $_POST['group'] ) || strtoupper( $_POST['group'] )=='NULL' ) ) ) :
    $_str_query = 'UPDATE `nain` SET `nain`.`n_groupe_fk`=' . ( is_null( $_POST['group'] ) || strtoupper( $_POST['group'] )=='NULL' ? 'NULL' : ':idgroup' ) . ' WHERE `nain`.`n_id`=:idnain'; // On définit la chaîne de caractères représentant la requête.
    $_arr_options = array(
        'idnain'    => array(
            'VAL'   => $_GET['id'],
            'TYPE'  => PDO::PARAM_INT
        )
    );
    if( !( is_null( $_POST['group'] ) || strtoupper( $_POST['group'] )=='NULL' ) ) :
        $_arr_options['idgroup'] = array(
            'VAL'   => $_POST['group'],
            'TYPE'  => PDO::PARAM_INT
        );
    endif;
    $_int_update = executeQuery( $_pdo, $_str_query, $_arr_options );
endif;

$_str_query = 'SELECT `nain`.`n_id` AS "ID", `nain`.`n_nom` AS "Nom", `nain`.`n_barbe` AS "Longueur de barbe", `ville`.`v_nom` AS "Originaire de", `ville`.`v_id` AS villeNaissanceID, `taverne`.`t_nom` AS "Boit dans", `taverne`.`t_id` AS taverneID, CONCAT(`groupe`.`g_debuttravail`, " à ", `groupe`.`g_fintravail`) AS "Travaille de", start.`v_nom` AS tunnelStart, start.`v_id` AS tunnelStartID, finish.`v_nom` AS tunnelFinish, finish.`v_id` AS tunnelFinishID, `nain`.`n_groupe_fk` AS "Membre du groupe"
FROM `nain`
JOIN `ville` ON `nain`.`n_ville_fk`=`ville`.`v_id`
LEFT JOIN `groupe` ON `nain`.`n_groupe_fk`=`groupe`.`g_id` 
LEFT JOIN `taverne` ON `groupe`.`g_taverne_fk`=`taverne`.`t_id`
LEFT JOIN `tunnel` ON `groupe`.`g_tunnel_fk`=`tunnel`.`t_id`
LEFT JOIN `ville` start ON `tunnel`.`t_villedepart_fk`=start.`v_id`
LEFT JOIN `ville` finish ON `tunnel`.`t_villearrivee_fk`=finish.`v_id`
WHERE `nain`.`n_id`=:idnain'; // On définit la chaîne de caractères représentant la requête.
$_arr_options = array(
    'idnain'    => array(
        'VAL'   => $_GET['id'],
        'TYPE'  => PDO::PARAM_INT
    )
);
$_arr_datas = executeQuery( $_pdo, $_str_query, $_arr_options );
if( count( $_arr_datas )<1 ) :
    header( 'Location:404.php' ); // On redirige vers la page d'erreur 404.
    exit;
endif;

$sitename = isset( $_arr_datas[0]['Nom'] ) ? $_arr_datas[0]['Nom'] : 'Nain';
include( './inc/head.php' ); // On inclut le fichier d'en-tête
?>

<section role="main" id="nains">
    <article role="article">
        <header class="header">
            <h1 class="title-lvl1">Tableau de bord</h1>
            <nav role="navigation">
                <ul class="menu-ariane">
                    <li><a href="<?php echo ( defined( 'DOMAIN' ) ? DOMAIN : '' ); ?>" title="">Tableau de bord</a></li>
                    <li><a href="<?php echo ( defined( 'DOMAIN' ) ? DOMAIN : '' ); ?>nains.php" title="">Nains</a></li>
                    <li><?php echo isset( $sitename ) ? $sitename : ''; ?></li>
                </ul>
            </nav>
        </header>
        <ul class="grid-wrapper widgets">
            <li class="grid12 x12 item before" data-id="<?php echo isset( $sitename ) ? $sitename : ''; ?>">
                <form action="<?php echo isset( $_GET['id'] ) ? '?id=' . $_GET['id'] : ''; ?>" data-role="formulaire" method="POST">
                <ul>
                    <?php
                    if( isset( $_arr_datas ) && is_array( $_arr_datas ) && count( $_arr_datas )>0 ) :
                        foreach( $_arr_datas[0] as $key=>$item ) :
                            switch( $key ) :
                                case 'Originaire de':
                    ?>
                    <li class="text-justify"><span class="lbl"><?php echo $key; ?></span> <span class="value"><a class="link" href="<?php echo ( defined( 'DOMAIN' ) ? DOMAIN : '' ); ?>ville.php?id=<?php echo $_arr_datas[0]['villeNaissanceID']; ?>" title=""><?php echo $item; ?></a></span></li>
                    <?php
                                    break;
                                case 'Boit dans':
                    ?>
                    <?php if( !( is_null( $item ) || strtoupper( $item )=='NULL' ) ) : ?><li class="text-justify"><span class="lbl"><?php echo $key; ?></span> <span class="value"><a class="link" href="<?php echo ( defined( 'DOMAIN' ) ? DOMAIN : '' ); ?>taverne.php?id=<?php echo $_arr_datas[0]['taverneID']; ?>" title=""><?php echo $item; ?></a></span></li><?php endif; ?>
                    <?php
                                    break;
                                case 'Travaille de':
                    ?>
                    <?php if( !( is_null( $item ) || strtoupper( $item )=='NULL' ) ) : ?><li class="text-justify"><span class="lbl"><?php echo $key; ?></span> <span class="value"><?php echo $item; ?><?php echo !( is_null( $_arr_datas[0]['tunnelStartID'] ) || strtoupper( $_arr_datas[0]['tunnelStartID'] )=='NULL' ) && !( is_null( $_arr_datas[0]['tunnelFinishID'] ) || strtoupper( $_arr_datas[0]['tunnelFinishID'] )=='NULL' ) ? '<br />dans le tunnel reliant <a class="link" href="' . ( defined( 'DOMAIN' ) ? DOMAIN : '' ) . 'ville.php?id=' . $_arr_datas[0]['tunnelStartID'] . '" title="">' . $_arr_datas[0]['tunnelStart'] . '</a> à <a class="link" href="' . ( defined( 'DOMAIN' ) ? DOMAIN : '' ) . 'ville.php?id=' . $_arr_datas[0]['tunnelFinishID'] . '" title="">' . $_arr_datas[0]['tunnelFinish'] . '</a>' : ''; ?></span></li><?php endif; ?>
                    <?php
                                    break;
                                case 'Membre du groupe':
                                    $_str_query = 'SELECT `g_id` FROM `groupe` ORDER BY `g_id` ASC'; // On définit la chaîne de caractères représentant la requête.
                                    $_arr_datas_secondary = executeQuery( $_pdo, $_str_query );

                                    if( isset( $_arr_datas_secondary ) && is_array( $_arr_datas_secondary ) && count( $_arr_datas_secondary )>0 ) :
                    ?>
                    <li class="text-justify">
                        <label class="lbl" for="list-group"><?php echo $key; ?></label>
                        <span class="value">
                            <select dir="rtl" id="list-group" name="group">
                                <option<?php echo isset( $_arr_datas[0]['Membre du groupe'] ) && ( is_null( $_arr_datas[0]['Membre du groupe'] ) || strtoupper( $_arr_datas[0]['Membre du groupe'] )=='NULL' ) ? ' selected="selected"' : ''; ?> value="NULL">En vacances</option>
                                <?php foreach( $_arr_datas_secondary as $item ) : ?>
                                <option<?php echo isset( $_arr_datas[0]['Membre du groupe'] ) && $_arr_datas[0]['Membre du groupe']==$item['g_id'] ? ' selected="selected"' : ''; ?> value="<?php echo $item['g_id']; ?>"><?php echo $item['g_id']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </span>
                    </li>
                    <?php
                                    endif;
                                    break;
                                case 'villeNaissanceID':
                                case 'taverneID':
                                case 'tunnelStartID':
                                case 'tunnelStart':
                                case 'tunnelFinishID':
                                case 'tunnelFinish':
                                    break;
                                default:
                    ?>
                    <li class="text-justify"><span class="lbl"><?php echo $key; ?></span> <span class="value"><?php echo $item; ?></span></li>
                    <?php
                            endswitch;
                        endforeach;
                    endif;
                    ?>
                    <li class="text-justify">
                        <?php
                        if( isset( $_int_update ) ) :
                            switch( $_int_update ) :
                                case false:
                                    echo '<span class="lbl alert-block warning">Aucune modification effectuée !</span>';
                                    break;
                                case true:
                                    echo '<span class="lbl alert-block ok">La modification s\'est bien effectuée !</span>';
                                    break;
                                default:
                                    echo '<span class="lbl alert-block error">Une erreur est survenue !</span>';
                            endswitch;
                        else : echo '<span class="lbl"></span>';
                        endif;
                        ?>
                        <span class="value"><input data-role="submit" type="submit" value="Changer de groupe" /></span>
                    </li>
                </ul>
                </form>
            </li>
        </ul>
    </article>
</section>

<?php include( './inc/foot.php' ); // On inclut le fichier de pied de page
endif;