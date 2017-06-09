<?php
if( !defined( 'PHP_EOL') ) : // Si la constante PHP_EOL n'existe pas (http://php.net/manual/fr/reserved.constants.php), 
    if( strtoupper( substr( PHP_OS, 0, 3 ) ) == 'WIN' ) : // Si la version du système d'exploitation (fournie par la constantes pré-définie PHP_OS) correspond à un noyau Windows,
        define( 'PHP_EOL', "\r\n" ); // On définit la constante avec les caractères Windows.
    else : // Sinon,
        define( 'PHP_EOL', "\n" ); // On définit la constante avec les caractères UNIX.
    endif;
endif;

define( 'DIRNAME', dirname( realpath( basename( $_SERVER['PHP_SELF'] ) ) ) . '\\' );  // On définit le chemin physique du fichier pour pouvoir le réexploiter plus tard sans avoir à la saisir à nouveau. Ce chemin est basé sur celui du script que nous sommes en train d'éxecuter (http://php.net/manual/fr/function.realpath.php).
define( 'FILENAME', 'data.txt' ); // On définit le nom du fichier pour pouvoir le réexploiter plus tard sans avoir à la saisir à nouveau.
define( 'NBSENTENCES', 8 ); // On définit le nombre de phrases.


/**
 * getSentences - Récupère le contenu d'un fichier pour le stocker dans un tableau
 * @param   string  $file
 * @param   string  $dir
 * @return  mixed (array/bool)
**/
function getSentences( $file, $dir ) {
    if( file_exists( $dir . $file ) ) : // Si le fichier existe (http://php.net/manual/fr/function.file-exists.php),
        if( ( $_resrc_file = fopen( $dir . $file, 'r' ) )!==false ) : // On ouvre le fichier en mode lecture seule et récupère la ressource.
            $_arr_strings = array( array() );
            while( !feof( $_resrc_file ) ) : // Tant que l'on n'a pas atteind la fin du fichier,
                if( ( $_line = fgets( $_resrc_file ) )==PHP_EOL ) : // S'il n'y a pas eu d'erreur et si cette ligne estune ligne de séparation,
                    $_arr_strings[] = array(); // On crée une nouvelle entrée dans le tableau.
                endif;

                $_arr_strings[count( $_arr_strings )-1][] = $_line; // On stocke la ligne
            endwhile;

            return $_arr_strings;
        else : // Sinon,
            echo '<div class="block error">Le fichier "' . $file . '" ne peut pas être ouvert.</div>'; // On affiche un message d'erreur indiquant une erreur d'ouverture.
        endif;
    else : // Sinon,
        echo '<div class="block error">Le fichier "' . $file . '" n\'existe pas dans le dossier "' . $dir . '".</div>'; // On affiche un message d'erreur indiquant que le fichier n'existe pas.
    endif;

    return false;
}

/**
 * makeSpeech - Compose un discours aléatoirement
 * @param   array   $_arr_strings
 * @param   int     $iteration
 * @return  string
**/
function makeSpeech( $_arr_strings, $iteration ) {
    $speech = '';

    if( isset( $_arr_strings[0][0] ) ) : // Si la première clé existe,
        $speech .= $_arr_strings[0][0]; // On l'affiche.
        unset( $_arr_strings[0][0] ); // On supprime l'entrée dans le tableau pour ne plus pouvoir l'utiliser.
    endif;

    for( $i = 0; $i<$iteration; $i++ ) : // Pour le nombre de phrases défini,
        foreach( $_arr_strings as $keyGroup => $group ) : // Pour chaque groupe de morceaux de phrase,
            if( !( $i===0 && $keyGroup===0 ) ) : // Si on ne débute pas le discours (nous avons déjà affiché "Mesdames, messieurs" donc nous sautons le premier groupe),
                $_keyRand = array_rand( $group ); // On sélectionne un morceau aléatoirement.
                $speech .= $group[$_keyRand]; // On affiche ce morceau de phrase.
                unset( $_arr_strings[$keyGroup][$_keyRand] ); // On supprime l'entrée dans le tableau pour ne plus pouvoir l'utiliser.
            endif;
        endforeach;
        $speech .= '<br />';
    endfor;

    return $speech;
}
?><!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0" />
        <title>Politique | La gestion de fichiers - Mise en pratique</title>

        <link rel="stylesheet" type="text/css" href="../../../_assets/css/style.css">

        <!-- // highlight.js : Coloration syntaxique du code -->
        <link rel="stylesheet" type="text/css" href="../../../_assets/plugins/highlight/styles/monokai_sublime.css">
        <script type="text/javascript" src="../../../_assets/plugins/highlight/highlight.pack.js"></script>
        <script type="text/javascript">
            hljs.initHighlightingOnLoad();
        </script>
        <!-- // -->
    </head>
    <body>
        <h1>Politique | La gestion de fichiers - Mise en pratique</h1>
        <p>Pour cet exercice :</p>
        <p>Nous allons écrire un discours automatique de politicien.<br />Notre programme doit sélectionner plusieurs morceaux de phrase aléatoirement et les compose pour former 5 phrases.<br />Les différents morceaux de phrase utilisables sont regroupés dans le fichier "data.txt". Chaque morceau est sur une ligne. Chaque groupe est séparé par une ligne vide.<br />Les phrases seront créées à partir d'un morceau du premier groupe, puis un morceau du second groupe, puis un du troisième, et enfin un du quatrième ... le tout aléatoirement (cas spécial : la première phrase commencera toujours par le premier morceau du premier groupe).<br />Un bon politicien ne se répète pas. Aussi, le programme ne pourra pas utiliser le même morceau de phrase deux fois.<br />Votre programme ne doit pas non plus modifier le fichier texte et doit prendre en considération le fait que l'on puisse ajouter d'autres morceaux de phrases.</p>

        <hr />
        <h2>Mon discours</h2>
        <?php
        if( ( $sentences = getSentences( FILENAME, DIRNAME ) )!==false )
            echo makeSpeech( $sentences, NBSENTENCES );
        ?>
        <hr />
        <h3>Version linéaire :</h3>
        <pre><code class="php">
