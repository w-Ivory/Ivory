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
if( ( isset( $_POST['tavern'] ) && ( is_numeric( $_POST['tavern'] ) || ( is_null( $_POST['tavern'] ) || strtoupper( $_POST['tavern'] )=='NULL' ) ) ) && ( isset( $_POST['tunnel'] ) && ( is_numeric( $_POST['tunnel'] ) || ( is_null( $_POST['tunnel'] ) || strtoupper( $_POST['tunnel'] )=='NULL' ) ) ) && isset( $_POST['hStart'] ) && ( validateDate( $_POST['hStart'], 'H:i:s' ) || validateDate( $_POST['hStart'], 'H:i' ) ) && isset( $_POST['hFinish'] ) && ( validateDate( $_POST['hFinish'], 'H:i:s' ) || validateDate( $_POST['hFinish'], 'H:i' ) ) ) :

    $_bool_tavern = true;
    if( is_numeric( $_POST['tavern'] ) ) :
        $_str_query = 'SELECT `taverne`.`t_nom`, ( `taverne`.`t_chambres` - COUNT( DISTINCT `n_id` ) ) AS "Taverne(s) recommandée(s)"
        FROM `taverne`
        LEFT JOIN `groupe` ON `taverne`.`t_id`=`groupe`.`g_taverne_fk`
        LEFT JOIN `nain` ON `groupe`.`g_id`=`nain`.`n_groupe_fk`
        WHERE `taverne`.`t_id`=:idtavern
        GROUP BY `taverne`.`t_id`
        HAVING `Taverne(s) recommandée(s)`>(
            SELECT COUNT( DISTINCT `n_id` )
            FROM `nain`
            WHERE `nain`.`n_groupe_fk`=:idgroup
        )'; // On définit la chaîne de caractères représentant la requête.
        $_arr_options = array(
            'idgroup'   => array(
                'VAL'   => $_GET['id'],
                'TYPE'  => PDO::PARAM_INT
            ),
            'idtavern'  => array(
                'VAL'   => $_POST['tavern'],
                'TYPE'  => PDO::PARAM_INT
            )
        );
        $_arr_datas = executeQuery( $_pdo, $_str_query, $_arr_options );
        if( count( $_arr_datas )==0 ) $_bool_tavern = false;
    endif;


    if( $_bool_tavern ) :
        $_str_query = 'UPDATE `groupe` SET `groupe`.`g_debuttravail`=:hStart, `groupe`.`g_fintravail`=:hFinish, `groupe`.`g_taverne_fk`=' . ( is_null( $_POST['tavern'] ) || strtoupper( $_POST['tavern'] )=='NULL' ? 'NULL' : ':idtavern' ) . ', `groupe`.`g_tunnel_fk`=' . ( is_null( $_POST['tunnel'] ) || strtoupper( $_POST['tunnel'] )=='NULL' ? 'NULL' : ':idtunnel' ) . ' WHERE `groupe`.`g_id`=:idgroup'; // On définit la chaîne de caractères représentant la requête.
        $_arr_options = array(
            'idgroup'   => array(
                'VAL'   => $_GET['id'],
                'TYPE'  => PDO::PARAM_INT
            ),
            'hStart'    => array(
                'VAL'   => $_POST['hStart'],
                'TYPE'  => PDO::PARAM_STR
            ),
            'hFinish'    => array(
                'VAL'   => $_POST['hFinish'],
                'TYPE'  => PDO::PARAM_STR
            )
        );
        if( !( is_null( $_POST['tunnel'] ) || strtoupper( $_POST['tunnel'] )=='NULL' ) ) :
            $_arr_options['idtunnel'] = array(
                'VAL'   => $_POST['tunnel'],
                'TYPE'  => PDO::PARAM_INT
            );
        endif;
        if( !( is_null( $_POST['tavern'] ) || strtoupper( $_POST['tavern'] )=='NULL' ) ) :
            $_arr_options['idtavern'] = array(
                'VAL'   => $_POST['tavern'],
                'TYPE'  => PDO::PARAM_INT
            );
        endif;
        $_int_update = executeQuery( $_pdo, $_str_query, $_arr_options );
        if( $_int_update===false ) : $_int_update = 'error';
        endif;
    else : $_int_update = 'taverne';
    endif;
