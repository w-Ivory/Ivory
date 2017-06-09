<?php
$this->setMeta('charset','utf-8');
$this->setMeta('toto','tata');
$this->setStylesheet('style');
?><!DOCTYPE html>
<html lang="<?php echo ( defined( 'LOCALE_STRING' ) ? LOCALE_STRING : 'fr-FR' ); ?>">
    <head>
        <meta charset="utf-8" />
        <title><?php $this->printTitle("Mon site avec mon FW - %title%"); ?></title>
        <?php
        $this->insertMetas();
        $this->printStylesheets();
        ?>
    </head>
    <body>
        <header role="banner">
            <nav id="nav-menu-principal" role="navigation">
                <ul id="menu-principal">
                    <li><a href="." title="">Accueil</a></li>
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
        <?php echo $html; ?>
        </section>

        <footer role="contentinfo"></footer>
    </body>
</html>