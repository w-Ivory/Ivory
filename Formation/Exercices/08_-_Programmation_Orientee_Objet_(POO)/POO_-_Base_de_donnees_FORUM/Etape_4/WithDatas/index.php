<?php
require_once( 'ini.php' );
require_once( 'common.php' );
require_once( 'core/SPDO.php' );

try {
    $forumManager = new ForumManager( SPDO::getInstance( DB_HOST, DB_NAME, DB_LOGIN, DB_PWD )->getPDO() );
    $datas = $forumManager->getConversation();
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
            <h1><?php echo ( defined( 'THREE_SPEECH_BUBBLES' ) ? THREE_SPEECH_BUBBLES . ' ' : '' ); ?>Etape 2 : Liste des conversations</h1>
            <hr />
        </header>

        <section role="main">
            <?php if( isset( $datas ) && is_array( $datas ) && count( $datas )>0 ) : ?>
            <table class="conversations" style="width:100%;">
                <thead>
                    <tr>
                        <?php
                        foreach( $datas[0] as $key=>$value ) :
                            switch( $key ) :
                                case 'Status':
                                    break;
                                default:
                                    echo '<th>' . $key . '</th>';
                                    break;
                            endswitch;
                        ?>
                        <?php endforeach; ?>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach( $datas as $conversation ) : ?>
                    <tr<?php echo array_key_exists( 'Status', $conversation ) ? ' class="' . ( $conversation['Status']==1 ? 'closed' : 'opened' ) . '"' : ''; ?>>
                        <?php
                        foreach( $conversation as $key=>$value ) :
                            switch( $key ) :
                                case 'Status':
                                    break;
                                default:
                                    echo '<td>' . $value . '</td>';
                                    break;
                            endswitch;
                        endforeach;
                        ?>
                        <td><?php echo array_key_exists( 'ID', $conversation ) ? '<a class="more" href="conversation.php?conv=' . $conversation['ID'] . '" title="">Voir les messages</a>' : ''; ?></td>
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