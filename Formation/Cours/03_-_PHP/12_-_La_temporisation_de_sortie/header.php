<?php
$fic = 'cache/header.html';
$expire = time()-3600;

if( file_exists( $fic ) && filemtime( $fic ) > $expire ) :
    readfile( $fic );
else :
    ob_start(); // Ouverture d'une temporisation de sortie.
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0" />
        <title></title>

        <style type="text/css">
            <!--
            *,*::before,*::after {
                -webkit-box-sizing:border-box;
                -moz-box-sizing:border-box;
                -ms-box-sizing:border-box;
                -o-box-sizing:border-box;
                box-sizing:border-box;
            }

            -->
        </style>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
<?php
    $tmp = ob_get_contents(); // Stockage du tampon dans une variable
    ob_end_clean(); // Fermeture ET effacement du tampon
    file_put_contents( $fic, $tmp );
    echo $tmp;
endif;
?>