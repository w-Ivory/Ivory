<?php
session_start(); // On autorise la page à accéder à la superglobale de session (http://php.net/manual/fr/function.session-start.php).

if( isset( $_GET ) && array_key_exists( 'destroy', $_GET ) ) : // Si la clé "destroy" est passée en paramètre dans l'URL,
    unset( $_SESSION['connexion'] ); // On détruit la session correspondant au code en cours.
    $page = $_SERVER['PHP_SELF']; // On utilise la superglobale "$_SERVER" pour récupérer le nom de la page en cours d'utilisation (http://php.net/manual/fr/reserved.variables.server.php).
    header( 'Location: ' . $page ); // On utilise la fonction "header" pour rediriger vers une autre page (http://php.net/manual/fr/function.header.php).
    exit();
endif;
?><!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0" />
        <title>Connexion à un espace membre | Les sessions - Mise en pratique</title>

        <style type="text/css">
            <!--
            /* --------------------------- */
            /* ------ STYLE GENERAL ------ */
            /* --------------------------- */
            * {
                -webkit-hyphens:none;
                -moz-hyphens:none;
                -ms-hyphens:none;
                hyphens:none;
            }
            *, *::before, *::after {
                -webkit-box-sizing:border-box;
                -moz-box-sizing:border-box;
                -ms-box-sizing:border-box;
                box-sizing:border-box;
            }
            :hover, :focus, :active { outline:none; }
            /* --------------------------- */

            /* --------------------------- */
            /* ------    BALISES    ------ */
            /* --------------------------- */
            /* ------    générales    ------ */
            /*html, body { margin:0;padding:0; }*/
            /* ------    html5    ------ */
            header, hgroup, nav, aside, article, figure, figcaption, section, details, footer, address { display:block; }
            address { font-style:normal; }
            input[type="color"], input[type="date"], input[type="datetime"], input[type="datetime-local"], input[type="email"], input[type="month"], input[type="number"], input[type="range"], input[type="search"], input[type="tel"], input[type="time"], input[type="url"], input[type="week"], input::-webkit-input-placeholder {
                -webkit-appearance:none;
                -webkit-box-sizing:border-box;
            }
            fieldset {
                border:none;
                border-top:rgba(47,47,47,.5) thin solid;
                display:block;
                margin:10px auto;
                padding:10px 10px 0 10px;
            }
                fieldset legend {
                    display:block;
                    margin:0;
                    overflow:hidden;
                    padding:10px 5px;
                    text-transform:uppercase;
                }

                label {
                    display:block;
                    margin:5px 0;
                }
            -->
        </style>
    </head>
    <body>
        <h1>Accueil</h1>
        <hr />
        <fieldset>
            <legend>Connexion à l'espace membre</legend>

            <?php
            if( isset( $_SESSION['connexion']['_err']['code'] ) ) : // Si la session existe avec les clés voulues,
                switch( $_SESSION['connexion']['_err']['code'] ) : // Selon le code de retour,
                    case 'connecte': // Cas où on est connecté :
            ?>
            <p>Vous êtes déjà connecté !</p>
            <br />
            <a href="09_-_Les_sessions_-_Connexion_espace_membre/admin.php" title="">Aller à l'admin</a>
            <br />
            <a href="?destroy" title="">Se déconnecter</a>
            <?php
                        break;
                    default : // Tous les autres cas :
                        echo isset( $_SESSION['connexion']['_err']['msg'] ) ? '<p>' . $_SESSION['connexion']['_err']['msg'] . '</p>' : '';
                        include( '09_-_Les_sessions_-_Connexion_espace_membre/includes/frmConnect.php' ); // On inclut le formulaire.
                endswitch;
            else :
                include( '09_-_Les_sessions_-_Connexion_espace_membre/includes/frmConnect.php' ); // On inclut le formulaire.
            endif;
            ?>
        </fieldset>
    </body>
</html>