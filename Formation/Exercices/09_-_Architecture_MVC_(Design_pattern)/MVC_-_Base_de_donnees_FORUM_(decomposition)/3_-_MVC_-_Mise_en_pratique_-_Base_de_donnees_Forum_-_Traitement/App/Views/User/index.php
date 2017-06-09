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
                    <a class="link" href="?a=add" title="">Ajouter un utilisateur</a>
                </header>

                <ul class="list">
                    <?php
                    foreach( $arr_datas as $item ) :
                        echo '
                    <li class="item"><a class="link" href="?a=profile&id=' . $item['ID'] . '" title="' . $item['Nom'] . ' ' . $item['Prénom'] . ' (' . $item['Login'] . ')">' . $item['Nom'] . ' ' . $item['Prénom'] . ' (' . $item['Login'] . ')</a></li>';
                    endforeach;
                    ?>
                </ul>
            </article>
        </section>

        <footer role="contentinfo"></footer>
    </body>
</html>