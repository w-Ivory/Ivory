<!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="utf-8" />
        <title>Profil de <?php echo $item['u_nom'] . ' ' . $item['u_prenom'] . ' (' . $item['u_login'] . ')'; ?> | Forum</title>

        <link rel="stylesheet" type="text/css" href="style.css" />
    </head>
    <body>
        <header role="banner">
            <nav id="ariane">
                <ul class="list">
                    <li class="item"><a class="link" href="?" title="">Accueil</a></li>
                    <li class="item"><a class="link" href="<?php echo ( isset( $_GET['c'] ) ? '?c=' . $_GET['c'] : '?' ); ?>" title="">Utilisateurs</a></li>
                    <li class="item"><?php echo $item['u_nom'] . ' ' . $item['u_prenom'] . ' (' . $item['u_login'] . ')'; ?></li>
                </ul>
            </nav>
        </header>

        <section role="main">
            <article role="article">
                <header>
                    <h1>Profil de <?php echo $item['u_nom'] . ' ' . $item['u_prenom'] . ' (' . $item['u_login'] . ')'; ?> | Forum</h1>
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