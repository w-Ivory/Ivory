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

    if( SRequest::getInstance()->get( 'page' )!==NULL && is_numeric( SRequest::getInstance()->get( 'conv' ) ) && SRequest::getInstance()->get( 'conv' )>0 ) :
        $current_page = SRequest::getInstance()->get( 'page' );
        SRequest::getInstance()->unset( 'get', 'page' );
    else :
        $current_page = 1;
    endif;

    $conversation = $forumManager->getConversation( SRequest::getInstance()->get( 'conv' ) );
    $datas = $forumManager->getMessage( SRequest::getInstance()->get( 'conv' ), ( ( $current_page - 1 ) * RESULTS_PER_PAGE ) , RESULTS_PER_PAGE );

    if( !( isset( $datas ) && is_array( $datas ) && count( $datas )>0 ) ) :
        header( 'Location:404.php' );
        exit();
    endif;
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
            <?php if( isset( $datas ) && is_array( $datas ) && count( $datas )>0 && !is_null( $datas[0]['ID'] ) ) : ?>
            <table class="messages" style="width:100%;">
                <thead>
                    <tr>
                        <td bgcolor="gray"><?php if( isset( $current_page ) && $current_page>1 ) : ?><a class="first" href="?<?php echo http_build_query( SRequest::getInstance()->get() ); // On reconstruit la requête depuis les GET déjà passés (http://php.net/manual/fr/function.http-build-query.php). ?>" title="">Première page</a><?php endif; ?></td>
                        <td bgcolor="gray"><?php if( isset( $current_page ) && $current_page>1 ) : ?><a class="prev" href="?<?php echo http_build_query( SRequest::getInstance()->get() ); ?>&page=<?php echo $current_page - 1;?>" title="">Précedent</a><?php endif; ?></td>
                        <td align="right" bgcolor="gray"><?php if( isset( $current_page ) && $current_page<( $conversation[0]['Total Message(s)'] / RESULTS_PER_PAGE ) ) : ?><a class="next" href="?<?php echo http_build_query( SRequest::getInstance()->get() ); // Génère une chaine de requête encodée pour les URL (http://php.net/manual/fr/function.http-build-query.php) ?>&page=<?php echo $current_page + 1;?>" title="">Suivant</a><?php endif; ?></td>
                        <td align="right" bgcolor="gray"><?php if( isset( $current_page ) && $current_page<( $conversation[0]['Total Message(s)'] / RESULTS_PER_PAGE ) ) : ?><a class="last" href="?<?php echo http_build_query( SRequest::getInstance()->get() ); ?>&page=<?php echo ( ceil( $conversation[0]['Total Message(s)'] / RESULTS_PER_PAGE ) ); // On arrondit le calcul avec la fonction ceil. ?>" title="">Dernière page</a><?php endif; ?></td>
                    </tr>
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
                <tfoot>
                    <tr>
                        <td bgcolor="gray"><?php if( isset( $current_page ) && $current_page>1 ) : ?><a class="first" href="?<?php echo http_build_query( SRequest::getInstance()->get() ); // On reconstruit la requête depuis les GET déjà passés (http://php.net/manual/fr/function.http-build-query.php). ?>" title="">Première page</a><?php endif; ?></td>
                        <td bgcolor="gray"><?php if( isset( $current_page ) && $current_page>1 ) : ?><a class="prev" href="?<?php echo http_build_query( SRequest::getInstance()->get() ); ?>&page=<?php echo $current_page - 1;?>" title="">Précedent</a><?php endif; ?></td>
                        <td align="right" bgcolor="gray"><?php if( isset( $current_page ) && $current_page<( $datas[0]['Total Message(s)'] / RESULTS_PER_PAGE ) ) : ?><a class="next" href="?<?php echo http_build_query( SRequest::getInstance()->get() ); // Génère une chaine de requête encodée pour les URL (http://php.net/manual/fr/function.http-build-query.php) ?>&page=<?php echo $current_page + 1;?>" title="">Suivant</a><?php endif; ?></td>
                        <td align="right" bgcolor="gray"><?php if( isset( $current_page ) && $current_page<( $datas[0]['Total Message(s)'] / RESULTS_PER_PAGE ) ) : ?><a class="last" href="?<?php echo http_build_query( SRequest::getInstance()->get() ); ?>&page=<?php echo ( ceil( $datas[0]['Total Message(s)'] / RESULTS_PER_PAGE ) ); // On arrondit le calcul avec la fonction ceil. ?>" title="">Dernière page</a><?php endif; ?></td>
                    </tr>
                </tfoot>
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
            <?php
            else :
                echo '<div class="alert">Cette conversation est vide pour le moment.</div>';
            endif;
            ?>
        </section>

        <footer role="contentinfo">
            <span>&copy;<?php echo date( 'Y' ); ?> Tous droits réservés<?php echo ( defined( 'AUTHOR_NAME' ) ? ' - ' . AUTHOR_NAME : '' ); ?></span>
        </footer>
    </body>
</html>