endif;

$_str_query = 'SELECT `groupe`.`g_id` AS "ID", CONCAT( `groupe`.`g_debuttravail`, "-", `groupe`.`g_fintravail` ) AS "Horaires de travail", `taverne`.`t_id` AS "taverneID", `tunnel`.`t_id` AS "tunnelID", `tunnel`.`t_progres` AS "tunnel%",
GROUP_CONCAT( DISTINCT CONCAT( `nain`.`n_id`, ",", `nain`.`n_nom` ) ORDER BY `nain`.`n_nom` ASC SEPARATOR ";") AS "Nains du groupe"
FROM `groupe`
LEFT JOIN `nain` ON `groupe`.`g_id`=`nain`.`n_groupe_fk`
LEFT JOIN `taverne` ON `groupe`.`g_taverne_fk`=`taverne`.`t_id`
LEFT JOIN `tunnel` ON `groupe`.`g_tunnel_fk`=`tunnel`.`t_id`
LEFT JOIN `ville` startCity ON `tunnel`.`t_villearrivee_fk`=startCity.`v_id`
LEFT JOIN `ville` finishCity ON `tunnel`.`t_villedepart_fk`=finishCity.`v_id`
WHERE `groupe`.`g_id`=:idgroupe
GROUP BY `groupe`.`g_id`'; // On définit la chaîne de caractères représentant la requête.
$_arr_options = array(
    'idgroupe'  => array(
        'VAL'   => $_GET['id'],
        'TYPE'  => PDO::PARAM_INT
    )
);
$_arr_datas = executeQuery( $_pdo, $_str_query, $_arr_options );
if( count( $_arr_datas )<1 ) :
    header( 'Location:404.php' ); // On redirige vers la page d'erreur 404.
    exit;
endif;

$sitename = isset( $_arr_datas[0]['ID'] ) ? 'Groupe ' . $_arr_datas[0]['ID'] : 'Groupe';
include( './inc/head.php' ); // On inclut le fichier d'en-tête
?>

