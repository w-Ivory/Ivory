<?php
$cheminFichier = 'Test.pdf';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0" />
        <title>La gestion de fichiers - Lecture complète via fread()</title>

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
        <h1>La gestion de fichiers - Lecture complète via fread()</h1>
        <a href="../10_-_La_gestion_de_fichiers.php" style="color:rgb(0,0,0);" title="">&larr; Retour au cours</a>
        <hr />
        <h2>Lecture du fichier <?php echo $cheminFichier; ?> :</h2>
        <p>
        <?php
        if( file_exists( $cheminFichier ) ) :
            $ressourceFichier = fopen( $cheminFichier, 'r' );
            echo nl2br( fread( $ressourceFichier, filesize( $cheminFichier ) ) );
            fclose( $ressourceFichier );
        endif;
        ?>
        </p>
        <pre><code class="php">
&lt;?php
$cheminFichier = 'Webdevelopment - Bilan 1 - Soluce.pdf'; // On définit le chemin vers le fichier.

if( file_exists( $cheminFichier ) ) : // Si le fichier existe,
    $ressourceFichier = fopen( $cheminFichier, 'r' ); // On ouvre le fichier cible en lecture seule et on stocke cette ressource dans une variable (http://php.net/manual/fr/function.fopen.php).
    echo nl2br( fread( $ressourceFichier, filesize( $cheminFichier ) ) ); // On affiche le contenu de tout le fichier en prenant soin de remplacer les retours à la ligne textuels par de retours à la ligne HTML (nl2br). On utilise la fonction "filesize()" qui nous retourne la taille du fichier en octets. (http://php.net/manual/fr/function.fread.php)
    fclose( $ressourceFichier ); // On ferme la ressource ouverte sur le fichier (http://php.net/manual/fr/function.fclose.php).
endif;
?&gt;</code></pre>
    </body>
</html>