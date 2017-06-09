<?php
$fic = 'cache/footer.html';
$expire = time()-3600;

if( file_exists( $fic ) && filemtime( $fic ) > $expire ) :
    readfile( $fic );
else :
    ob_start(); // Ouverture d'une temporisation de sortie.
?>
        <a href="../10_-_La_temporisation_de_sortie.php" style="color:rgb(255,255,255);" title="">&larr; Retour au cours</a>
    </body>
</html>
<?php
    $tmp = ob_get_contents(); // Stockage du tampon dans une variable
    ob_end_clean(); // Fermeture ET effacement du tampon
    file_put_contents( $fic, $tmp );
    echo $tmp;
endif;
?>