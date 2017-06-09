<?php
header( $_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found' );
require_once( '..\app\config\ini.php' );

$sitename = 'Erreur 404';
include_once( WEBPATH . 'header.php' );
?>

<article role="article">
    <header>
        <hgroup>
            <h1><?php echo ( defined( 'ForumController::THREE_SPEECH_BUBBLES' ) ? ForumController::THREE_SPEECH_BUBBLES . ' ' : '' ); ?> Erreur 404</h1>
            <hr>
            <h2>Page non trouvée</h2>
        </hgroup>
    </header>

    <p>Elles ne peuvent pas toute être gagnantes ... Essayez en une autre.</p>
    <p><small><?php printf( 'L\'URL demandée n\'a pas pu être trouvée sur ce serveur.<br>Si vous avez saisi l\'URL manuellement, vérifiez-la et réessayez.<br>Si vous pensez qu\'il s\'agit d\'une erreur de serveur, veuillez <a href="mailto:%s">contacter le support technique</a>.', SUPPORT_EMAIL ); ?></small></p>

    <footer>
        <a class="back" href="<?php echo DOMAIN; ?>" title="">Retour à la page d'accueil</a></li>
    </footer>
</article>

<?php
include_once( WEBPATH . 'footer.php' );