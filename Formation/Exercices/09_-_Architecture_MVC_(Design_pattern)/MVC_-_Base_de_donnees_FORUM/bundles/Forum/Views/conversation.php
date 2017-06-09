<article role="article">
    <header>
        <hgroup>
            <h1><?php echo ( defined( 'ForumController::THREE_SPEECH_BUBBLES' ) ? ForumController::THREE_SPEECH_BUBBLES . ' ' : '' ); ?>Liste des message de la conversation n°<?php echo $conversation_number; ?></h1>
            <hr>
            <h2>Forum</h2>
        </hgroup>
    </header>

    <a class="back" href="<?php echo DOMAIN; ?>?c=forum" title="">Revenir aux conversations</a>
    <?php echo $conversation; ?>
</article>