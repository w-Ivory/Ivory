<?php
require_once( 'ini.php' );
require_once( 'common.php' );
require_once( 'core/SPDO.php' );

try {
    $forumManager = new ForumManager( SPDO::getInstance( DB_HOST, DB_NAME, DB_LOGIN, DB_PWD )->getPDO() );
    $datas = $forumManager->getMessage( SRequest::getInstance()->get( 'conv' ) );
} catch( ForumException $e ) {
    die( $e );
} catch( Exception $e ) {
    die( $e->getMessage() );
}
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
            <h1><?php echo ( defined( 'THREE_SPEECH_BUBBLES' ) ? THREE_SPEECH_BUBBLES . ' ' : '' ); ?>Etape 2 : Liste des message de la conversation n°<?php echo isset( $datas[0]['Conversation'] ) ? $datas[0]['Conversation'] : ( isset( $_GET['conv'] ) ? $_GET['conv'] : '(inconnu)' ); ?></h1>
            <hr />
        </header>

        <section role="main">
            <a class="back" href="index.php" title="">Revenir aux conversations</a>
            <?php if( isset( $datas ) && is_array( $datas ) && count( $datas )>0 ) : ?>
            <table class="messages" style="width:100%;">
                <thead>
                    <tr>
                        <?php
                        foreach( $datas[0] as $key=>$value ) :
                            switch( $key ) :
                                case 'Conversation':
                                case 'ID':
                                    break;
                                default:
                                    echo '<th>' . $key . '</th>';
                                    break;
                            endswitch;
                        ?>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach( $datas as $message ) : ?>
                    <tr>
                        <?php
                        foreach( $message as $key=>$value ) :
                            switch( $key ) :
                                case 'Conversation':
                                case 'ID':
                                    break;
                                default:
                                    echo '<td>' . $value . '</td>';
                                    break;
                            endswitch;
                        endforeach;
                        ?>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>
        </section>

        <footer role="contentinfo">
            <span>&copy;<?php echo date( 'Y' ); ?> Tous droits réservés<?php echo ( defined( 'AUTHOR_NAME' ) ? ' - ' . AUTHOR_NAME : '' ); ?></span>
        </footer>
    </body>
</html>