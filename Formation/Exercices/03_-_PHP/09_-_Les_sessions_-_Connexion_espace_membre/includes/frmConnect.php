<form action="09_-_Les_sessions_-_Connexion_espace_membre/admin.php" method="POST" name="frm-connect">
    <label for="txt-login">Identifiant :</label>
    <input id="txt-login" name="login" type="text" value="<?php echo isset( $_SESSION['connexion']['login'] ) ? $_SESSION['connexion']['login'] : ''; ?>" />

    <label for="txt-pwd">Mot de passe :</label>
    <input id="txt-pwd" name="pwd" type="password" value="" />

    <input type="submit" value="Se connecter" />
</form>