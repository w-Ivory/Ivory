<!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="utf-8" />
        <title>Profil de <?php echo $item['Nom'] . ' ' . $item['Prénom'] . ' (' . $item['Login'] . ')'; ?> | Forum</title>

        <link rel="stylesheet" type="text/css" href="style.css" />
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
                    <h1>Profil de <?php echo $item['Nom'] . ' ' . $item['Prénom'] . ' (' . $item['Login'] . ')'; ?> | Forum</h1>
                </header>

                <ul class="list">
                    <?php
                    foreach( $item as $key=>$value ) :
                        echo '
                    <li class="item"><strong>' . $key . '</strong> : ' . $value . '</li>';
                    endforeach;
                    ?>
                </ul>
            </article>
        </section>

        <footer role="contentinfo"></footer>
    </body>
</html>