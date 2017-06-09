<?php
session_start();

if( isset( $_GET ) && array_key_exists( 'destroy', $_GET ) ) :
    session_destroy();
    $page = $_SERVER['PHP_SELF'];
    // header( 'Refresh:0; url=' . $page );
    header( 'Location:' . $page );
    exit();
endif;
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0" />
        <title>Les sessions - Page 2</title>

        <!-- // highlight.js : Coloration syntaxique du code -->
        <link rel="stylesheet" type="text/css" href="../../../_assets/plugins/highlight/styles/monokai_sublime.css">
        <script type="text/javascript" src="../../../_assets/plugins/highlight/highlight.pack.js"></script>
        <script type="text/javascript">
            hljs.initHighlightingOnLoad();
        </script>
        <!-- // -->

        <link rel="stylesheet" type="text/css" href="../../../_assets/css/style.css">
    </head>
    <body>
        <h1>Les sessions - Page 2</h1>
        <a href="../09_-_Les_sessions.php" style="color:rgb(0,0,0);" title="">&larr; Retour au cours</a>
        <hr />
        <h2>Traitement des données présentes en session :</h2>
        <p>
        <?php
        if( isset( $_SESSION ) && ( array_key_exists( 'prenom', $_SESSION ) || array_key_exists( 'nom', $_SESSION ) ) ) :
            echo 'Bonjour';
            if( array_key_exists( 'prenom', $_SESSION ) ) echo ' ' . $_SESSION['prenom'];
            if( array_key_exists( 'nom', $_SESSION ) ) echo ' ' . $_SESSION['nom'];
            echo ' ! ';
        else :
            echo 'Aucune donnée de nom et prénom n\'a été passée !';
        endif;
        ?>
        </p>
        <pre><code class="php">
&lt;?php
session_start(); // Démarrage de la session.

if( isset( $_GET ) && array_key_exists( 'destroy', $_GET ) ) : // Si la clé "destroy" est passée en paramètre dans l'URL,
    session_destroy(); // On détruit la session pour vider l'historique (http://php.net/manual/fr/function.session-destroy.php).
    $page = $_SERVER['PHP_SELF']; // On utilise la superglobale "$_SERVER" pour récupérer le nom de la page en cours d'utilisation (http://php.net/manual/fr/reserved.variables.server.php).
    // header( 'Refresh:0; url=' . $page ); // On utilise la fonction "header" pour rafraichir vers une autre page (http://php.net/manual/fr/function.header.php).
    header( 'Location:' . $page ); // On utilise la fonction "header" pour rediriger vers une autre page (http://php.net/manual/fr/function.header.php).
    exit(); // On indique au script de s'arrêter immédiatement sans poursuivre le script
endif;

if( isset( $_SESSION ) && ( array_key_exists( 'prenom', $_SESSION ) || array_key_exists( 'nom', $_SESSION ) ) ) : // Si la superglobale $_SESSION existe ET l'une des clés "prenom" OU "nom" existent dans le tableau de la superglobale,
    echo 'Bonjour'; // On affiche la chaîne de caractères.
    if( array_key_exists( 'prenom', $_SESSION ) ) echo ' ' . $_SESSION['prenom']; // Si la clé "prenom" existe dans le tableau de la superglobale, on affiche la valeur contenue à la clé "prenom".
    if( array_key_exists( 'nom', $_SESSION ) ) echo ' ' . $_SESSION['nom']; // Si la clé "nom" existe dans le tableau de la superglobale, on affiche la valeur contenue à la clé "nom".
    echo ' ! ';
else : // Sinon,
    echo 'Aucune donnée de nom et prénom n\'a été passée !';
endif;
?&gt;</code></pre>
        <p class="block alert"><em>Aucune donnée a été transmise, que ce soit via l'URL ou via un formulaire. Elles ont juste été stockées en session dans la page précédente et sont maintenant disponible dans toutes les pages.</em></p>
    </body>
</html>