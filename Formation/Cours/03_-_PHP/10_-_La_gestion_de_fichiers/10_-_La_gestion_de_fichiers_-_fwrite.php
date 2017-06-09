<?php
$cheminFichier = 'monPremierFichier.txt';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0" />
        <title>La gestion de fichiers - Écriture via fwrite()</title>

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
        <h1>La gestion de fichiers - Écriture via fwrite()</h1>
        <a href="../10_-_La_gestion_de_fichiers.php" style="color:rgb(0,0,0);" title="">&larr; Retour au cours</a>
        <hr />
        <h2>Écriture dans le fichier <?php echo $cheminFichier; ?> :</h2>
        <p>
        <?php
        $ressourceFichier = fopen( $cheminFichier, 'a' );
        fwrite( $ressourceFichier, 'Hello world !' );
        fclose( $ressourceFichier );
        ?>
        </p>
        <pre><code class="php">
&lt;?php
$cheminFichier = 'monPremierFichier.txt'; // On définit le chemin vers le fichier.

$ressourceFichier = fopen( $cheminFichier, 'a' ); // On ouvre le fichier cible en écriture seule et on stocke cette ressource dans une variable (http://php.net/manual/fr/function.fopen.php). Si le fichier n'existe pas, il sera créé.
fwrite( $ressourceFichier, 'Hello world !' ); // On écrit dans le fichier (http://php.net/manual/fr/function.fwrite.php).
fclose( $ressourceFichier ); // On ferme la ressource ouverte sur le fichier (http://php.net/manual/fr/function.fclose.php).
?&gt;</code></pre>
        <h3>Résultat :</h3>
        <p>
        <?php
        if( file_exists( $cheminFichier ) ) :
            $ressourceFichier = fopen( $cheminFichier, 'r' );
            echo nl2br( fread( $ressourceFichier, filesize( $cheminFichier ) ) );
            fclose( $ressourceFichier );
        endif;
        ?>
        </p>
    </body>
</html>