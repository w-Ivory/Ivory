<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0" />
        <title>Les structures - Mise en pratique</title>

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
        <h1>Les structures - Mise en pratique</h1>
        <hr />
        <h2>Ex. 0 : inversion de valeurs</h2>
        <p><em>Pour cet exercice :<br />Écrire un programme qui échange la valeur de deux variables.<br /><em>Exemple, si a ← 2 et b ← 5, le programme donnera a ← 5 et b ← 2.</em></p>
        <pre><code class="algo">
Algorithme InverserVal {déclarations : réservation d'espace mémoire}
    variables   a, b, tmp : entiers

    début
        a ← 2
        b ← 5
        afficher(a, b)
        tmp ← a
        a ← b
        b ← tmp
        afficher(a, b)
    fin</code></pre>
        <?php
        $a = 2;
        $b = 5;
        echo 'Avant inversion : $a = ' . $a . ' et $b = ' . $b;
        $tmp = $a;
        $a = $b;
        $b = $tmp;
        echo '<br />Après inversion : $a = ' . $a . ' et $b = ' . $b;
        ?>
        <pre><code class="php">
&lt;?php
$a = 2;
$b = 5;
echo 'Avant inversion : $a = ' . $a . ' et $b = ' . $b;
$tmp = $a;
$a = $b;
$b = $tmp;
echo '&lt;br /&gt;Après inversion : $a = ' . $a . ' et $b = ' . $b;
?&gt;</code></pre>
        <hr />
        <h2>Ex. 1 : positif ou négatif</h2>
        <p><em>Pour cet exercice :<br />Écrire un algorithme qui demande deux nombres à l'utilisateur et l'informe ensuite si leur produit est négatif ou positif (on laisse de coté le cas où le produit est nul).<br />Attention toutefois : on ne doit pas calculer le produit des deux nombres.</em></p>
        <pre><code class="algo">
Algorithme ConnaitrePositifNegatif {déclarations : réservation d'espace mémoire}
    variables   a, b : entiers

    début
        a ← 5
        b ← -2
        si (a > 0 ET b > 0) OU (a < 0 ET b < 0) alors
            afficher("Le produit des nombres est positif")
        sinon
            afficher("Le produit des nombres est négatif")
        fin si
    fin</code></pre>
        <?php
        $a = 5;
        $b = -2;
        if( ( $a > 0 && $b > 0 ) || ( $a < 0 && $b < 0 ) ) {
            echo 'Le produit des nombres ' . $a . ' et ' . $b . ' est positif';
        } else {
            echo 'Le produit des nombres ' . $a . ' et ' . $b . ' est négatif';
        }
        ?>
        <pre><code class="php">
&lt;?php
$a = 5;
$b = -2;
if( ( $a > 0 && $b > 0 ) || ( $a < 0 && $b < 0 ) ) {
    echo 'Le produit des nombres ' . $a . ' et ' . $b . ' est positif';
} else {
    echo 'Le produit des nombres ' . $a . ' et ' . $b . ' est négatif';
}
?&gt;</code></pre>
        <hr />
        <h2>Ex. 2 : plus petit / plus grand</h2>
        <p><em>Pour cet exercice :<br />Écrire un algorithme qui demande un nombre compris entre 10 et 20, jusqu'à ce que la réponse convienne.<br />En cas de réponse supérieure à 20, on fera apparaître un message : "Plus petit !" , et inversement, "Plus grand !" si le nombre est inférieur à 10.</em></p>
        <pre><code class="algo">
Algorithme PlusPetitPlusGrand {déclarations : réservation d'espace mémoire}
    variables   val : entier

    début
        répéter
            saisir(val)
            afficher("La saisie vaut : ", val)
            si (val < 10) alors
                afficher("Plus grand !")
            sinon
                si (val > 20) alors
                    afficher("Plus petit !")
                fin si
            fin si
        tant que (val < 10 OU val > 20)

        afficher("Valeur correspondante aux bornes : ", val)
    fin</code></pre>
        <?php
        do {
            $val = rand(-50,50);
            echo 'La saisie vaut : ' . $val . '<br />';
            if( $val < 10 ) {
                echo 'Plus grand !<br />';
            } else {
                if( $val > 20) {
                    echo 'Plus petit !<br />';
                }
            }
        } while( $val < 10 || $val > 20 );
        echo '<br />Valeur correspondante aux bornes : ' . $val;
        ?>
        <pre><code class="php">
&lt;?php
do {
    $val = rand(-50,50);
    echo 'La saisie vaut : ' . $val . '&lt;br /&gt;';
    if( $val &lt; 10 ) {
        echo 'Plus grand !&lt;br /&gt;';
    } else {
        if( $val &gt; 20) {
            echo 'Plus petit !&lt;br /&gt;';
        }
    }
} while( $val &lt; 10 || $val &gt; 20 );
echo '&lt;br /&gt;Valeur correspondante aux bornes : ' . $val;
?&gt;</code></pre>
    </body>
</html>