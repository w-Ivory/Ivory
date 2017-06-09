<!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="utf-8" />
        <title>Accueil | Forum</title>
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
                    <h1>Contact | Forum</h1>
                </header>

                <form action="<?php echo ( SRequest::getInstance()->get( 'c' )!==null ? 'c=' . SRequest::getInstance()->get( 'c' ) . '&' : '?' ); ?>a=sending" data-role="formulaire" method="post">
                    <label data-role="label" for="txt-firstname">Nom</label>
                    <input id="txt-firstname" maxlength="255" name="firstname" type="text" value="" />
                    
                    <label data-role="label" for="txt-lastname">Prénom</label>
                    <input id="txt-lastname" maxlength="255" name="lastname" type="text" value="" />
                    
                    <label class="required" data-role="label" for="txt-mail">E-mail</label>
                    <input id="txt-mail" name="mail" required="required" type="email" value="" />
                    
                    <label class="required" data-role="label" for="txt-object">Objet du message</label>
                    <input id="txt-object" name="object" required="required" type="text" value="" />
                    
                    <label data-role="label" for="txt-message">Corps du message</label>
                    <textarea id="txt-message" name="message"></textarea>

                    <input data-role="submit" type="submit" value="Envoyer" />
                </form>
            </article>
        </section>

        <footer role="contentinfo"></footer>
    </body>
</html>