<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0" />
        <title>Arborescence | La gestion de fichiers - Mise en pratique</title>

        <link rel="stylesheet" type="text/css" href="../../_assets/css/style.css">

        <!-- // highlight.js : Coloration syntaxique du code -->
        <link rel="stylesheet" type="text/css" href="../../_assets/plugins/highlight/styles/monokai_sublime.css">
        <script type="text/javascript" src="../../_assets/plugins/highlight/highlight.pack.js"></script>
        <script type="text/javascript">
            hljs.initHighlightingOnLoad();
        </script>
        <!-- // -->
    </head>
    <body>
        <h1 id="ex1">Arborescence | La gestion de fichiers - Mise en pratique</h1>
        <hr />
        <h2>Première partie :</h2>
        <p><em>Faire un programme qui affiche tous les fichiers d'un dossier.<br />Chaque fichier listé devra être lié à une page qui affichera son contenu.</em></p>
        <?php
        define( 'DIRNAME', '10_-_La_gestion_de_fichiers_-_Arborescence/' ); // On définit le chemin du dossier à scanner.

        /**
         * listFiles - Liste les fichiers dans un répertoire
         * @param   string  $dir
         * @return  string
        **/
        function listFiles( $dir ) {
            $_str = '';

            if( file_exists( $dir ) ) : // Si le chemin passé en paramètre existe physiquement (http://php.net/manual/fr/function.file-exists.php),
                if( is_dir( $dir ) ) : // Si le chemin passé en paramètre est un dossier (http://php.net/manual/fr/function.is-dir.php),
                    if( ( $_resrc_dir = opendir( $dir ) )!==false ) : // Si on parvient à ouvrir le dossier,
                        $_str .= '<ul><li><strong>' . basename( $dir ) . '</strong><ul>';
                        while( ( $_entry = readdir( $_resrc_dir ) )!==false ) : // Tant qu'il existe des entrées dans le dossier,
                            if( is_file( $dir . $_entry ) ) : // Si cette entrée est un véritable fichier et non un dossier,
                                $_str .= '<li><a href="?f=' . $dir . $_entry . '#ex1" title="">' . $_entry . '</a></li>';
                            endif;
                        endwhile;
                        $_str .= '</ul></li></ul>';
                        closedir( $_resrc_dir ); // On ferme la ressource sur le dossier.
                    else : echo $dir . ' n\'est pas accessible<br />';
                    endif;
                else : echo '<em>' . $dir . '</em> n\'est pas un répertoire<br />';
                endif;
            else : echo '<em>' . $dir . '</em> n\'existe pas<br />';
            endif;

            return $_str;
        }

        echo listFiles( DIRNAME );
        ?>
        <?php if( isset( $_GET ) && array_key_exists( 'f', $_GET ) ) : // Si on fait passer un nom de fichier dans l'URL, ?>
        <h2>Contenu du fichier <em><small><?php echo $_GET['f']; ?></small></em> :</h2>
        <pre><code class="txt">
<?php
if( file_exists( $_GET['f'] ) && is_file( $_GET['f'] ) ) : // Si ce fichier existe et est un véritable fichier,
    if( ( $_resrc_file = fopen( $_GET['f'], 'r' ) )!==false ) : // Si on parvient à ouvrir le fichier,
        echo nl2br( fread( $_resrc_file, filesize( $_GET['f'] ) ) ); // On affiche tout son contenu.
        fclose( $_resrc_file ); // On ferme la ressource sur le fichier.
    else :
         echo 'Le fichier <em>' . $_GET['f'] . '</em> ne peut pas être ouvert.<br />';
    endif;
endif;
?></code></pre>
        <?php endif; ?>
        <pre><code class="php">
&lt;?php
define( 'DIRNAME', '10_-_La_gestion_de_fichiers_-_Arborescence/' ); // On définit le chemin du dossier à scanner.

