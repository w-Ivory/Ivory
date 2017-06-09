<?php
session_start();
require( 'Versions Alexandre/PHP_Array_TextAdventure/web/data.php' );

/**
 * getChapter - Récupère le texte d'un chapitre n
 * @param   array   $datas
 * @param   int     $n
 * @return  string
**/
function getChapter( $datas, $n ) {
    return $datas[$n]['texte'];
}
?><!DOCTYPE html>
<html>
    <head>
        <title></title>
    </head>
    <body>
        <?php
        if( !isset( $_SESSION['currentChapter'] ) || $_SESSION['currentChapter']>count($_SESSION['currentChapter']) ) {
            $_SESSION['currentChapter'] = 0;
        }
        if( isset( $_POST['choices'] ) ) {
            $_SESSION['currentChapter'] = $_POST['choices'];
        }


        echo getChapter( $story, $_SESSION['currentChapter'] );
        ?>
        <form action="" method="post">
            <label for="list-choices">Que voulez-vous faire ?</label>
            <select id="list-choices" name="choices">
                <?php
                foreach( $story[$_SESSION['currentChapter']]['choix'] as $choice ) {
                    echo '<option value="' . $choice['page'] . '">' . $choice['texte'] . '</option>';
                }
                ?>
            </select>

            <input type="submit" name="Valider le choix">
        </form>
    </body>
</html>