&lt;?php
if( !defined( 'PHP_EOL') ) : // Si la constante PHP_EOL n'existe pas (http://php.net/manual/fr/reserved.constants.php), 
    if( strtoupper( substr( PHP_OS, 0, 3 ) ) == 'WIN' ) : // Si la version du système d'exploitation (fournie par la constantes pré-définie PHP_OS) correspond à un noyau Windows,
        define( 'PHP_EOL', "\r\n" ); // On définit la constante avec les caractères Windows.
    else : // Sinon,
        define( 'PHP_EOL', "\n" ); // On définit la constante avec les caractères UNIX.
    endif;
endif;

define( 'DIRNAME', dirname( realpath( basename( $_SERVER['PHP_SELF'] ) ) ) . '\\' );  // On définit le chemin physique du fichier pour pouvoir le réexploiter plus tard sans avoir à la saisir à nouveau. Ce chemin est basé sur celui du script que nous sommes en train d'éxecuter (http://php.net/manual/fr/function.realpath.php).
define( 'FILENAME', 'data.txt' ); // On définit le nom du fichier pour pouvoir le réexploiter plus tard sans avoir à la saisir à nouveau.
define( 'NBSENTENCES', 8 ); // On définit le nombre de phrases.

if( file_exists( DIRNAME . FILENAME ) ) : // Si le fichier existe (http://php.net/manual/fr/function.file-exists.php),
    if( ( $_resrc_file = fopen( DIRNAME . FILENAME, 'r' ) )!==false ) : // On ouvre le fichier en mode lecture seule et récupère la ressource.
        $_arr_strings = array( array() );
        while( !feof( $_resrc_file ) ) : // Tant que l'on n'a pas atteind la fin du fichier,
            $_line = fgets( $_resrc_file ); // On récupère la ligne dans le fichier texte.
            if( $_line!==false && $_line==PHP_EOL ) : // S'il n'y a pas eu d'erreur et si cette ligne estune ligne de séparation,
                $_arr_strings[] = array(); // On crée une nouvelle entrée dans le tableau.
            endif;
            $_arr_strings[count( $_arr_strings )-1][] = $_line; // On stocke la ligne
        endwhile;
    else : // Sinon,
        echo '&lt;div class="bloc error"&gt;Le fichier "' . FILENAME . '" ne peut pas être ouvert.&lt;/div&gt;'; // On affiche un message d'erreur indiquant une erreur d'ouverture.
    endif;
else : // Sinon,
    echo '&lt;div class="bloc error"&gt;Le fichier "' . FILENAME . '" n\'existe pas dans le dossier "' . DIRNAME . '".&lt;/div&gt;'; // On affiche un message d'erreur indiquant que le fichier n'existe pas.
endif;

if( isset( $_arr_strings[0][0] ) ) : // Si la première clé existe,
    echo $_arr_strings[0][0]; // On l'affiche.
    unset( $_arr_strings[0][0] ); // On supprime l'entrée dans le tableau pour ne plus pouvoir l'utiliser.
endif;

for( $i = 0; $i&lt;NBSENTENCES; $i++ ) : // Pour le nombre de phrases défini,
    foreach( $_arr_strings as $keyGroup =&gt; $group ) : // Pour chaque groupe de morceaux de phrase,
        if( !( $i===0 && $keyGroup===0 ) ) : // Si on ne débute pas le discours (nous avons déjà affiché "Mesdames, messieurs" donc nous sautons le premier groupe),
            $_keyRand = array_rand( $group ); // On sélectionne un morceau aléatoirement.
            echo $group[$_keyRand]; // On affiche ce morceau de phrase.
            unset( $group[$_keyRand] ); // On supprime l'entrée dans le tableau pour ne plus pouvoir l'utiliser.
        endif;
    endforeach;
    echo '&lt;br /&gt;';
