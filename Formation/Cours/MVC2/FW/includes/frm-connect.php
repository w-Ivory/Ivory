<form action="<?php if( defined( 'DOMAIN' ) ) echo DOMAIN; ?>?c=user&a=login" method="post">
    <input type="text" name="login" placeholder="Identifiant">
    <input type="password" name="password" placeholder="Mot de passe">
    <input type="submit" value="Se connecter">
</form>