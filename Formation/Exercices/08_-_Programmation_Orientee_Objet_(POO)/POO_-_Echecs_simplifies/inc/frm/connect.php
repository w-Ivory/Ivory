<form action="" data-role="formulaire" method="post">
    <span data-role="wrapper">
        <label class="required" data-role="label" for="txt-email<?php echo ( isset( $team ) ? ucwords( $team ) : '' ); ?>">Email</label>
        <input id="txt-email<?php echo ( isset( $team ) ? ucwords( $team ) : '' ); ?>" maxlength="255" name="email" required="required" type="email" value="" />
    </span>
    <span data-role="wrapper">
        <label class="required" data-role="label" for="txt-password<?php echo ( isset( $team ) ? ucwords( $team ) : '' ); ?>">Mot de passe</label>
        <input id="txt-password<?php echo ( isset( $team ) ? ucwords( $team ) : '' ); ?>" maxlength="100" name="password" required="required" type="password" value="" />
    </span>
    <span data-role="wrapper">
        <label data-role="label" for="txt-nickname<?php echo ( isset( $team ) ? ucwords( $team ) : '' ); ?>">Pseudo</label>
        <input id="txt-nickname<?php echo ( isset( $team ) ? ucwords( $team ) : '' ); ?>" maxlength="100" name="nickname" type="text" value="" />
    </span>
    <button class="button" name="submit<?php echo ( isset( $team ) ? ucwords( $team ) : '' ); ?>" type="submit">Créer un compte<br />/ Se connecter</button>

    <blockquote class="text-quote"><em>Si vous vous connectez pour la première fois, un compte sera automatiquement créé pour vous.</em></blockquote>
</form>