endfor;</code></pre>
        <h3>Version avec des fonctions :</h3>
        <pre><code class="php">
&lt;?php
if( !defined( 'PHP_EOL') ) : // Si la constante PHP_EOL n'existe pas (http://php.net/manual/fr/reserved.constants.php), 
    if( strtoupper( substr( PHP_OS, 0, 3 ) ) == 'WIN' ) : // Si la version du système d'exploitation (fournie par la constantes pré-définie PHP_OS) correspond à un noyau Windows,
        define( 'PHP_EOL', "\r\n" ); // On définit la constante avec les caractères Windows.
    else : // Sinon,
        define( 'PHP_EOL', "\n" ); // On définit la constante avec les caractères UNIX.
    endif;
endif;

define( 'DIRNAME', dirname( realpath( basename( $_SERVER['PHP_SELF'] ) ) ) . '\\' );  // On définit le chemin physique du fichier pour pouvoir le réexploiter plus tard sans avoir à la saisir à nouveau. Ce chemin est basé sur celui du script que nous sommes en train d'éxecuter (http://php.net/manual/fr/function.realpath.php).
define( 'FILENAME', 'data.txt' ); // On définit le nom du fichier pour pouvoir le réexploiter plus tard sans avoir à la saisir à nouveau.
define( 'NBSENTENCES', 8 ); // On définit le nombre de phrases.


/**
 * getSentences - Récupère le contenu d'un fichier pour le stocker dans un tableau
 * @param   string  $file
 * @param   string  $dir
 * @return  mixed (array/bool)
**/
function getSentences( $file, $dir ) {
    if( file_exists( $dir . $file ) ) : // Si le fichier existe (http://php.net/manual/fr/function.file-exists.php),
        if( ( $_resrc_file = fopen( $dir . $file, 'r' ) )!==false ) : // On ouvre le fichier en mode lecture seule et récupère la ressource.
            $_arr_strings = array( array() );
            while( !feof( $_resrc_file ) ) : // Tant que l'on n'a pas atteind la fin du fichier,
                if( ( $_line = fgets( $_resrc_file ) )==PHP_EOL ) : // S'il n'y a pas eu d'erreur et si cette ligne estune ligne de séparation,
                    $_arr_strings[] = array(); // On crée une nouvelle entrée dans le tableau.
                endif;

                $_arr_strings[count( $_arr_strings )-1][] = $_line; // On stocke la ligne
            endwhile;

            return $_arr_strings;
        else : // Sinon,
            echo '&lt;div class="block error"&gt;Le fichier "' . $file . '" ne peut pas être ouvert.&lt;/div&gt;'; // On affiche un message d'erreur indiquant une erreur d'ouverture.
        endif;
    else : // Sinon,
        echo '&lt;div class="block error"&gt;Le fichier "' . $file . '" n\'existe pas dans le dossier "' . $dir . '".&lt;/div&gt;'; // On affiche un message d'erreur indiquant que le fichier n'existe pas.
    endif;

    return false;
}

/**
 * makeSpeech - Compose un discours aléatoirement
 * @param   array   $_arr_strings
 * @param   int     $iteration
 * @return  string
**/
function makeSpeech( $_arr_strings, $iteration ) {
    $speech = '';

    if( isset( $_arr_strings[0][0] ) ) : // Si la première clé existe,
        $speech .= $_arr_strings[0][0]; // On l'affiche.
        unset( $_arr_strings[0][0] ); // On supprime l'entrée dans le tableau pour ne plus pouvoir l'utiliser.
    endif;

    for( $i = 0; $i&lt;$iteration; $i++ ) : // Pour le nombre de phrases défini,
        foreach( $_arr_strings as $keyGroup =&gt; $group ) : // Pour chaque groupe de morceaux de phrase,
            if( !( $i===0 && $keyGroup===0 ) ) : // Si on ne débute pas le discours (nous avons déjà affiché "Mesdames, messieurs" donc nous sautons le premier groupe),
                $_keyRand = array_rand( $group ); // On sélectionne un morceau aléatoirement.
                $speech .= $group[$_keyRand]; // On affiche ce morceau de phrase.
                unset( $_arr_strings[$keyGroup][$_keyRand] ); // On supprime l'entrée dans le tableau pour ne plus pouvoir l'utiliser.
            endif;
        endforeach;
        $speech .= '&lt;br /&gt;';
    endfor;

    return $speech;
}</code>
<code class="php">
&lt;?php
if( ( $sentences = getSentences( FILENAME, DIRNAME ) )!==false )
    echo makeSpeech( $sentences, NBSENTENCES );</code></pre>
    </body>
</html>