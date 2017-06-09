<?php
session_start();
require( 'common.php' );
if( isset( $_GET['deconnect'] ) ) {
    logout($_SESSION['monappconnexion']);
}
?><!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Connexion à l'espace d'administration "sécurisé"</title>
    </head>
    <body>
        <h1>Connexion à l'espace d'administration "sécurisé"</h1>
        <hr>
        <p>Afin de vous connecter, merci d'utiliser le formulaire ci-dessous :</p>
        <?php
        if( isset( $_GET['error'] ) ) echo manageError( $_GET['error'] );
        ?>
        <form action="admin.php" method="POST">
            <label for="txt-login">Identifiant</label>
            <input id="txt-login" name="login" type="text" value="">

            <label for="txt-pwd">Mot de passe</label>
            <input id="txt-pwd" name="pwd" type="password" value="">

            <input type="submit" value="Se connecter">
        </form>
    </body>
</html>