<?php
$donnees = array(
    array('lettre' => 'a', 'suivant' => 10),
    array('lettre' => 'e', 'suivant' => -1),
    array('lettre' => 'e', 'suivant' => 6),
    array('lettre' => 'l', 'suivant' => 1),
    array('lettre' => 'p', 'suivant' => 8),
    array('lettre' => 'o', 'suivant' => 11),
    array('lettre' => 'x', 'suivant' => 12),
    array('lettre' => 'p', 'suivant' => 3),
    array('lettre' => 'r', 'suivant' => 5),
    array('lettre' => 'm', 'suivant' => 7),
    array('lettre' => 'b', 'suivant' => 3),
    array('lettre' => 'b', 'suivant' => 0),
    array('lettre' => 'a', 'suivant' => 9)
);

/**
 * wordGen - Construire un mot à partir d'un index de départ dans le tableau
 * @param   array   $datas
 * @param   int     $start
 * @return  string
**/
function wordGen( $datas, $start ) {
    $word ='';

    do {
        $word .= $datas[$start]['lettre'];
        $start = $datas[$start]['suivant'];
    } while( $start!=-1 );

    return $word;
}
?><!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0" />
        <title>Liste chainée | Le passage de données - Mise en pratique</title>
    </head>
    <body>
        <h1>Liste chainée | Le passage de données - Mise en pratique</h1>
        <hr />
        <?php
        // $start = rand( 0, count( $donnees )-1 );
        $start = 40;

        echo wordGen( $donnees, $start );


        ?>
    </body>
</html>