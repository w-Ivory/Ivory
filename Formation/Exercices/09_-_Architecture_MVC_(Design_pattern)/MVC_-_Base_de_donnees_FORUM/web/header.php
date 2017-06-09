<!DOCTYPE html>
<html lang="<?php echo ISO_LANGUAGE_CODE; ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
        <title><?php echo ( defined( 'ForumController::THREE_SPEECH_BUBBLES' ) ? ForumController::THREE_SPEECH_BUBBLES . ' ' : '' ) . ( isset( $sitename ) ? $sitename . ( defined( 'TITLE_SEPARATOR' ) ? TITLE_SEPARATOR : '' ) : '' ) . ( defined( 'SITE_TITLE' ) ? SITE_TITLE : '' ); ?></title>

        <style type="text/css">
            <!--
            @import url('<?php echo ASSETS_URL; ?>fonts/font-awesome/css/font-awesome.min.css');
            @import url('<?php echo THEMES_URL; ?>style.css');
            @import url('<?php echo ASSETS_URL; ?>css/forum.css');
            -->
        </style>
    </head>
    <body>
        <header class="flex-wrapper horizontal" role="banner">
            <a id="primary-logo" href="<?php echo DOMAIN; ?>" title="<?php echo SITE_TITLE; ?>"><img alt="<?php echo SITE_TITLE; ?>" src="<?php echo ASSETS_URL; ?>images/logo.png"></a>
            <nav id="primary-nav">
                <ul class="flex-wrapper horizontal menu" id="primary-menu">
                    <li class="menu-item"><a href="<?php echo DOMAIN; ?>" title="Accueil">Accueil</a></li>
                    <li class="menu-item"><a href="<?php echo DOMAIN; ?>?c=forum" title="Forum">Forum</a></li>
                </ul>
            </nav>

            <div id="mod_auth">
                <a class="mod_auth-link<?php if( isset( $error ) && $error=='login' ) echo ' error'; ?>" href="<?php echo DOMAIN . ( $login!==null ? '?c=admin&a=dashboard' : '?c=authentification' ); ?>" title=""><i class="fa fa-user-circle fa-2x" aria-hidden="true"></i></a>
                <div class="mod_auth-block">
                    <?php
                    if( isset( $error ) && $error=='login' )
                        echo '<span class="error">Erreur de connexion</span>';

                    if( $login!==NULL ) :
                        echo '<p>Bienvenue ' . $login . '.</p><a class="link" href="?c=authentification&a=logout"><span class="wrapper">Se déconnecter</span></a>';
                    else :
                    ?>
                    <form action="<?php echo DOMAIN; ?>?c=authentification&a=login" class="form" method="post">
                        <div class="wrapper">
                            <input class="field" id="txt-login" name="login" required="required" type="text" />
                            <label class="label required" for="txt-login">Identifiant ou adresse e-mail :</label>
                        </div>

                        <button class="submit" type="submit"><span class="wrapper">Se connecter</span></button>
                    </form>
                    <?php endif; ?>
                </div>
            </div>
        </header>

        <main role="main">