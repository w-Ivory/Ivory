<!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="utf-8" />
        <title>Liste des conversations | Forum</title>
    </head>
    <body>
        <header role="banner">
            <nav id="nav-menu-principal" role="navigation">
                <ul id="menu-principal">
                    <li><a href="?" title="">Accueil</a></li>
                    <li><a href="?c=user" title="">Utilisateurs</a>
                        <ul class="sub">
                            <li><a href="?c=user" title="">Tous les utilisateurs</a></li>
                            <li><a href="?c=user&a=add" title="">Ajouter un utilisateur</a></li>
                        </ul>
                    </li>
                    <li><a href="?c=conversation" title="">Conversations</a>
                        <ul class="sub">
                            <li><a href="?c=conversation" title="">Tous les conversations</a></li>
                            <li><a href="?c=conversation&a=add" title="">Ajouter une conversation</a></li>
                        </ul>
                    </li>
                    <li><a href="?a=contact" title="">Contact</a></li>
                </ul>
            </nav>
        </header>

        <section role="main">
            <article role="article">
                <header>
                    <h1>Liste des conversations | Forum</h1>
                    <a class="link" href="<?php echo ( SRequest::getInstance()->get( 'c' )!==null ? '?c=' . SRequest::getInstance()->get( 'c' ) . '&' : '?' ); ?>a=add" title="">Ajouter une conversation</a>
                </header>

                <ul class="list">
                    <?php
                    foreach( $arr_datas as $item ) :
                        echo '
                    <li class="item"><a class="link" href="' . ( SRequest::getInstance()->get( 'c' )!==null ? '?c=' . SRequest::getInstance()->get( 'c' ) . '&' : '?' ) . 'a=conversation&id=' . $item['ID'] . '" title="">Conversation n° ' . $item['ID'] . ' (' . $item['Date'] . ')</a></li>';
                    endforeach;
                    ?>
                </ul>
            </article>
        </section>

        <footer role="contentinfo"></footer>
    </body>
</html>