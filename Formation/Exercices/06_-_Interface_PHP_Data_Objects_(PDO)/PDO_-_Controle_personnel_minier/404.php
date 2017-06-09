<?php header( $_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found' ); ?>

<?php
/**
 * On inclut les fichiers de configuration
**/
require( './ini.php' );
/** **/

$sitename = 'Erreur 404';
include( './inc/head.php' ); // On inclut le fichier d'en-tête
?>

<section role="main" id="home">
    <article>
        <header><h1>Référence non trouvée</h1></header>
        <hr />
        <p>L'URL demandée n'a pas pu être trouvée sur ce serveur.<br />Si vous avez saisi l'URL à la main, veuillez la vérifier et réessayer.<br />Si vous pensez qu'il s'agit d'une erreur du serveur, veuillez <a href="mailto:postmaster@localhost">contacter le service technique</a>.</p>
        <figure style="background:transparent url('<?php echo ASSETSURL . 'img/404.jpg'; ?>') center center no-repeat;background-size:cover;height:500px;height:50rem;"></figure>
        <footer>
            <a class="back" href="<?php echo dirname( $_SERVER['PHP_SELF'] ); ?>/" title="">Revenir à l'accueil</a></li>
        </footer>
    </article>
</section>

<?php include( './inc/foot.php' ); // On inclut le fichier de pied de page