<?php header( $_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found' ); ?><!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0" />
        <title>&#128491; Erreur 404 | Mise en pratique - Base de données Forum</title>

        <style type="text/css">
            <!--
            @import url( 'style.css' );
            -->
        </style>
    </head>
    <body>
        <header role="banner">
            <h1>&#128491; Erreur 404</h1>
            <hr />
        </header>

        <section role="main">
            <article>
                <header>
                    <h2>Référence non trouvée</h2>
                </header>

                <p>L'URL demandée n'a pas pu être trouvée sur ce serveur.<br />Si vous avez saisi l'URL à la main, veuillez la vérifier et réessayer.<br />Si vous pensez qu'il s'agit d'une erreur du serveur, veuillez <a href="mailto:postmaster@localhost">contacter le service technique</a>.</p>
                <footer>
                    <a class="back" href="<?php echo dirname( $_SERVER['PHP_SELF'] ); ?>/" title="">Revenir à l'accueil</a></li>
                </footer>
            </article>
        </section>
    </body>
</html>