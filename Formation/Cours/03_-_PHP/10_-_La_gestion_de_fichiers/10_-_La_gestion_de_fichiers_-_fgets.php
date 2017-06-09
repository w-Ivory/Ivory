<?php
$cheminFichier = 'Test.txt';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0" />
        <title>La gestion de fichiers - Lecture ligne à ligne via fgets()</title>

        <!-- // highlight.js : Coloration syntaxique du code -->
        <link rel="stylesheet" type="text/css" href="../../_assets/plugins/highlight/styles/monokai_sublime.css">
        <script type="text/javascript" src="../../_assets/plugins/highlight/highlight.pack.js"></script>
        <script type="text/javascript">
            hljs.initHighlightingOnLoad();
        </script>
        <!-- // -->

        <link rel="stylesheet" type="text/css" href="../../_assets/css/style.css">
    </head>
    <body>
        <h1>La gestion de fichiers - Lecture ligne à ligne via fgets()</h1>
        <a href="../10_-_La_gestion_de_fichiers.php" style="color:rgb(0,0,0);" title="">&larr; Retour au cours</a>
        <hr />
        <h2>Lecture ligne à ligne du fichier <?php echo $cheminFichier; ?> :</h2>
        <p>
        <?php
        if( file_exists( $cheminFichier ) ) :
            $ressourceFichier = fopen( $cheminFichier, 'r' );
            echo nl2br( fgets( $ressourceFichier ) );
            fclose( $ressourceFichier );
        endif;
        ?>
        </p>
        <pre><code class="php">
&lt;?php
$cheminFichier = 'Test.txt'; // On définit le chemin vers le fichier.

if( file_exists( $cheminFichier ) ) : // Si le fichier existe,
    $ressourceFichier = fopen( $cheminFichier, 'r' ); // On ouvre le fichier cible en lecture seule et on stocke cette ressource dans une variable (http://php.net/manual/fr/function.fopen.php).
    echo nl2br( fgets( $ressourceFichier ) ); // On affiche le contenu de la ligne désignée par le curseur dans le fichier en prenant soin de remplacer les retours à la ligne textuels par de retours à la ligne HTML (nl2br) (http://php.net/manual/fr/function.fgets.php).
    fclose( $ressourceFichier ); // On ferme la ressource ouverte sur le fichier (http://php.net/manual/fr/function.fclose.php).
endif;
?&gt;</code></pre>
        <p><em>Il faut donc utiliser une boucle pour lire l'ensemble du fichier.</em></p>
        <p>
        <?php
        if( file_exists( $cheminFichier ) ) :
            $ressourceFichier = fopen( $cheminFichier, 'r' );
            while( !feof( $ressourceFichier ) ) {
                echo nl2br( fgets( $ressourceFichier ) );
            }
            fclose( $ressourceFichier );
        endif;
        ?>
        </p>
        <pre><code class="php">
&lt;?php
$cheminFichier = 'Test.txt'; // On définit le chemin vers le fichier.

if( file_exists( $cheminFichier ) ) : // Si le fichier existe,
    $ressourceFichier = fopen( $cheminFichier, 'r' ); // On ouvre le fichier cible en lecture seule et on stocke cette ressource dans une variable (http://php.net/manual/fr/function.fopen.php).
    while( !feof( $ressourceFichier ) ) { // Tant que l'on n'a pas atteint la fin du fichier (http://php.net/manual/fr/function.feof.php),
        echo nl2br( fgets( $ressourceFichier ) ); // On affiche le contenu de la ligne désignée par le curseur dans le fichier en prenant soin de remplacer les retours à la ligne textuels par de retours à la ligne HTML (nl2br) (http://php.net/manual/fr/function.fgets.php).
    }
    fclose( $ressourceFichier ); // On ferme la ressource ouverte sur le fichier (http://php.net/manual/fr/function.fclose.php).
endif;
?&gt;</code></pre>
    </body>
</html>