/**
 * listFiles - Liste les fichiers dans un répertoire
 * @param   string  $dir
 * @return  string
**/
function listFiles( $dir ) {
    $_str = '';

    if( file_exists( $dir ) ) : // Si le chemin passé en paramètre existe physiquement (http://php.net/manual/fr/function.file-exists.php),
        if( is_dir( $dir ) ) : // Si le chemin passé en paramètre est un dossier (http://php.net/manual/fr/function.is-dir.php),
            if( ( $_resrc_dir = opendir( $dir ) )!==false ) : // Si on parvient à ouvrir le dossier,
                $_str .= '&lt;ul&gt;&lt;li&gt;&lt;strong&gt;' . basename( $dir ) . '&lt;/strong&gt;&lt;ul&gt;';
                while( ( $_entry = readdir( $_resrc_dir ) )!==false ) : // Tant qu'il existe des entrées dans le dossier,
                    if( is_file( $dir . $_entry ) ) : // Si cette entrée est un véritable fichier et non un dossier,
                        $_str .= '&lt;li&gt;&lt;a href="?f=' . $dir . $_entry . '#ex1" title=""&gt;' . $_entry . '&lt;/a&gt;&lt;/li&gt;';
                    endif;
                endwhile;
                $_str .= '&lt;/ul&gt;&lt;/li&gt;&lt;/ul&gt;';
                closedir( $_resrc_dir ); // On ferme la ressource sur le dossier.
            else : echo $dir . ' n\'est pas accessible&lt;br /&gt;';
            endif;
        else : echo '&lt;em&gt;' . $dir . '&lt;/em&gt; n\'est pas un répertoire&lt;br /&gt;';
        endif;
    else : echo '&lt;em&gt;' . $dir . '&lt;/em&gt; n\'existe pas&lt;br /&gt;';
    endif;

    return $_str;
}

echo listFiles( DIRNAME );
<?php if( isset( $_GET ) && array_key_exists( 'f', $_GET ) ) : ?>

if( isset( $_GET ) && array_key_exists( 'f', $_GET ) ) : // Si un nom de fichier est passé en GET,
    if( file_exists( $_GET['f'] ) && is_file( $_GET['f'] ) ) : // Si ce fichier existe et est un véritable fichier,
        if( ( $_resrc_file = fopen( $_GET['f'], 'r' ) )!==false ) : // Si on parvient à ouvrir le fichier,
            echo nl2br( fread( $_resrc_file, filesize( $_GET['f'] ) ) ); // On affiche tout son contenu.
            fclose( $_resrc_file ); // On ferme la ressource sur le fichier.
        else :
             echo 'Le fichier &lt;em&gt;' . $_GET['f'] . '&lt;/em&gt; ne peut pas être ouvert.&lt;br /&gt;';
        endif;
    endif;
endif;
<?php endif; ?></code></pre>
        <p class="alert"><em>Une autre méthode pourrait être d'utiliser la fonction "<a href="http://php.net/manual/fr/function.scandir.php" target="_blank" title="">scandir()</a>" pour lister les fichiers du dossier.</em></p>
        <pre><code class="php">
&lt;?php
define( 'DIRNAME', '10_-_La_gestion_de_fichiers_-_Arborescence/' ); // On définit le chemin du dossier à scanner.

/**
 * listFiles - Liste les fichiers dans un répertoire
 * @param   string  $dir
 * @return  string
**/
function listFiles( $dir ) {
    $_str = '';

    if( file_exists( $dir ) ) : // Si le chemin passé en paramètre existe physiquement (http://php.net/manual/fr/function.file-exists.php),
        if( is_dir( $dir ) ) : // Si le chemin passé en paramètre est un dossier (http://php.net/manual/fr/function.is-dir.php),
            $_str .= '&lt;ul&gt;&lt;li&gt;&lt;strong&gt;' . basename( $dir ) . '&lt;/strong&gt;&lt;ul&gt;';
            foreach( scandir( $dir ) as $_entry ) : // Pour toutes les entrées scannées (http://php.net/manual/fr/function.scandir.php),
                if( is_file( $dir . $_entry ) ) : // Si cette entrée est un véritable fichier et non un dossier,
                    $_str .= '&lt;li&gt;&lt;a href="?f=' . $dir . $_entry . '#ex1" title=""&gt;' . $_entry . '&lt;/a&gt;&lt;/li&gt;';
                endif;
            endforeach;
            $_str .= '&lt;/ul&gt;&lt;/li&gt;&lt;/ul&gt;';
        else : echo '&lt;em&gt;' . $dir . '&lt;/em&gt; n\'est pas un répertoire&lt;br /&gt;';
        endif;
    else : echo '&lt;em&gt;' . $dir . '&lt;/em&gt; n\'existe pas&lt;br /&gt;';
    endif;

    return $_str;
}
echo listFiles( $dossierSource );
<?php if( isset( $_GET ) && array_key_exists( 'f', $_GET ) ) : ?>

