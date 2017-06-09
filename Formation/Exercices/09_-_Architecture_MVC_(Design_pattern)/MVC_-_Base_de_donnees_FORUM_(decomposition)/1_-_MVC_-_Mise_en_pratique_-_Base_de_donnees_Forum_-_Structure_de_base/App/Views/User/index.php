<!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="utf-8" />
        <title>Liste des utilisateurs | Forum</title>
    </head>
    <body>
        <header role="banner"></header>

        <section role="main">
            <article role="article">
                <header>
                    <h1>Liste des utilisateurs | Forum</h1>
                </header>

                <ul class="list">
                    <?php
                    foreach( $arr_datas as $item ) :
                        echo '
                    <li class="item">' . $item['u_nom'] . ' ' . $item['u_prenom'] . ' (' . $item['u_login'] . ')</li>';
                    endforeach;
                    ?>
                </ul>
            </article>
        </section>

        <footer role="contentinfo"></footer>
    </body>
</html>