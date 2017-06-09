<?php
require_once( 'ini.php' );
require_once( 'common.php' );
require_once( 'core/SPDO.php' );

if( !( SRequest::getInstance()->get( 'conv' )!==NULL && is_numeric( SRequest::getInstance()->get( 'conv' ) ) )  ):
    header( 'Location:404.php' );
    exit();
endif;

try {
    $forumManager = new ForumManager( SPDO::getInstance( DB_HOST, DB_NAME, DB_LOGIN, DB_PWD )->getPDO() );
    $forum = new ClassForum( $forumManager->getConversation( SRequest::getInstance()->get( 'conv' ) ) );

    if( !( $forum->getConversation( SRequest::getInstance()->get( 'conv' ) )!==NULL && is_object( $forum->getConversation( SRequest::getInstance()->get( 'conv' ) ) ) && get_class( $forum->getConversation( SRequest::getInstance()->get( 'conv' ) ) )=='ClassConversation' ) ) :
        header( 'Location:404.php' );
        exit();
    endif;

    if( SRequest::getInstance()->get( 'page' )!==NULL && is_numeric( SRequest::getInstance()->get( 'conv' ) ) && SRequest::getInstance()->get( 'conv' )>0 ) :
        $current_page = SRequest::getInstance()->get( 'page' );
        SRequest::getInstance()->unset( 'get', 'page' );
    else :
        $current_page = 1;
    endif;
    $forum->getConversation( SRequest::getInstance()->get( 'conv' ) )->setPagination( $current_page, RESULTS_PER_PAGE );
    
    // foreach( $forumManager->getMessage( SRequest::getInstance()->get( 'conv' ), ( ( $current_page - 1 ) * RESULTS_PER_PAGE ) , RESULTS_PER_PAGE ) as $message )
    //     $forum->getConversation( SRequest::getInstance()->get( 'conv' ) )->setMessage( $message );
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
            <h1><?php echo ( defined( 'THREE_SPEECH_BUBBLES' ) ? THREE_SPEECH_BUBBLES . ' ' : '' ); ?>Etape 2 : Liste des message de la conversation n°<?php echo ( $forum->getConversation( SRequest::getInstance()->get( 'conv' ) )->getId()!==NULL ? $forum->getConversation( SRequest::getInstance()->get( 'conv' ) )->getId() : ( SRequest::getInstance()->get( 'conv' )!==NULL ? SRequest::getInstance()->get( 'conv' ) : '(inconnu)' ) ); ?></h1>
            <hr />
        </header>

        <section role="main">
            <?php echo $forum->getConversation( SRequest::getInstance()->get( 'conv' ) ); ?>
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