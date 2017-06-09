<?php
session_start(); // On autorise la page à accéder à la superglobale de session (http://php.net/manual/fr/function.session-start.php).



if( isset( $_GET['destroy'] ) ) : // Si la clé "destroy" est passée en paramètre dans l'URL,
    //session_destroy(); // On détruit la session pour vider l'historique (http://php.net/manual/fr/function.session-destroy.php).
    unset( $_SESSION['minijeu'] ); // On détruit la clé de session pour vider l'historique (http://php.net/manual/fr/function.unset.php).
    $page = $_SERVER['PHP_SELF']; // On utilise la superglobale "$_SERVER" pour récupérer le nom de la page en cours d'utilisation (http://php.net/manual/fr/reserved.variables.server.php).
    header( 'Location:' . $page ); // On utilise la fonction "header" pour rediriger vers une autre page (http://php.net/manual/fr/function.header.php).
    exit();
endif;



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
/**
 * compareNomber - Compare deux nombres passés en paramètres et nous retourne le rapport entre eux : égalité, plus petit, plus grand.
 * @param   int $val
 * @param   int $ref
 * @return  string
**/
function compareNomber( $val, $ref ) {
    if( $val < $ref )
        return 'trop petit !';
    elseif( $val > $ref )
        return 'trop grand !';
    else
        return 'trouvé';
}



if( !isset( $_SESSION['minijeu']['rand'] ) ) // Si la session n'existe pas OU que la clé "minijeu" n'a pas été déclarée OU que la clé "rand" n'a pas été générée,
    $_SESSION['minijeu']['rand'] = generateNomber(); // On stocke un nombre aléatoire en session.


if( isset( $_POST['txt-search'] ) ) : // Si on a soumis des données via notre formulaire,
    $saisie = str_replace( ',', '.', $_POST['txt-search'] ); // On gère le cas d'un saisie de virgule.
    
    if( is_numeric( $saisie ) ) : // Si la saisie est numérique,
        if( is_int( (int)$saisie ) ) : // Si la saisie est un entier,
            $result = compareNomber( (int)$saisie, $_SESSION['minijeu']['rand'] ); // On compare la saisie avec le nombre généré aléatoirement et stocké en session.
            
            $_SESSION['minijeu']['historique'][] = array( // On stocke en session la saisie et le résultat de la comparaison.
                'saisie'    => (int)$saisie,
                'comp'      => $result
            );
        else :
            $error = '<span class="block error">La saisie doit être un entier !</span>';
        endif;
    else :
        $error = '<span class="block error">La saisie doit être numérique !</span>';
    endif;
endif;
?><!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0" />
        <title>Mini jeu | Les sessions - Mise en pratique</title>

        <link rel="stylesheet" type="text/css" href="../../_assets/css/style.css">

        <!-- // highlight.js : Coloration syntaxique du code -->
        <link rel="stylesheet" type="text/css" href="../../_assets/plugins/highlight/styles/monokai_sublime.css">
        <script type="text/javascript" src="../../_assets/plugins/highlight/highlight.pack.js"></script>
        <script type="text/javascript">
            hljs.initHighlightingOnLoad();
        </script>
        <!-- // -->

        <style type="text/css">
            <!--
            input[type="text"] {
                text-align:right;
                width:50px;
            }

            .error {
                background-color:red;
                color:white;
            }
            .warn { color:orange; }
            .ok { color:green; }

            .button {
                background-color:lightblue;
                color:white;
                display:inline-block;
                padding:10px 15px;
                text-align:center;
                text-decoration:none;
            }
            -->
        </style>
    </head>
    <body>
        <h1>Mini jeu | Les sessions - Mise en pratique</h1>
        <hr />
        <p>Un nombre <strong>entier</strong> a été généré aléatoirement par la fonction PHP rand.<br />Saurez-vous le retrouver ?</p>
        <form action="" method="POST" name="frm-minijeu">
            <label for="txt-search">Saisissez une valeur :</label>
            <input<?php if( isset( $_SESSION['minijeu']['historique'] ) && $_SESSION['minijeu']['historique'][count($_SESSION['minijeu']['historique'])-1]['comp']=='trouvé' ) echo ' disabled="disabled"'; ?> id="txt-search" min="0" name="txt-search" type="text" value="<?php echo isset( $_POST['txt-search'] ) ? $_POST['txt-search'] : 0; ?>" />

            <?php if( !( isset( $_SESSION['minijeu']['historique'] ) && $_SESSION['minijeu']['historique'][count($_SESSION['minijeu']['historique'])-1]['comp']=='trouvé' ) ) : ?>
            <input type="submit" value="Comparer" />
            <?php endif; ?>
        </form>
        <blockquote><small><em>sur quelques plates-formes (par exemple Windows), le nombre maximum est limité à 32767</em></small></blockquote>

        <?php echo isset( $error ) ? $error : ''; ?>

        <?php if( isset( $_SESSION['minijeu']['historique'] ) ) : // Si la session existe, ?>
        <hr />
        <h2>Historique</h2>
        <?php
        foreach( $_SESSION['minijeu']['historique'] as $cle=>$tentative ) : // Pour chaque ligne de l'historique,
            echo '<span class="' . ( $tentative['comp']=='trouvé' ? 'ok' : 'warn' ) . '">Tentative n°' . ( $cle + 1 ) . ' : ' . $tentative['saisie'] . ' &rarr; ' . $tentative['comp'] . ( $tentative['comp']=='trouvé' ? ' en ' . count( $_SESSION['minijeu']['historique'] ) . ' coups !' : '' ) . '</span><br />'; // On affiche la ligne.
        endforeach;
        ?>
        <br />
        <a class="button" href="?destroy" title="">Nouvelle partie</a>
        <?php endif; ?>
    </body>
</html>