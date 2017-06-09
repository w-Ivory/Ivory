<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0" />
        <title>Les bases du langage PHP</title>

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
        <h1>Les bases du langage PHP</h1>
        <hr />
        <h2>La forme d'une balise PHP</h2>
        <pre><code class="php">
&lt;?php /* Le code PHP se met ici */ ?&gt;</code></pre>
        <hr />
        <h2>Les instructions en PHP</h2>
        <p><em>Tout langage de programmation contient ce qu'on appelle des instructions. On en écrit une par ligne en général, et elles se terminent toutes par un point-virgule. Une instruction commande à l'ordinateur d'effectuer une action précise.</em></p>
        <h3>L'instruction <em>afficher</em></h3>
        <p><em>Afficher en PHP du texte dans une structure HTML :</em></p>
        <p><?php echo 'Hello world !'; ?></p>
        <pre><code class="php">
&lt;?php echo 'Hello world !'; ?&gt;</code></pre>
        <p><em>Afficher en PHP du texte balisé dans une structure HTML :</em></p>
        <?php echo '<p>Hello world !</p>'; ?>
        <pre><code class="php">
&lt;?php echo '&lt;p&gt;Hello world !&lt;/p&gt;'; ?&gt;</code></pre>
		<p><em>On remarque que nous délimitons les chaînes de caractères avec des apostrophes ou des guillemets. De ce fait, nous ne pouvons utiliser ces caractères sans interrompre la chaîne ... à moins d'échapper le symbole à l'aide d'un antislash.</em></p>
        <?php echo '<p>Bonjour l\'équipe</p>'; ?>
        <pre><code class="php">
&lt;?php echo '&lt;p&gt;Bonjour l\'équipe&lt;/p&gt;'; ?&gt;</code></pre>
		<p class="block alert"><em>Notez qu'il existe une instruction identique à "echo" appelée "print", qui fait la même chose. Cependant, "echo" est plus couramment utilisée.</em></p>
        <hr />
        <h2>Les commentaires en PHP</h2>
        <h3>Les commentaires monolignes</h3>
        <p><em>Pour indiquer que vous écrivez un commentaire sur une seule ligne, vous devez taper deux slashs : « // ». Tapez ensuite votre commentaire.</em></p>
        <?php
        echo '<p>Bonjour le monde !</p>'; // Ceci est ma première instruction en PHP
        // Ci-dessous une autre instruction en PHP
        echo 'Je recommence une nouvelle ligne en PHP';
        ?>
        <pre><code class="php">
&lt;?php
echo '&lt;p&gt;Bonjour le monde !&lt;/p&gt;'; // Ceci est ma première instruction en PHP
// Ci-dessous une autre instruction en PHP
echo 'Je recommence une nouvelle ligne en PHP';
?&gt;</code></pre>
		<h3>Les commentaires multilignes</h3>
        <p><em>Ce sont les plus pratiques si vous pensez écrire un commentaire sur plusieurs lignes, mais on peut aussi s'en servir pour écrire des commentaires d'une seule ligne. Il faut commencer par écrire /* puis refermer par */.</em></p>
        <?php
        /**
         * Ceci est un espace de commentaire 
         * sur 1 ligne,
         * 2 lignes,
         * ...
        **/
        echo '<p>Bonjour le monde !</p>';
        ?>
        <pre><code class="php">
&lt;?php
/**
 * Ceci est un espace de commentaire 
 * sur 1 ligne,
 * 2 lignes,
 * ...
**/
echo '&lt;p&gt;Bonjour le monde !&lt;/p&gt;';
?&gt;</code></pre>
    </body>
</html>