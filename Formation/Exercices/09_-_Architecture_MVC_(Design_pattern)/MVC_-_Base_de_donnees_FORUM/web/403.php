<?php
header( $_SERVER['SERVER_PROTOCOL'] . ' 403 Forbidden' );
require_once( '..\app\config\ini.php' );

$sitename = 'Erreur 403';
include_once( WEBPATH . 'header.php' );
?>

<article role="article">
    <header>
        <hgroup>
            <h1><?php echo ( defined( 'ForumController::THREE_SPEECH_BUBBLES' ) ? ForumController::THREE_SPEECH_BUBBLES . ' ' : '' ); ?> Erreur 403</h1>
            <hr>
            <h2>Accès refusé/interdit</h2>
        </hgroup>
    </header>

    <p>Nous sommes désolés, vous n'avez pas accès à la page que vous avez demandée.</p>
    <p><small>Pour afficher cette page, vous devrez peut-être vous connecter avec un compte différent.</small></p>

    <footer>
        <a class="back" href="<?php echo DOMAIN; ?>" title="">Retour à la page d'accueil</a></li>
    </footer>
</article>

<?php
include_once( WEBPATH . 'footer.php' );