<!DOCTYPE html>
<html lang="<?php echo ( defined( 'LOCALE_STRING' ) ? LOCALE_STRING : 'fr-FR' ); ?>">
    <head>
        <meta charset="utf-8" />
        <title></title>
    </head>
    <body>
        <header role="banner">
            <nav id="nav-menu-principal" role="navigation">
                <ul id="menu-principal">
                    <li><a href="." title="">Accueil</a></li>
                    <li><a href="?c=user" title="">Utilisateurs</a>
                        <?php if( $login!==null ) : ?>
                        <ul class="sub">
                            <li><a href="?c=user" title="">Tous les utilisateurs</a></li>
                            <li><a href="?c=user&a=add" title="">Ajouter un utilisateur</a></li>
                        </ul>
                        <?php endif; ?>
                    </li>
                    <li><a href="?c=conversation" title="">Conversations</a>
                        <?php if( $login!==null ) : ?>
                        <ul class="sub">
                            <li><a href="?c=conversation" title="">Tous les conversations</a></li>
                            <li><a href="?c=conversation&a=add" title="">Ajouter une conversation</a></li>
                        </ul>
                        <?php endif; ?>
                    </li>
                    <li><a href="?a=contact" title="">Contact</a></li>
                </ul>
            </nav>

            <div id="mod_auth">
                <?php if( $login!==null ) : ?>
                <p>Bienvenue <?php echo $login; ?>.<br /><a href="?c=authentification&a=logout">Se déconnecter</a></p>
                <?php else: ?>
                <form action="?c=authentification&a=login" method="post">
                    <label for="txt-login">Identifiant ou adresse e-mail :</label>
                    <input id="txt-login" name="login" type="text" />

                    <input type="submit" value="Se Connecter" />
                </form>  
                <?php endif; ?>
            </div>
        </header>

        <section role="main">
        <?php
        if( !$private || $login!==null )
            echo ( isset( $html ) ? $html : '' );
        else
            echo '<p class="warning">Veuillez d\'abord vous authentifier pour accéder à cette page.</p>';
        ?>
        </section>

        <footer role="contentinfo"></footer>
    </body>
</html>