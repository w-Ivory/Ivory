<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0" />
        <title>La temporisation de sortie</title>

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
        <h1>La temporisation de sortie</h1>
        <p><em>La temporisation de sortie est un système permettant de retarder l'affichage des informations de contenu d'une page. Cette technique est aussi communément appelée "bufferisation de sortie" ou "output buffering".</em></p>
        <hr />
        <h2>L'output buffering : ob</h2>
        <h3>Initialiser et vider le tampon de sortie</h3>
        <p><em>Dans le principe, toutes les instructions qui vont être inscrites à partir de l'initialisation du tampon de sortie ne seront affichées à l'écran qu'après la fermeture du tampon de sortie.</em></p>
        <pre><code class="php">
&lt;?php
ob_start(); // On initialise le tampon de sortie.
echo '&lt;p&gt;Lorem ipsum dolor sit amet&lt;/p&gt;'; // On ajoute une balise HTML et du texte au tampon de sortie.
ob_end_flush(); // On affiche le contenu du tampon de sortie et le vide.
?&gt;</code></pre>
        <h3>Récupérer le tampon de sortie dans une variable</h3>
        <p><em>Bien que l'on ait retardé la sortie écran du code ci-dessus, nous n'avons pas fait gagner de ressource au système. Comment mieux exploiter cette ressource de sortie alors ? Grâce à une variable :</em></p>
        <pre><code class="php">
&lt;?php
ob_start(); // On initialise le tampon de sortie.
echo '&lt;p&gt;Lorem ipsum dolor sit amet&lt;/p&gt;'; // On ajoute une balise HTML et du texte au tampon de sortie.
$tampon = ob_get_contents(); // On stocke le résultat des instructions précéentes dans une variable.
ob_end_clean(); // On ferme le tampon de sortie et le vide.

echo $tampon; // On affiche le contenu de la variable.
?&gt;</code></pre>
        <p><em>Donc si au lieu d'afficher directement le contenu de cette variable, on récupérait cette chaîne de caractères et on la stockait dans un fichier ? On pourrait peut-être ainsi par la suite lire ce fichier ?</em></p>
        <h3>Récupérer le tampon de sortie dans un fichier</h3>
        <pre><code class="php">
&lt;?php
ob_start(); // On initialise le tampon de sortie.
echo '&lt;p&gt;Lorem ipsum dolor sit amet&lt;/p&gt;'; // On ajoute une balise HTML et du texte au tampon de sortie.
$tampon = ob_get_contents(); // On stocke le résultat des instructions précéentes dans une variable.
ob_end_clean(); // On ferme le tampon de sortie et le vide.
file_put_contents( 'cache/tampon.html', $tampon ); // On crée un fichier "tampon.html" dans un sous-dossier pour y écrire le contenu de la variable. Si le fichier existe déjà, la fonction le remplacera.

readfile( 'cache/tampon.html' ); // On lit le fichier "tampon.html" et affiche son contenu.
?&gt;</code></pre>
        <p><em>Jusqu'à présent, tout ce que nous avons fait est de stocker les informations de sortie dans un fichier que nous lisons par la suite. Nous avons donc ajouter du code et créer des instructions en plus. Alors en quoi cela est-il plus efficace ?<br />C'est vrai, pour l'instant nous consommons encore plus de ressources sur notre serveur ! Néanmoins, nous venons de créer un fichier de cache ... il ne nous reste plus qu'à l'exploiter correctement s'il existe déjà !</em></p>
        <pre><code class="php">
&lt;?php
$cacheFic = 'cache/tampon.html'; // On crée une variable qui va contenir le chemin d'accès au fichier de cache.
$expire = time()-60; // On va déterminer un délai d'expiration d'une heure : la fonction "time()" nous retourne l'heure courante à l'instant T au format timestamp (http://php.net/manual/fr/function.time.php).

if( file_exists( $cacheFic ) && filemtime( $cacheFic ) > $expire ) : // Si le fichier existe ET si la date de création du fichier est supérieure à la date d'expiration (soit maintenant moins soixante secondes),
    readfile( $cacheFic ); // On utilise le fichier de cache.
else : // Sinon,
    ob_start(); // On initialise une temporisation de sortie.

    echo '&lt;p&gt;Lorem ipsum dolor sit amet&lt;/p&gt;'; // On ajoute une balise HTML et du texte au tampon de sortie.

    $tampon = ob_get_contents(); // On stocke le résultat des instructions précéentes dans une variable.
    ob_end_clean(); // On ferme le tampon de sortie et le vide.
    file_put_contents( $cacheFic, $tampon ); // On crée un fichier de cache pour y écrire le contenu de la variable. Si le fichier existe déjà, la fonction le remplacera.
    echo $tampon; // On affiche le contenu du tampon de sortie.
endif;
?&gt;</code></pre>
        <p><em>Dans cet exemple, nous n'utilisons les ressources de génération du HTML par le PHP que dans le cas où le fichier de cache n'est pas présent ou expiré. Le reste du temps, nous ne faisons que renvoyer directement le fichier HTML, sans recalculer la page.</em></p>
        <a href="12_-_La_temporisation_de_sortie/cache.php" title="">Voir un exemple avec un formulaire</a>
    </body>
</html>