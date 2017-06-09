        <h1>Contact</h1>
        <?php if( isset( $result ) ) { echo '<p>' . $result . '</p>'; } ?>
        <form action="<?php if( defined( 'DOMAIN' ) ) echo DOMAIN; ?>?a=sending" method="post">
            <input type="email" name="email" placeholder="Email">
            <input type="text" name="object" placeholder="Sujet">
            <textarea name="message"></textarea>
            <input type="submit" value="Envoyer">
        </form>
    </body>
</html>