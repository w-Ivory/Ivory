<?php
require_once( 'ini.php' );
require_once( 'common.php' );
require_once( 'core/SPDO.php' );

try {
    $forumManager = new ForumManager( SPDO::getInstance( DB_HOST, DB_NAME, DB_LOGIN, DB_PWD )->getPDO() );
    $forum = new ClassForum( $forumManager->getConversation() );
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0" />
        <title><?php echo ( defined( 'THREE_SPEECH_BUBBLES' ) ? THREE_SPEECH_BUBBLES . ' ' : '' ) . ( isset( $sitename ) ? $sitename . ( defined( 'TITLE_SEPARATOR' ) ? TITLE_SEPARATOR : '' ) : '' ) . ( defined( 'SITE_TITLE' ) ? SITE_TITLE : '' ); ?></title>
        
        <style type="text/css">
            <!--
            @import url(style.css);
            -->
        </style>
    </head>
    <body>
        <header role="banner">
            <h1><?php echo ( defined( 'THREE_SPEECH_BUBBLES' ) ? THREE_SPEECH_BUBBLES . ' ' : '' ); ?>Etape 2 : Liste des conversations</h1>
            <hr />
        </header>

        <section role="main">
            <?php echo $forum; ?>
        </section>

        <footer role="contentinfo">
            <span>&copy;<?php echo date( 'Y' ); ?> Tous droits réservés<?php echo ( defined( 'AUTHOR_NAME' ) ? ' - ' . AUTHOR_NAME : '' ); ?></span>
        </footer>
    </body>
</html>
<?php
} catch( ForumException $e ) {
    die( $e );
} catch( Exception $e ) {
    die( $e->getMessage() );
}