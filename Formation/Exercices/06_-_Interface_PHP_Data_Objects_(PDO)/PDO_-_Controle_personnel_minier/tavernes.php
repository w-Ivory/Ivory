<?php
/**
 * On inclut les fichiers de configuration
**/
require( './ini.php' );
require( './common.php' );
/** **/
$_pdo = connectDB(); // On appelle la fonction de connexion

$sitename = 'Tavernes';
include( './inc/head.php' ); // On inclut le fichier d'en-tête
?>

<section role="main" id="tavernes">
    <article role="article">
        <header class="header">
            <h1 class="title-lvl1">Tableau de bord</h1>
            <nav role="navigation">
                <ul class="menu-ariane">
                    <li><a href="<?php echo ( defined( 'DOMAIN' ) ? DOMAIN : '' ); ?>" title="">Tableau de bord</a></li>
                    <li><?php echo isset( $sitename ) ? $sitename : ''; ?></li>
                </ul>
            </nav>
        </header>
        <ul class="grid-wrapper widgets">
            <li class="grid12 x12 item before" data-id="tavernes">
                <?php
                $_str_query = 'SELECT `taverne`.`t_id` AS "ID", `taverne`.`t_nom` AS "Nom", `ville`.`v_nom` AS "Ville"
                FROM `taverne`
                INNER JOIN `ville` ON `taverne`.`t_ville_fk`=`ville`.`v_id`
                ORDER BY `taverne`.`t_nom` ASC'; // On définit la chaîne de caractères représentant la requête.
                $_arr_datas = executeQuery( $_pdo, $_str_query );

                if( isset( $_arr_datas ) && is_array( $_arr_datas ) && count( $_arr_datas )>0 ) :
                ?>
                <div class="table">
                    <div class="thead">
                        <div class="tr">
                            <?php foreach( $_arr_datas[0] as $key=>$item ) : ?>
                            <div class="th"><?php echo $key; ?></div>
                            <?php endforeach; ?>
                            <div class="td"></div>
                        </div>
                    </div>
                    <div class="tbody">
                        <?php foreach( $_arr_datas as $item ) : ?>
                        <div class="tr">
                            <?php foreach( $item as $data ) : ?>
                            <div class="td"><?php echo $data; ?></div>
                            <?php endforeach; ?>
                            <div class="td"><a class="link" href="<?php echo ( defined( 'DOMAIN' ) ? DOMAIN : '' ); ?>taverne.php?id=<?php echo $item['ID']; ?>" title="Voir la fiche">Voir la fiche</a></div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            </li>
        </ul>
    </article>
</section>

<?php include( './inc/foot.php' ); // On inclut le fichier de pied de page