<!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="utf-8" />
        <title>Liste des utilisateurs | Forum</title>
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
                    <li><a href="?a=contact" title="">Contact</a></li>
                </ul>
            </nav>
        </header>

        <section role="main">
            <article role="article">
                <header>
                    <h1>Liste des utilisateurs | Forum</h1>
                    <a class="link" href="<?php echo ( SRequest::getInstance()->get( 'c' )!==null ? '?c=' . SRequest::getInstance()->get( 'c' ) . '&' : '?' ); ?>a=add" title="">Ajouter un utilisateur</a>
                </header>

                <ul class="list">
                    <?php
                    foreach( $arr_datas as $item ) :
                        echo '
                    <li class="item"><a class="link" href="' . ( SRequest::getInstance()->get( 'c' )!==null ? '?c=' . SRequest::getInstance()->get( 'c' ) . '&' : '?' ) . 'a=profile&id=' . $item['ID'] . '" title="' . $item['Nom'] . ' ' . $item['Prénom'] . ' (' . $item['Login'] . ')">' . $item['Nom'] . ' ' . $item['Prénom'] . ' (' . $item['Login'] . ')</a></li>';
                    endforeach;
                    ?>
                </ul>
            </article>
        </section>

        <footer role="contentinfo"></footer>
    </body>
</html>