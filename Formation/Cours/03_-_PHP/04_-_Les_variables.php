<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0" />
        <title>Les variables</title>

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
        <h1>Les variables</h1>
        <p><em>Les variables sont capables de stocker différents types d'informations : on parle de types de données.</em></p>
        <hr />
        <h2>Les différents types de variables</h2>
        <p><em>Comme vu en algorithmique, nous dénombrons plusieurs types de données :</em></p>
        <ul style="font-style:italic;">
            <li><strong>les chaînes de caractères (string)</strong> : tout texte est appelé chaîne de caractères.<br />Une chaîne de caractères est habituellement écrite entre guillemets ou entre apostrophes (on parle de guillemets simples)</li>
            <li><strong>les nombres entiers (int)</strong> : ce sont les nombres du type 1, 2, 3, 4, etc. On compte aussi parmi eux les entiers relatifs : -1, -2, -3, ...</li>
            <li><strong>les nombres décimaux (float)</strong> : ce sont les nombres à virgule. Attention, les nombres doivent être écrits avec un point au lieu de la virgule (c'est la notation anglaise).</li>
            <li><strong>les booléens (bool)</strong> : permet de stocker soit vrai (true) soit faux (false). Attention, en informatique true équivaut à 1 et false à 0.</li>
            <li><strong>rien (null)</strong> : aussi bizarre que cela puisse paraître, on a parfois besoin de dire qu'une variable ne contient rien. Ce n'est pas vraiment un type de données, mais plutôt l'absence de type.</li>
        </ul>
        <p class="block alert"><em>La charte de nommage reste la même qu'en algo : ne sont autorisés que les caractères alphanumériques non accentués, les chiffres et le caractère underscore "_".<br />Le premier caractère pour le nom d'une variable doit absolument être le symbole dollar "$", suivi d'une lettre.</em></p>
        <hr />
        <h2>Affecter une valeur à une variable</h2>
        <p><em>Le caractère d'affectation de valeur est le symbole égal "=".</em></p>
        <pre><code class="php">
&lt;?php
$maChaine = 'Ceci est une chaîne de caractères'; // Affectation d'une valeur entière
$monEntier = 10; // Affectation d'une valeur entière
$monDecimal = 4.5; // Affectation d'une valeur flottante (nombre à virgule)
$monBooleen = true; // Affectation d'un booléen
$sansValeur = NULL; // Affectation d'une variable vide
?&gt;</code></pre>
        <hr />
        <h2>Concaténer des variables</h2>
        <p><em>Concaténer des variables revient à assembler celles-ci pour en faire une représentation unique.<br />Le symbole de concaténation en PHP est le point ".".</em></p>
        <h3>Cas des guillemets doubles</h3>
        <p><em>Avec des guillemets doubles, vous pouvez écrire le nom de la variable au milieu du texte et il sera remplacé par sa valeur.</em></p>
        <?php
        $monEntier = 6; // Affectation d'une valeur entière
        echo "Je veux afficher le nombre $monEntier";
        ?>
        <pre><code class="php">
&lt;?php
$monEntier = 6; // Affectation d'une valeur entière
echo "Je veux afficher le nombre $monEntier";
?&gt;</code></pre>
        <h3>Cas des guillemets simples</h3>
        <p><em>Si vous écrivez le code précédent entre guillemets simples, vous allez avoir une drôle de surprise </em></p>
        <?php
        $monEntier = 6; // Affectation d'une valeur entière
        echo 'Je veux afficher le nombre $monEntier';
        ?>
        <pre><code class="php">
&lt;?php
$monEntier = 6; // Affectation d'une valeur entière
echo 'Je veux afficher le nombre $monEntier';
?&gt;</code></pre>
        <p><em>On remarque que la variable est lue mais n'est pas interprétée. Nous pouvons obtenir le même résultat qu'avec des guillemets doubles mais cette fois, il va falloir écrire la variable en dehors des guillemets et séparer les éléments les uns des autres à l'aide d'un point.</em></p>
        <?php
        $monEntier = 6; // Affectation d'une valeur entière
        echo 'Je veux afficher le nombre ' . $monEntier;
        ?>
        <pre><code class="php">
&lt;?php
$monEntier = 6; // Affectation d'une valeur entière
echo 'Je veux afficher le nombre ' . $monEntier;
/**
 * Ce code revient au même que d'avoir écrit :
 *      $maChaine = 'Je veux afficher le nombre '; // Affectation d'une valeur entière
 *      $monEntier = 6; // Affectation d'une valeur entière
 *      echo $maChaine . $monEntier;
**/
?&gt;</code></pre>
        <hr />
        <h2>Les constantes</h2>
        <p><em>Par opposition à une variable, une constante est utilisée pour définir une variable qui ne changera pas durant notre code. Pour cela, on utilise une instruction particulière : "define"</em></p>
        <pre><code class="php">
&lt;?php
define('nomDeMaVariable', 'Valeur de ma variable'); // L'instruction define vient de créer une constante du nom de nomDeMeVariable ayant pour valeur la chaîne de caractères passée en deuxième argument.
echo nomDeMaVariable; // Une constante s'utilise directement avec son nom, sans autre symbole.
?&gt;</code></pre>
    </body>
</html>