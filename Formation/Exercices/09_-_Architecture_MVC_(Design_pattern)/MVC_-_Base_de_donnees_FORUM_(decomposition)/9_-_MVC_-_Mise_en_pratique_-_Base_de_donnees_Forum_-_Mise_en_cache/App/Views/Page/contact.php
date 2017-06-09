<article role="article">
    <header>
        <h1>Contact | Forum</h1>
    </header>

    <form action="<?php echo ( SRequest::getInstance()->get( 'c' )!==null ? 'c=' . SRequest::getInstance()->get( 'c' ) . '&' : '?' ); ?>a=sending" data-role="formulaire" method="post">
        <label data-role="label" for="txt-firstname">Nom</label>
        <input id="txt-firstname" maxlength="255" name="firstname" type="text" value="" />
        
        <label data-role="label" for="txt-lastname">Prénom</label>
        <input id="txt-lastname" maxlength="255" name="lastname" type="text" value="" />
        
        <label class="required" data-role="label" for="txt-mail">E-mail</label>
        <input id="txt-mail" name="mail" required="required" type="email" value="" />
        
        <label class="required" data-role="label" for="txt-object">Objet du message</label>
        <input id="txt-object" name="object" required="required" type="text" value="" />
        
        <label data-role="label" for="txt-message">Corps du message</label>
        <textarea id="txt-message" name="message"></textarea>

        <input data-role="submit" type="submit" value="Envoyer" />
    </form>
</article>