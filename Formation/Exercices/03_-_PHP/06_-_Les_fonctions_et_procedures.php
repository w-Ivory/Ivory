<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0" />
        <title>Les fonctions & les fonctions - Mise en pratique</title>

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
        <h1>Les fonctions & les fonctions - Mise en pratique</h1>
        <hr />
        <h2>Ex. 0 : inversion de valeurs</h2>
        <p><em>Pour cet exercice :<br />Écrire un programme qui échange la valeur de deux variables.<br />Exemple, si a ← 2 et b ← 5, le programme donnera a ← 5 et b ← 2.</em></p>
        <pre><code class="algo">
Algorithme InverserVal {déclarations : réservation d'espace mémoire}
    variables   a, b: entiers

    fonction inverser(E/S val1, E/S val2 : entiers)
        début
            val1 ← val1 + val2
            val2 ← val1 - val2
            val1 ← val1 - val2
        fin

    début
        a ← 2
        b ← 5
        afficher(a, b)
        inverser(a, b)
        afficher(a, b)
    fin</code></pre>
        <?php
        function inverser(&$val1, &$val2) { // Vous pouvez passer une variable par référence (autre nom pour Entrée/Sortie) à une fonction, de manière à ce que celle-ci puisse la modifier. Pour cela, on utilise le symbole "&" sur la déclaration du paramètre (http://php.net/manual/fr/language.references.pass.php).
            $val1 += $val2;
            $val2 = $val1 - $val2;
            $val1 -= $val2;
        }

        $a = 2;
        $b = 5;
        echo 'La valeur de départ de la variable "a" est : ' . $a . '<br />La valeur de départ de la variable "b" est : ' . $b;

        inverser($a, $b);
        echo '<br />La valeur actuelle de la variable "a" est : ' . $a . '<br />La valeur actuelle de la variable "b" est : ' . $b;
        ?>
        <pre><code class="php">
&lt;?php
function inverser(&$val1, &$val2) { // Vous pouvez passer une variable par référence (autre nom pour Entrée/Sortie) à une fonction, de manière à ce que celle-ci puisse la modifier. Pour cela, on utilise le symbole "&" sur la déclaration du paramètre (http://php.net/manual/fr/language.references.pass.php).
    $val1 += $val2;
    $val2 = $val1 - $val2;
    $val1 -= $val2;
}

$a = 2;
$b = 5;
echo 'La valeur de départ de la variable "a" est : ' . $a . '&lt;br /&gt;La valeur de départ de la variable "b" est : ' . $b;

inverser($a, $b);
echo '&lt;br /&gt;La valeur actuelle de la variable "a" est : ' . $a . '&lt;br /&gt;La valeur actuelle de la variable "b" est : ' . $b;
?&gt;</code></pre>
        <hr />
        <h2>Ex. 1 : moyenne</h2>
        <p><em>Pour cet exercice :<br />Écrire le sous-algorithme de la fonction "moyenne" qui renvoie la moyenne de deux entiers.<br />Écrire l'algorithme qui contient la déclaration de la fonction moyenne et des instructions qui appellent cette fonction.</em></p>
        <pre><code class="algo">
Algorithme calculMoyenne {déclarations : réservation d'espace mémoire}
    variables   note1, note2 : réels

    fonction moyenne(x, y : réels) : réel
        début
            retourner (x + y) / 2
        fin

    début
        afficher("Saisissez deux notes à la suite :")
        saisir(note1)
        saisir(note2)
        afficher("La moyenne de ", A, " et ", B, " est : ", moyenne(note1, note2))
    fin</code></pre>
        <?php
        function moyenne($x, $y) {
            return ($x + $y) / 2;
        }

        $note1 = 15;
        $note2 = 12;
        echo 'La moyenne des notes ' . $note1 . ' et ' . $note2 . ' est : ' . moyenne($note1, $note2);
        ?>
        <pre><code class="php">
&lt;?php
function moyenne($x, $y) {
    return ($x + $y) / 2;
}

$note1 = 15;
$note2 = 12;
echo 'La moyenne des notes ' . $note1 . ' et ' . $note2 . ' est : ' . moyenne($note1, $note2);
?&gt;</code></pre>
        <hr />
        <h2>Ex. 3 : suite de Fibonacci</h2>
        <p><em>Pour cet exercice :<br />En utilisant une fonction récursive, écrire un algorithme qui détermine le terme U<sub>n</sub> de la suite de Fibonacci définit comme suit :<br />U<sub>0</sub> = 0<br />U<sub>1</sub> = 1<br />U<sub>n</sub> = U<sub>n-1</sub> + U<sub>n-2</sub> (pour n supérieur ou égal à 2)</em></p>
        <pre><code class="algo">
Algorithme suiteFibonacci {déclarations : réservation d'espace mémoire}
    variables   n : entier
    
    fonction fibonacci(k : entier) : entier
        début
            selon k
                0 : retourner 0
                1 : retourner 1
                autres : retourner fibonacci(k - 1) + fibonacci(k - 2)
            finselon
        fin
    
    début
        afficher("Saisissez un nombre entier positif :")
        saisir(n)
        afficher("Le terme U n de la suite de Fibonacci avec n (fourni) égal ", n, " est : ", fibonacci(n))
    fin</code></pre>
        <?php
        function fibonacci($k) {
            switch($k) :
                case 0:
                    return 0;
                    break;
                case 1:
                    return 1;
                    break;
                default:
                    return fibonacci($k-1) + fibonacci($k-2);
            endswitch;
        }

        $n = 30;
        echo 'Le terme U<sub>n</sub> de la suite de Fibonacci avec n (fourni) égal ' . $n . ' est : ' . fibonacci($n). ' <small>(pour information, la valeur 36 donne un résultat de 14930352 mais met plusieurs secondes à s\'exécuter)</small>';
        
        function suiteFibonacci($k) {
            echo fibonacci(0);
            for($i = 1; $i<=$k; $i++) :
                echo ', ' . fibonacci($i);
            endfor;
        }
        echo '<br />La suite complète de Fibonacci de 0 à n=' . $n . ' est : ';
        suiteFibonacci($n);
        ?>
        <pre><code class="php">
&lt;?php
function fibonacci($k) {
    switch($k) {
        case 0:
            return 0;
            break;
        case 1:
            return 1;
            break;
        default:
            return fibonacci($k-1) + fibonacci($k-2);
    }

    /*
    Une optimisation de la structure SELON dans le cas présent pourrait être :

    switch($k) {
        case 0:
        case 1:
            return $k;
            break;
        default:
            return fibonacci($k-1) + fibonacci($k-2);
    }
    */
}

$n = 30;
echo 'Le terme U&lt;sub&gt;n&lt;/sub&gt; de la suite de Fibonacci avec n (fourni) égal ' . $n . ' est : ' . fibonacci($n);

function suiteFibonacci($k) {
    echo fibonacci(0);
    for($i = 1; $i&lt;=$k; $i++) :
        echo ', ' . fibonacci($i);
    endfor;
}
echo '&lt;br /&gt;La suite complète de Fibonacci de 0 à n=' . $n . ' est : ';
suiteFibonacci($n);
?&gt;</code></pre>
    </body>
</html>