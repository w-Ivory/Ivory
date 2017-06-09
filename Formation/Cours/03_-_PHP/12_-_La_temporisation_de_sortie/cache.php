<?php
$cacheFic = 'cache/index.html';
$expire = time()-60;

if( file_exists( $cacheFic ) && filemtime( $cacheFic ) > $expire ) :
    readfile( $cacheFic );
else :
    ob_start(); // Ouverture d'une temporisation de sortie.
    include('header.php');
?>
        <form action="traitement.php" method="POST">
            <label for="txt">Champs de saisie :</label>
            <input id="txt" name="txt" type="text" value="" />

            <input type="submit" value="Envoyer" />
        </form>
<?php
    include('footer.php');
    $tampon = ob_get_contents(); // Stockage du tampon dans une variable
    ob_end_clean(); // Fermeture ET effacement du tampon
    file_put_contents( $cacheFic, $tampon );
    echo $tampon;
endif;
?>