<?php
session_start();

if( isset( $_GET['newgame']) ) {
    unset( $_SESSION['minijeu']['rand'] );
    header( 'Location:' . $_SERVER['PHP_SELF'] );
    exit();
}

/**
 * generateNomber - Génère un nombre aléatoire compris entre les marges passées en paramètre si elles sont précisées, ou entre 0 et la plus grande valeur aléatoire possible (32767 sous certains systèmes comme Windows).
 * @param   mixed $min (numérique, null par défaut)
 * @param   mixed $max (numérique, null par défaut)
 * @return  mixed (numérique)
**/
function generateNomber( $min=NULL, $max=NULL ) {
    if( is_numeric( $min ) && is_numeric( $max ) )
        return rand( $min, $max ); // Si des limites sont passées en paramètres et que ces limites sont numériques, alors on génère un nombre aléatoire compris dans ces marges.
    else
        return rand(); // Sinon, on génère un nombre aléatoire dans les limites du système.
}


if( !isset( $_SESSION['minijeu']['rand'] ) ) {
    $_SESSION['minijeu']['rand'] = generateNomber( 10, 15 );
}


if( isset( $_SESSION['minijeu']['rand'] ) && isset( $_POST['txt-search'] ) ) {
    echo 'Le nombre à trouver est : ' . $_SESSION['minijeu']['rand'] . '<hr />';

    if( $_POST['txt-search'] > $_SESSION['minijeu']['rand'] )
        echo 'Votre saisie est trop grande !';
    elseif( $_POST['txt-search'] < $_SESSION['minijeu']['rand'] )
        echo 'Votre saisie est trop petite !';
    else
        echo 'Gagné';

    $_SESSION['minijeu']['historique'][] = $_POST['txt-search'];
}
?>
<form action="" method="POST" name="frm-minijeu">
    <label for="txt-search">Saisissez une valeur :</label>
    <input id="txt-search" min="0" name="txt-search" type="text" value="<?php echo isset( $_POST['txt-search'] ) ? $_POST['txt-search'] : 0; ?>" />

    <input type="submit" value="Comparer" />
</form>

<?php
if( isset( $_SESSION['minijeu']['historique'] ) ) {
    foreach($_SESSION['minijeu']['historique'] as $key => $value) {
        echo '<br />Coup numéro ' . ( $key + 1 ) . ' / essai : ' . $value;
    }
}
?>


<a href="?newgame" title="">Nouvelle partie</a>

<?php