<section role="main" id="groupes">
    <article role="article">
        <header class="header">
            <h1 class="title-lvl1">Tableau de bord</h1>
            <nav role="navigation">
                <ul class="menu-ariane">
                    <li><a href="<?php echo ( defined( 'DOMAIN' ) ? DOMAIN : '' ); ?>" title="">Tableau de bord</a></li>
                    <li><a href="<?php echo ( defined( 'DOMAIN' ) ? DOMAIN : '' ); ?>groupes.php" title="">Groupes</a></li>
                    <li><?php echo isset( $sitename ) ? $sitename : ''; ?></li>
                </ul>
            </nav>
        </header>
        <form action="<?php echo isset( $_GET['id'] ) ? '?id=' . $_GET['id'] : ''; ?>" data-role="formulaire" method="POST">
        <ul class="grid-wrapper widgets">
            <li class="grid12 x6 item before" data-id="<?php echo isset( $sitename ) ? $sitename : ''; ?>">
                <ul>
                    <?php
                    if( isset( $_arr_datas ) && is_array( $_arr_datas ) && count( $_arr_datas )>0 ) :
                        foreach( $_arr_datas[0] as $key=>$item ) :
                            switch( $key ) :
                                case 'Nains du groupe':
                                case 'taverneID':
                                case 'tunnelID':
                                case 'tunnel%':
                                case 'Reliant':
                                    break;
                                case 'Horaires de travail':
                                    $horaires = explode( '-', $item );
                    ?>
                    <li class="text-justify"><span class="lbl"><?php echo $key; ?></span> <span class="value">de <input name="hStart" step="1" type="time" value="<?php echo $horaires[0]; ?>" /> à <input name="hFinish" step="1" type="time" value="<?php echo $horaires[1]; ?>" /></span></li>
                    <?php
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
            <li class="grid12 x6 item before" data-id="Affectations">
                <ul>
                    <?php
                    if( isset( $_arr_datas ) && is_array( $_arr_datas ) && count( $_arr_datas )>0 ) :
                        foreach( $_arr_datas[0] as $key=>$item ) :
                            switch( $key ) :
                                case 'taverneID':
                                    $_str_query = 'SELECT `t_id`, `t_nom` FROM `taverne` ORDER BY `t_nom` ASC'; // On définit la chaîne de caractères représentant la requête.
                                    $_arr_datas_secondary = executeQuery( $_pdo, $_str_query );

                                    if( isset( $_arr_datas_secondary ) && is_array( $_arr_datas_secondary ) && count( $_arr_datas_secondary )>0 ) :
                    ?>
                    <li class="text-justify">
                        <label class="lbl" for="list-tavern">QG à la taverne</label>
                        <span class="value">
                            <select dir="rtl" id="list-tavern" name="tavern">
                                <option<?php echo isset( $_arr_datas[0]['taverneID'] ) && ( is_null( $_arr_datas[0]['taverneID'] ) || strtoupper( $_arr_datas[0]['taverneID'] )=='NULL' ) ? ' selected="selected"' : ''; ?> value="NULL">Aucune</option>
                    <?php
                                        foreach( $_arr_datas_secondary as $item ) :
                    ?>
                                <option<?php echo isset( $_arr_datas[0]['taverneID'] ) && $_arr_datas[0]['taverneID']==$item['t_id'] ? ' selected="selected"' : ''; ?> value="<?php echo $item['t_id']; ?>"><?php echo $item['t_nom']; ?></option>
                    <?php
                                        endforeach;
                    ?>
                            </select>
                        </span>
                    </li>
                    <?php
                                        if( is_null( $_arr_datas[0]['taverneID'] ) || strtoupper( $_arr_datas[0]['taverneID'] )=='NULL' ) :
                                            $_str_query = 'SELECT `taverne`.`t_id` AS "ID", `taverne`.`t_nom` AS "Nom", ( `taverne`.`t_chambres` - COUNT( DISTINCT `n_id` ) ) AS chambresLibres,`taverne`.`t_ville_fk`,`tunnel`.`t_villedepart_fk`
                                            FROM `taverne`
                                            INNER JOIN `ville` ON `taverne`.`t_ville_fk`=`ville`.`v_id`
                                            INNER JOIN `tunnel` ON `ville`.`v_id`=`tunnel`.`t_villedepart_fk`
                                            INNER JOIN `groupe` ON `tunnel`.`t_id`=`groupe`.`g_tunnel_fk`
                                            INNER JOIN `nain` ON `groupe`.`g_id`=`nain`.`n_groupe_fk`
                                            WHERE `groupe`.`g_id`=:idgroup
                                            GROUP BY `taverne`.`t_id`
                                            HAVING chambresLibres>(
                                                SELECT COUNT( DISTINCT `n_id` )
                                                FROM `nain`
                                                WHERE `nain`.`n_groupe_fk`=:idgroup
                                            )'; // On définit la chaîne de caractères représentant la requête.
                                            $_arr_options = array(
                                                'idgroup'    => array(
                                                    'VAL'   => $_GET['id'],
                                                    'TYPE'  => PDO::PARAM_INT
                                                )
                                            );
                                            $_arr_datas_secondary = executeQuery( $_pdo, $_str_query, $_arr_options );

                                            if( isset( $_arr_datas_secondary ) && is_array( $_arr_datas_secondary ) && count( $_arr_datas_secondary )>0 ) :
                    ?>
                    <li class="text-justify">
                        <label class="lbl" for="list-tavern">Taverne(s) recommandée(s)</label>
                        <span class="value"></span>
                    </li>
                    <?php
                                                foreach( $_arr_datas_secondary as $item ) :
                    ?>
                    <li style="display:inline-block;vertical-align:top;"><a class="link" href="<?php echo ( defined( 'DOMAIN' ) ? DOMAIN : '' ); ?>taverne.php?id=<?php echo $item['ID']; ?>" title=""><?php echo $item['Nom']; ?></a></li>
                    <?php
                                                endforeach;
                                            endif;
                                        endif;
                                    endif;
                                    break;
                                case 'tunnelID':
                                    $_str_query = 'SELECT `t_id`, CONCAT( startCity.`v_nom`, " à ", finishCity.`v_nom` ) AS "Reliant"
                                    FROM `tunnel`
                                    LEFT JOIN `ville` startCity ON `tunnel`.`t_villedepart_fk`=startCity.`v_id`
                                    LEFT JOIN `ville` finishCity ON `tunnel`.`t_villearrivee_fk`=finishCity.`v_id`
                                    ORDER BY `t_id` ASC'; // On définit la chaîne de caractères représentant la requête.
                                    $_arr_datas_secondary = executeQuery( $_pdo, $_str_query );

                                    if( isset( $_arr_datas_secondary ) && is_array( $_arr_datas_secondary ) && count( $_arr_datas_secondary )>0 ) :
                    ?>
                    <li class="text-justify">
                        <label class="lbl" for="list-tunnel"><?php echo $_arr_datas[0]['tunnel%']==100 ? 'Entretient' : 'Creuse'; ?> le tunnel reliant</label>
                        <span class="value">
                            <select dir="rtl" id="list-tunnel" name="tunnel">
                                <option<?php echo isset( $_arr_datas[0]['tunnelID'] ) && ( is_null( $_arr_datas[0]['tunnelID'] ) || strtoupper( $_arr_datas[0]['tunnelID'] )=='NULL' ) ? ' selected="selected"' : ''; ?> value="NULL">Aucun</option>
                                <?php foreach( $_arr_datas_secondary as $item ) : ?>
                                <option<?php echo isset( $_arr_datas[0]['tunnelID'] ) && $_arr_datas[0]['tunnelID']==$item['t_id'] ? ' selected="selected"' : ''; ?> value="<?php echo $item['t_id']; ?>"><?php echo $item['Reliant']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </span>
                    </li>
                    <?php
                                    endif;
                                    break;
                            endswitch;
                        endforeach;
                    endif;
                    ?>
                </ul>
            </li>
        </ul>
        <ul class="grid-wrapper widgets">
            <li class="grid12 x12 item">
                <ul>
                    <li class="text-justify">
                        <?php
                        if( isset( $_int_update ) ) :
                            if( $_int_update===true ) : echo '<span class="lbl alert-block ok">La modification s\'est bien effectuée !</span>';
                            elseif( $_int_update===false ) : echo '<span class="lbl alert-block warning">Aucune modification effectuée !</span>';
                            elseif( $_int_update==='taverne' ) : echo '<span class="lbl alert-block warning">La taverne choisie ne possède pas assez de chambres libres !<br />Aucune modification effectuée !</span>';
                            else : echo '<span class="lbl alert-block error">Une erreur est survenue !</span>';
                            endif;
                        else : echo '<span class="lbl"></span>';
                        endif;
                        ?>
                        <span class="value"><input data-role="submit" type="submit" value="Modifier" /></span>
                    </li>
                </ul>
            </li>
        </ul>
        </form>
        <ul class="grid-wrapper widgets">
            <li class="grid12 x12 item before" data-id="Nains du <?php echo isset( $sitename ) ? $sitename : ''; ?>">
                <ul>
                    <?php
                    if( isset( $_arr_datas ) && is_array( $_arr_datas ) && count( $_arr_datas )>0 ) :
                        foreach( $_arr_datas[0] as $key=>$item ) :
                            switch( $key ) :
                                case 'Nains du groupe':
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
    </article>
</section>

<?php include( './inc/foot.php' ); // On inclut le fichier de pied de page
endif;