if( isset( $_GET ) && array_key_exists( 'f', $_GET ) ) : // Si un nom de fichier est passé en GET,
    if( file_exists( $_GET['f'] ) && is_file( $_GET['f'] ) ) : // Si ce fichier existe et est un véritable fichier,
        if( ( $_resrc_file = fopen( $_GET['f'], 'r' ) )!==false ) : // Si on parvient à ouvrir le fichier,
            echo nl2br( fread( $_resrc_file, filesize( $_GET['f'] ) ) ); // On affiche tout son contenu.
            fclose( $_resrc_file ); // On ferme la ressource sur le fichier.
        else :
             echo 'Le fichier &lt;em&gt;' . $_GET['f'] . '&lt;/em&gt; ne peut pas être ouvert.&lt;br /&gt;';
        endif;
    endif;
endif;
<?php endif; ?></code></pre>
        <hr />
        <h2 id="ex2">Deuxième partie :</h2>
        <p><em>Reprendre le code de la partie précédente et le transformer pour qu'il affiche tous les fichiers de tous les sous-dossiers du répertoire principal, <strong>en respectant l'arborescence</strong>.</em></p>
        <?php
        //define( 'DIRNAME', '10_-_La_gestion_de_fichiers_-_Arborescence/' ); // On définit le chemin du dossier à scanner.

        /**
         * listFilesRec - Liste les fichiers dans un répertoire de manière recursive
         * @param   string  $dir
         *          string  $start (optional)
         *          string  $finish (optional)
         * @return  string
        **/
        function listFilesRec( $dir, $start='<ul>', $finish='</ul>' ) {
            $_str = '';

            if( file_exists( $dir ) ) : // Si le chemin passé en paramètre existe physiquement (http://php.net/manual/fr/function.file-exists.php),
                if( is_dir( $dir ) ) : // Si le chemin passé en paramètre est un dossier (http://php.net/manual/fr/function.is-dir.php),
                    if( ( $_resrc_dir = opendir( $dir ) )!==false ) : // Si on parvient à ouvrir le dossier,
                        $_str .= $start . '<li><strong>' . basename( $dir ) . '</strong><ul>';
                        while( ( $_entry = readdir( $_resrc_dir ) )!==false ) : // Tant qu'il existe des entrées dans le dossier,
                            $_ds = ( substr( $dir, -1 )=='/' ? '' : '/' ); // On définit s'il faut ajouter un séparateur de dossier.
                            if( is_file( $dir . $_ds . $_entry ) ) : // Si cette entrée est un véritable fichier et non un dossier,
                                $_str .= '<li><a href="?frec=' . $dir . $_ds . $_entry . '#ex2" title="">' . $_entry . '</a></li>';
                            elseif( is_dir( $dir . $_ds . $_entry ) && $_entry!='.' && $_entry!='..' ) : // Sinon, si cette entrée est un dossier et qu'il est différent du lien symbolique se représentant lui-même (.) ou représentant le dossier parent (..),
                                $_str .= listFilesRec( $dir . $_ds . $_entry . ( substr( $_entry, -1 )=='/' ? '' : '/' ), '', '' ); // On procède à l'appel récursif.
                            endif;
                        endwhile;
                        $_str .= '</ul></li>' . $finish;
                        closedir( $_resrc_dir );
                    else : echo $dir . ' n\'est pas accessible<br />';
                    endif;
                else : echo '"<em>' . $dir . '</em>" n\'est pas un répertoire<br />';
                endif;
            else : echo '<em>' . $dir . '</em> n\'existe pas<br />';
            endif;

            return $_str;
        }

        echo listFilesRec( DIRNAME );
        ?>
        <?php if( isset( $_GET ) && array_key_exists( 'frec', $_GET ) ) : ?>
        <h2>Contenu du fichier <em><small><?php echo basename( $_GET['frec'] ); ?></small></em> :</h2>
        <pre><code class="txt">
