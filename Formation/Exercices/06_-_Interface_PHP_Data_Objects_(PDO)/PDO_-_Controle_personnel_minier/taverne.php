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

$_str_query = 'SELECT `taverne`.`t_id` AS "ID", `taverne`.`t_nom` AS "Nom", `ville`.`v_id` AS "villeID", `ville`.`v_nom` AS "Ville", CONCAT( "Blonde:", `taverne`.`t_blonde`, ";", "Brune:", `taverne`.`t_brune`, ";", "Rousse:", `taverne`.`t_rousse` ) AS "Bières servies", CONCAT( `taverne`.`t_chambres`, " dont ", (`taverne`.`t_chambres` - COUNT( DISTINCT `n_id` ) ), " libres" ) AS "Nombre de chambres"
FROM `taverne`
INNER JOIN `ville` ON `taverne`.`t_ville_fk`=`ville`.`v_id`
LEFT JOIN `groupe` ON `taverne`.`t_id`=`groupe`.`g_taverne_fk`
LEFT JOIN `nain` ON `groupe`.`g_id`=`nain`.`n_groupe_fk`
WHERE `taverne`.`t_id`=:idtavern
GROUP BY `taverne`.`t_id`'; // On définit la chaîne de caractères représentant la requête.
$_arr_options = array(
    'idtavern'  => array(
        'VAL'   => $_GET['id'],
        'TYPE'  => PDO::PARAM_INT
    )
);
$_arr_datas = executeQuery( $_pdo, $_str_query, $_arr_options );
if( count( $_arr_datas )<1 ) :
    header( 'Location:404.php' ); // On redirige vers la page d'erreur 404.
    exit;
endif;

$sitename = isset( $_arr_datas[0]['Nom'] ) ? $_arr_datas[0]['Nom'] : 'Taverne';
include( './inc/head.php' ); // On inclut le fichier d'en-tête
?>

<section role="main" id="tavernes">
    <article role="article">
        <header class="header">
            <h1 class="title-lvl1">Tableau de bord</h1>
            <nav role="navigation">
                <ul class="menu-ariane">
                    <li><a href="<?php echo ( defined( 'DOMAIN' ) ? DOMAIN : '' ); ?>" title="">Tableau de bord</a></li>
                    <li><a href="<?php echo ( defined( 'DOMAIN' ) ? DOMAIN : '' ); ?>tavernes.php" title="">Tavernes</a></li>
                    <li><?php echo isset( $sitename ) ? $sitename : ''; ?></li>
                </ul>
            </nav>
        </header>
        <ul class="grid-wrapper widgets">
            <li class="grid12 x12 item before" data-id="<?php echo isset( $sitename ) ? $sitename : ''; ?>">
                <ul>
                    <?php
                    if( isset( $_arr_datas ) && is_array( $_arr_datas ) && count( $_arr_datas )>0 ) :
                        foreach( $_arr_datas[0] as $key=>$item ) :
                            switch( $key ) :
                                case 'Bières servies':
                    ?>
                    <li class="text-justify"><span class="lbl"><?php echo $key; ?></span> <span class="value">
                    <?php
                    foreach( explode( ';', $item ) as $bieres ) :
                        $biere = explode( ':', $bieres );
                        if( $biere[1] ) $_arr_biers[] = $biere[0];
                    endforeach;
                    echo implode( ', ', $_arr_biers );
                    ?>
                    </span></li>
                    <?php
                                    break;
                                case 'Ville':
                    ?>
                    <li class="text-justify"><span class="lbl"><?php echo $key; ?></span> <span class="value"><a class="link" href="<?php echo ( defined( 'DOMAIN' ) ? DOMAIN : '' ); ?>ville.php?id=<?php echo $_arr_datas[0]['villeID']; ?>" title=""><?php echo $item; ?></a></span></li>
                    <?php
                                    break;
                                case 'villeID':
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
        </ul>
    </article>
</section>

<?php include( './inc/foot.php' ); // On inclut le fichier de pied de page
endif;