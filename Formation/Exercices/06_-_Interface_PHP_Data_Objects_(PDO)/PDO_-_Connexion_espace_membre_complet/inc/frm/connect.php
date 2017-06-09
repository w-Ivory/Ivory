<form action="" data-role="formulaire" method="POST" name="frm-connect">
    <span class="text-justify" data-role="wrapper">
        <label class="label" for="txt-login">Identifiant</label>
        <input id="txt-login" name="login" type="text" value="<?php echo isset( $_SESSION['connexion']['login'] ) ? $_SESSION['connexion']['login'] : ''; ?>" />
    </span>

    <span class="text-justify" data-role="wrapper">
        <label class="label" for="txt-pwd">Mot de passe</label>
        <input id="txt-pwd" name="pwd" type="password" value="" />
    </span>

    <input data-role="submit" type="submit" value="Se connecter" />
</form>