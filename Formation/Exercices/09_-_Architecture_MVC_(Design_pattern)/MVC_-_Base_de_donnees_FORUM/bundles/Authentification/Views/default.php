<article role="article" style="white-space: nowrap;">
    <header>
        <hgroup>
            <h1><?php echo ( defined( 'ForumController::THREE_SPEECH_BUBBLES' ) ? ForumController::THREE_SPEECH_BUBBLES . ' ' : '' ); ?>Connexion</h1>
            <hr>
            <h2>Forum</h2>
        </hgroup>
    </header>

    <?php
    if( isset( $error ) && $error=='login' )
        echo '<span class="error">Erreur de connexion</span>';
    ?>

    <form action="?c=authentification&a=login" class="form" method="post">
        <div class="wrapper">
            <input class="field" id="txt-login" name="login" required="required" type="text" />
            <label class="label required" for="txt-login">Identifiant ou adresse e-mail :</label>
        </div>

        <button class="submit" type="submit"><span class="wrapper">Se connecter</span></button>
    </form>
</article>