<?php
$cheminFichier = $_GET['frec'];

if( file_exists( $cheminFichier ) ) :
    $ressourceFichier = fopen( $cheminFichier, 'r' );
    echo nl2br( fread( $ressourceFichier, filesize( $cheminFichier ) ) );
    fclose( $ressourceFichier );
endif;
?></code></pre>
        <?php endif; ?>
        <pre><code class="php">
&lt;?php
define( 'DIRNAME', '10_-_La_gestion_de_fichiers_-_Arborescence/' ); // On définit le chemin du dossier à scanner.

/**
 * listFilesRec - Liste les fichiers dans un répertoire de manière recursive
 * @param   string  $dir
 *          string  $start (optional)
 *          string  $finish (optional)
 * @return  string
**/
function listFilesRec( $dir, $start='&lt;ul&gt;', $finish='&lt;/ul&gt;' ) {
    $_str = '';

    if( file_exists( $dir ) ) : // Si le chemin passé en paramètre existe physiquement (http://php.net/manual/fr/function.file-exists.php),
        if( is_dir( $dir ) ) : // Si le chemin passé en paramètre est un dossier (http://php.net/manual/fr/function.is-dir.php),
            if( ( $_resrc_dir = opendir( $dir ) )!==false ) : // Si on parvient à ouvrir le dossier,
                $_str .= $start . '&lt;li&gt;&lt;strong&gt;' . basename( $dir ) . '&lt;/strong&gt;&lt;ul&gt;';
                while( ( $_entry = readdir( $_resrc_dir ) )!==false ) : // Tant qu'il existe des entrées dans le dossier,
                    $_ds = ( substr( $dir, -1 )=='/' ? '' : '/' ); // On définit s'il faut ajouter un séparateur de dossier.
                    if( is_file( $dir . $_ds . $_entry ) ) : // Si cette entrée est un véritable fichier et non un dossier,
                        $_str .= '&lt;li&gt;&lt;a href="?frec=' . $dir . $_ds . $_entry . '#ex2" title=""&gt;' . $_entry . '&lt;/a&gt;&lt;/li&gt;';
                    elseif( is_dir( $dir . $_ds . $_entry ) && $_entry!='.' && $_entry!='..' ) : // Sinon, si cette entrée est un dossier et qu'il est différent du lien symbolique se représentant lui-même (.) ou représentant le dossier parent (..),
                        $_str .= listFilesRec( $dir . $_ds . $_entry . ( substr( $_entry, -1 )=='/' ? '' : '/' ), '', '' ); // On procède à l'appel récursif.
                    endif;
                endwhile;
                $_str .= '&lt;/ul&gt;&lt;/li&gt;' . $finish;
                closedir( $_resrc_dir );
            else : echo $dir . ' n\'est pas accessible&lt;br /&gt;';
            endif;
        else : echo '"&lt;em&gt;' . $dir . '&lt;/em&gt;" n\'est pas un répertoire&lt;br /&gt;';
        endif;
    else : echo '&lt;em&gt;' . $dir . '&lt;/em&gt; n\'existe pas&lt;br /&gt;';
    endif;

    return $_str;
}

echo listFilesRec( DIRNAME );
<?php if( isset( $_GET ) && array_key_exists( 'frec', $_GET ) ) : ?>

if( isset( $_GET ) && array_key_exists( 'frec', $_GET ) ) : // Si un nom de fichier est passé en GET,
    if( file_exists( $_GET['frec'] ) && is_file( $_GET['frec'] ) ) : // Si ce fichier existe et est un véritable fichier,
        if( ( $_resrc_file = fopen( $_GET['frec'], 'r' ) )!==false ) : // Si on parvient à ouvrir le fichier,
            echo nl2br( fread( $_resrc_file, filesize( $_GET['frec'] ) ) ); // On affiche tout son contenu.
            fclose( $_resrc_file ); // On ferme la ressource sur le fichier.
        else :
             echo 'Le fichier &lt;em&gt;' . $_GET['frec'] . '&lt;/em&gt; ne peut pas être ouvert.&lt;br /&gt;';
        endif;
    endif;
