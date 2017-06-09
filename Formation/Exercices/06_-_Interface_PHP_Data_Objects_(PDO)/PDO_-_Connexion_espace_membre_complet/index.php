<?php
/**
 * On inclut les fichiers de configuration
**/
require( './ini.php' );
require( './common.php' );
/** **/

$_pdo = connectDB( ( defined( 'DB_HOST' ) ? DB_HOST : '' ), ( defined( 'DB_NAME' ) ? DB_NAME : '' ), ( defined( 'DB_LOGIN' ) ? DB_LOGIN : '' ), ( defined( 'DB_PWD' ) ? DB_PWD : '' ) ); // On appelle la fonction de connexion

include( './inc/head.php' ); // On inclut le fichier d'en-tête
if( defined( 'APP_TAG' ) && isset( $_POST ) && array_key_exists( 'login', $_POST ) && array_key_exists( 'pwd', $_POST ) ) : // Si un utilisateur tente de se connecter,
    $_SESSION[APP_TAG]['registered'] = authenticate( $_pdo, 'login', 'pwd', $_POST ); // On connecte l'utilisateur
endif;

if( !isReallyAuthentified( $_pdo, 'registered', $_SESSION ) ) : // Si personne n'est pas authentifiée,
?>

<div class="grid-wrapper">
<div class="grid12 x2">
<header role="banner">
    <nav role="navigation">
        <a href="<?php echo defined( 'DOMAIN' ) ? DOMAIN : dirname( $_SERVER['PHP_SELF'] ); ?>" id="logo" rel="home" title="<?php echo defined( 'SITE_TITLE' ) ? SITE_TITLE : ''; ?>"><span data-role="logo-wrapper"><img alt="<?php echo defined( 'SITE_TITLE' ) ? SITE_TITLE : ''; ?>" data-role="logo" src="<?php echo defined( 'ASSETSURL' ) ? ASSETSURL : ( defined( 'DOMAIN' ) ? DOMAIN : dirname( $_SERVER['PHP_SELF'] ) ) . 'assets/'; ?>img/picto_O3W.jpg" /></span><span data-role="baseline"><?php echo defined( 'SITE_TITLE' ) ? SITE_TITLE : ''; ?></span></a>
    </nav>
</header>
</div>

<div class="grid12 x10">
<section role="main" id="home">
    <article role="article">
        <header class="header">
            <h1 class="title-lvl1">Connexion à l'espace d'administration</h1>
        </header>
        <ul class="grid-wrapper widgets">
            <li class="grid12 x6 item before" data-id="authentification">
                <?php
                if( isset( $_SESSION[APP_TAG]['registered'] ) && ( $_err = isErr( $_SESSION[APP_TAG]['registered'] ) )!==false ) :
                    echo $_err['msg'];
                endif;
                if( isset( $_GET['_err'] ) ) :
                    displayError( $_GET['_err'] );
                endif;

                include( ( defined( 'INCPATH' ) ? INCPATH : '' ) . 'frm/connect.php' );
                ?>
            </li>
        </ul>
    </article>
</section>
</div>
</div>

<?php else : ?>

<div class="grid-wrapper">
<div class="grid12 x2">
<header role="banner">
    <?php include( './inc/nav.php' ); // On inclut le fichier de navigation ?>
</header>
</div>

<div class="grid12 x10">
<section role="main" id="home">
    <aside class="align-right" role="complementary">
        <p>Bienvenue <?php echo $_SESSION[APP_TAG]['registered']['pnom'] . ' ' . $_SESSION[APP_TAG]['registered']['nom']; ?></p>
    </aside>
    <article role="article">
        <header class="header">
            <h1 class="title-lvl1">Tableau de bord</h1>
        </header>
        <?php
        if( isset( $_GET['_err'] ) ) :
            displayError( $_GET['_err'] );
        endif;
        ?>
        <ul class="grid-wrapper widgets">
            <li class="grid12 x6 item before" data-id="Utilisateurs">
                <ul>
                    <?php
                    $_str_query = 'SELECT COUNT(`user`.`id`) AS TotalUsers FROM `user`'; // On définit la chaîne de caractères représentant la requête.
                    $_arr_datas = executeQuery( $_pdo, $_str_query );

                    if( isset( $_arr_datas ) && is_array( $_arr_datas ) && count( $_arr_datas )>0 ) :
                    ?>
                    <li class="text-justify"><span class="lbl">Nombre total</span> <span class="value"><?php echo $_arr_datas[0]['TotalUsers']; ?></span></li>
                    <?php endif; ?>
                    <?php
                    //$_str_query = 'SELECT `user`.`id` AS "ID", `user`.`login` "Identifiant", `user`.`firstname` AS "Prénom", `user`.`lastname` AS "Nom", `role`.`lbl` AS "Rôle" FROM `user` ORDER BY `user`.`firstname` ASC, `user`.`lastname` ASC'; // On définit la chaîne de caractères représentant la requête.
                    $_str_query = 'SELECT `user`.`id` AS "ID", `user`.`login` "Identifiant", `user`.`firstname` AS "Prénom", `user`.`lastname` AS "Nom"
FROM `user`
ORDER BY `user`.`firstname` ASC, `user`.`lastname` ASC'; // On définit la chaîne de caractères représentant la requête.
                    if( hasAbility( 1, explode( ';', $_SESSION[APP_TAG]['registered']['autorisations'] ) ) && ( $_arr_datas = executeQuery( $_pdo, $_str_query ) )!==false && is_array( $_arr_datas ) && count( $_arr_datas )>0 ) : // Si la personne authentifiée a les droits pour lister et qu'il existe des utilisateurs à lister,
                    ?>
                    <li class="text-justify">
                        <span class="lbl">&Eacute;ditez la fiche de</span>
                        <span class="value">
                            <ul class="list">
                                <li><span class="title"></span>
                                    <ul class="">
                                        <?php foreach( $_arr_datas as $item ) : ?>
                                        <li><a<?php if( hasAbility( 3, explode( ';', $_SESSION[APP_TAG]['registered']['autorisations'] ) ) ) : echo ' href="' . ( defined( 'DOMAIN' ) ? DOMAIN : '' ) . 'user.php?id=' . $item['ID'] .'"'; endif; ?> title=""><?php echo $item['Prénom'] . ' ' . $item['Nom'] . ' (' . $item['Identifiant'] . ')'; ?></a></li>
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
</div>
</div>

<?php
endif;
include( './inc/foot.php' ); // On inclut le fichier de pied de page