<?php
/**
 * On inclut les fichiers de configuration
**/
require( './ini.php' );
require( './common.php' );
/** **/

$_pdo = connectDB( ( defined( 'DB_HOST' ) ? DB_HOST : '' ), ( defined( 'DB_NAME' ) ? DB_NAME : '' ), ( defined( 'DB_LOGIN' ) ? DB_LOGIN : '' ), ( defined( 'DB_PWD' ) ? DB_PWD : '' ) ); // On appelle la fonction de connexion

$sitename = 'Utilisateurs';
include( './inc/head.php' ); // On inclut le fichier d'en-tête

if( !( isReallyAuthentified( $_pdo, 'registered', $_SESSION ) && hasAbility( 1, explode( ';', $_SESSION[APP_TAG]['registered']['autorisations'] ) ) ) ) : // Si personne n'est authentifié ou si la personne authentifiée n'a pas les droits pour lister,
    redirect();
else :
?>

<div class="grid-wrapper">
<div class="grid12 x2">
<header role="banner">
    <?php include( './inc/nav.php' ); // On inclut le fichier de navigation ?>
</header>
</div>

<div class="grid12 x10">
<section role="main" id="users">
    <aside class="align-right" role="complementary">
        <p>Bienvenue <?php echo $_SESSION[APP_TAG]['registered']['pnom'] . ' ' . $_SESSION[APP_TAG]['registered']['nom']; ?></p>
    </aside>
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
        <?php
        if( isset( $_GET['_err'] ) ) :
            displayError( $_GET['_err'] );
        endif;
        ?>
        <ul class="grid-wrapper widgets">
            <li class="grid12 x12 item before" data-id="utilisateurs">
                <?php if( hasAbility( 2, explode( ';', $_SESSION[APP_TAG]['registered']['autorisations'] ) ) ) : // Si la personne authentifiée a les droits d'ajout, ?>
                <a class="sup-button" href="user.php?id=0" title="">Ajouter</a>
                <?php endif; ?>
                <?php
                $_str_query = 'SELECT `user`.`id` AS "ID", `user`.`login` "Identifiant", `user`.`firstname` AS "Prénom", `user`.`lastname` AS "Nom"
FROM `user`
ORDER BY `user`.`firstname` ASC, `user`.`lastname` ASC'; // On définit la chaîne de caractères représentant la requête
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
                            <div class="td"><?php if( hasAbility( 3, explode( ';', $_SESSION[APP_TAG]['registered']['autorisations'] ) ) ) : // Si la personne authentifiée a les droits d'édition, ?><a class="link" href="<?php echo ( defined( 'DOMAIN' ) ? DOMAIN : '' ); ?>user.php?id=<?php echo $item['ID']; ?>" title="Voir la fiche">&Eacute;diter la fiche</a><?php endif; ?></div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            </li>
        </ul>
    </article>
</section>
</div>
</div>

<?php
endif;
include( './inc/foot.php' ); // On inclut le fichier de pied de page