endif;
<?php endif; ?></code></pre>
        <p class="alert"><em>Une autre méthode pourrait être d'utiliser la fonction "<a href="http://php.net/manual/fr/function.scandir.php" target="_blank" title="">scandir()</a>" pour lister les fichiers du dossier.</em></p>
        <pre><code class="php">
&lt;?php
define( 'DIRNAME', '10_-_La_gestion_de_fichiers_-_Arborescence/' ); // On définit le chemin du dossier à scanner.

/**
 * listFilesRec - Liste les fichiers dans un répertoire de manière recursive
 * @param   string  $dir
 *          string  $start (optional)
 *          string  $finish (optional)
 * @return  string
**/
function listFilesRec( $dir, $start='&lt;ul&gt;', $finish='&lt;/ul&gt;' ) {
    $_str = '';

    if( file_exists( $dir ) ) : // Si le chemin passé en paramètre existe physiquement (http://php.net/manual/fr/function.file-exists.php),
        if( is_dir( $dir ) ) : // Si le chemin passé en paramètre est un dossier (http://php.net/manual/fr/function.is-dir.php),
            if( ( $_resrc_dir = opendir( $dir ) )!==false ) : // Si on parvient à ouvrir le dossier,
                $_str .= $start . '&lt;li&gt;&lt;strong&gt;' . basename( $dir ) . '&lt;/strong&gt;&lt;ul&gt;';
                foreach( scandir( $dir ) as $_entry ) : // Pour toutes les entrées scannées (http://php.net/manual/fr/function.scandir.php),
                    $_ds = ( substr( $dir, -1 )=='/' ? '' : '/' ); // On définit s'il faut ajouter un séparateur de dossier.
                    if( is_file( $dir . $_ds . $_entry ) ) : // Si cette entrée est un véritable fichier et non un dossier,
                        $_str .= '&lt;li&gt;&lt;a href="?frec=' . $dir . $_ds . $_entry . '#ex2" title=""&gt;' . $_entry . '&lt;/a&gt;&lt;/li&gt;';
                    elseif( is_dir( $dir . $_ds . $_entry ) && $_entry!='.' && $_entry!='..' ) : // Sinon, si cette entrée est un dossier et qu'il est différent du lien symbolique se représentant lui-même (.) ou représentant le dossier parent (..),
                        $_str .= listFilesRec( $dir . $_ds . $_entry . ( substr( $_entry, -1 )=='/' ? '' : '/' ), '', '' ); // On procède à l'appel récursif.
                    endif;
                endforeach;
                $_str .= '&lt;/ul&gt;&lt;/li&gt;' . $finish;
                closedir( $_resrc_dir );
            else : echo $dir . ' n\'est pas accessible&lt;br /&gt;';
            endif;
        else : echo '"&lt;em&gt;' . $dir . '&lt;/em&gt;" n\'est pas un répertoire&lt;br /&gt;';
        endif;
    else : echo '&lt;em&gt;' . $dir . '&lt;/em&gt; n\'existe pas&lt;br /&gt;';
    endif;

    return $_str;
}

echo listFilesRec( DIRNAME );
<?php if( isset( $_GET ) && array_key_exists( 'frec', $_GET ) ) : ?>

if( isset( $_GET ) && array_key_exists( 'frec', $_GET ) ) : // Si un nom de fichier est passé en GET,
    if( file_exists( $_GET['frec'] ) && is_file( $_GET['frec'] ) ) : // Si ce fichier existe et est un véritable fichier,
        if( ( $_resrc_file = fopen( $_GET['frec'], 'r' ) )!==false ) : // Si on parvient à ouvrir le fichier,
            echo nl2br( fread( $_resrc_file, filesize( $_GET['frec'] ) ) ); // On affiche tout son contenu.
            fclose( $_resrc_file ); // On ferme la ressource sur le fichier.
        else :
             echo 'Le fichier &lt;em&gt;' . $_GET['frec'] . '&lt;/em&gt; ne peut pas être ouvert.&lt;br /&gt;';
        endif;
    endif;
endif;
<?php endif; ?></code></pre>
    </body>
</html>