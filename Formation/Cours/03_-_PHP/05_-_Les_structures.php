<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0" />
        <title>Les structures</title>

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
        <h1>Les structures</h1>
        <p><em></em></p>
        <hr />
        <h2>Les symboles à connaître</h2>
        <p><em>Avant de pouvoir créer et évaluer des conditions, vous devez savoir que pour y parvenir, nous allons utiliser ce qu'on appelle des « opérateurs logiques ». Ceux-ci sont surtout utilisés lors de conditions (si [test] alors [faire ceci]) pour évaluer différents cas possibles.</em></p>
        <ul style="font-style:italic;">
            <li><strong>==</strong> : permet de tester l'égalité (double symbole afin de ne pas confondre avec l'opérateur d'affectation)</li>
            <li><strong>!=</strong> : permet de tester l'inégalité</li>
            <li><strong><</strong> : strictement inférieur</li>
            <li><strong><=</strong> : inférieur ou égal</li>
            <li><strong>></strong> : strictement supérieur</li>
            <li><strong>>=</strong> : supérieur ou égal</li>
            <li><strong>&& (AND)</strong> : l'opérateur ET, permet de préciser une condition en associant des cas logiques</li>
            <li><strong>|| (OR)</strong> : l'opérateur OU</li>
            <li><strong>? ... : ...</strong> : l'opérateur ternaire</li>
            <li><strong>===</strong> : permet de tester l'égalité sur un même type de donnée</li>
            <li><strong>!==</strong> : permet de tester l'inégalité sur un même type de donnée</li>
        </ul>
        <hr />
        <h2>Structure alternative (instruction conditionnelle)</h2>
        <h3>SI … ALORS … SINON … FSI</h3>
        <p><em>Reprenons l'exercice posé en algo : "Saisir une valeur entière et afficher son double si cette donnée est inférieure à un seuil donné."<br />Comme nous ne savons pas encore saisir de valeur en PHP à l'heure actuelle, nous assignerons une valeur à une variable en remplacement.</em></p>
        <?php
        define('seuil', 10);
        $val = 2;
        if($val < seuil) {
            echo 'Voici son double : ' . ( $val * 2 );
        } else {
            echo 'Voici la valeur inchangée : ' . $val;
        }
        ?>
        <pre><code class="php">
&lt;?php
define('seuil', 10);
$val = 2;
if($val &lt; seuil) {
    echo 'Voici son double : ' . ( $val * 2 );
} else {
    echo 'Voici la valeur inchangée : ' . $val;
}

/**
 * Une autre écriture est possible, qui ressemble d'avantage à l'écriture algorithmique :
 *      if($val &lt; seuil) :
 *          //...
 *      else :
 *          //...
 *      endif;
**/

/**
 * Lorsqu'une seule instruction est à exécuter dans la condition,
 * on peut écrire directement le code en ligne sans préciser les accolades ou les autres symboles délimitant un bloc d'instructions :
 *      if($val &lt; seuil) echo 'Voici son double : ' . ( $val * 2 );
 *      else echo 'Voici la valeur inchangée : ' . $val;
**/
?&gt;</code></pre>
        <h3>Structures alternatives imbriquées</h3>
        <p><em>Reprenons l'exercice posé en algo : "Saisir une valeur entière et afficher : “Reçu avec mention Assez bien” si une note est supérieure ou égale à 12, “Reçu avec mention Passable” si une note est supérieure à 10 et inférieure à 12, “Insuffisant” dans tous les autres cas."<br />Comme nous ne savons pas encore saisir de valeur en PHP à l'heure actuelle, nous assignerons une valeur à une variable en remplacement.</em></p>
        <?php
        $note = 14;
        if($note >= 12) {
            echo 'Reçu avec mention Assez bien';
        } elseif($note > 10) {
            echo 'Reçu avec mention Passable';
        } else {
            echo 'Insuffisant';
        }
        ?>
        <pre><code class="php">
&lt;?php
$note = 14;
if($note &gt;= 12) {
    echo 'Reçu avec mention Assez bien';
} elseif($note &gt; 10) {
    echo 'Reçu avec mention Passable';
} else {
    echo 'Insuffisant';
}

/**
 * Une autre écriture est possible, qui ressemble d'avantage à l'écriture algorithmique :
 *      if($note &gt;= 12) :
 *          //...
 *      elseif($note &gt; 10) :
 *          //...
 *      else :
 *         //...
 *      endif;
**/
?&gt;</code></pre>
        <p class="alert"><em>La principale nouveautée ici, c'est le mot-clé elseif qui signifie « sinon si ».</em></p>
        <h4>Comparaison de valeur ET de type de données</h4>
        <?php
        $val = '1';
        $valInteger = 1;
        $valBoolean = true;
        $valString = '1';

        if( $val === $valInteger ) {
            echo 'Je suis un entier qui vaut '. $val;
        } elseif( $val === $valBoolean ) {
            echo 'Je suis le booléen qui vaut ' . $val;
        } elseif( $val === $valString ) {
            echo 'Je suis une chaine de caractère de valeur ' . $val;
        } else {
            echo 'Je ne suis pas égal à ' . $val;
        }
        ?>
        <pre><code class="php">
&lt;?php
$val = '1';
$valInteger = 1;
$valBoolean = true;
$valString = '1';

if( $val === $valInteger ) {
    echo 'Je suis un entier qui vaut '. $val;
} elseif( $val === $valBoolean ) {
    echo 'Je suis le booléen qui vaut ' . $val;
} elseif( $val === $valString ) {
    echo 'Je suis une chaine de caractère de valeur ' . $val;
} else {
    echo 'Je ne suis pas égal à ' . $val;
}
?&gt;</code></pre>
        <h3>Sélection choix multiples</h3>
        <?php
        $abreviation = 'Mme';
        switch($abreviation) {
            case 'Mme':
                echo 'Madame';
                break;
            case 'Mlle':
                echo 'Mademoiselle';
                break;
            case 'M':
                echo 'Monsieur';
                break;
            case 'Autre':
                echo 'Transgenre';
                break;
            default:
                echo 'Choix non listé';
        }
        ?>
        <pre><code class="php">
&lt;?php
$abreviation = 'Mme';
switch($abreviation) {
    case 'Mme':
        echo 'Madame';
        break;
    case 'Mlle':
        echo 'Mademoiselle';
        break;
    case 'M':
        echo 'Monsieur';
        break;
    case 'Autre':
        echo 'Transgenre';
        break;
    default:
        echo 'Choix non listé';
}

/**
 * Une autre écriture est possible, qui ressemble d'avantage à l'écriture algorithmique :
 *      switch($abreviation) :
 *          //...
 *      endswitch;
**/
?&gt;</code></pre>
        <h4>Cas identiques</h4>
        <p>L'instruction "break" permet de différencier les cas. Du coup pour associer des cas ayant le même résultat, il vous suffit de les écrire les uns après les autres en ne plaçant le "break" quà la fin du dernier cas concerné.</p>
        <?php
        $abreviation = 'Mme';
        switch($abreviation) {
            case 'Mme':
            case 'Mlle':
                echo 'Féminin';
                break;
            case 'M':
                echo 'Masculin';
                break;
            case 'Autre':
            default:
                echo 'Choix non listé';
        }
        ?>
        <pre><code class="php">
&lt;?php
$abreviation = 'Mme';
switch($abreviation) {
    case 'Mme':
    case 'Mlle':
        echo 'Féminin';
        break;
    case 'M':
        echo 'Masculin';
        break;
    case 'Autre':
    default:
        echo 'Choix non listé';
}
?&gt;</code></pre>
        <hr />
        <h2>Les boucles</h2>
        <h3>Boucle POUR</h3>
        <?php
        $nbIterations = 10;
        $val = 2;
        $totalVal = 0;

        echo 'Valeur initiale : $totalVal = ' . $totalVal . ' et $val = ' . $val . '<br /><br />';

        for($cpt = 1; $cpt <= $nbIterations; $cpt++) {
            $totalVal += $val; // Ecriture équivalente à $totalVal = $totalVal + $val
            $val += 1; // Ecriture équivalente à $val = $val + 1 ou encore à $val++
            echo 'Je boucle : $totalVal = ' . $totalVal . ' et $val = ' . $val . '<br />';
        }
        echo '<br />Le total des ' . $nbIterations . ' valeurs saisies est : ' . $totalVal;
        ?>
        <pre><code class="php">
&lt;?php
$nbIterations = 10;
$val = 2;
$totalVal = 0;

echo 'Valeur initiale : $totalVal = ' . $totalVal . ' et $val = ' . $val . '&lt;br /&gt;&lt;br /&gt;';

for($cpt = 1; $cpt &lt;= $nbIterations; $cpt++) {
    $totalVal += $val; // Ecriture équivalente à $totalVal = $totalVal + $val
    $val += 1; // Ecriture équivalente à $val = $val + 1 ou encore à $val++
    echo 'Je boucle : $totalVal = ' . $totalVal . ' et $val = ' . $val . '&lt;br /&gt;';
}
echo '&lt;br /&gt;Le total des ' . $nbIterations . ' valeurs saisies est : ' . $totalVal;

/**
 * Une autre écriture est possible, qui ressemble d'avantage à l'écriture algorithmique :
 *      for($cpt = 1; $cpt &lt;= $nbIterations; $cpt++) :
 *          //...
 *      endfor;
**/
?&gt;</code></pre>
        <h3>Boucle TANT QUE … FAIRE</h3>
        <?php
        define('stop', 10);
        $val = 2;
        $totalVal = 0;

        echo 'Valeur initiale : $totalVal = ' . $totalVal . ' et $val = ' . $val . '<br /><br />';

        while($val != stop) {
            $totalVal += $val; // Ecriture équivalente à $totalVal = $totalVal + $val
            $val += 1; // Ecriture équivalente à $val = $val + 1 ou encore à $val++
            echo 'Je boucle : $totalVal = ' . $totalVal . ' et $val = ' . $val . '<br />';
        }
        echo '<br />Le total des valeurs saisies est : ' . $totalVal;
        ?>
        <pre><code class="php">
&lt;?php
define('stop', 10);
$val = 2;
$totalVal = 0;

echo 'Valeur initiale : $totalVal = ' . $totalVal . ' et $val = ' . $val . '&lt;br /&gt;&lt;br /&gt;';

while($val != stop) {
    $totalVal += $val; // Ecriture équivalente à $totalVal = $totalVal + $val
    $val += 1; // Ecriture équivalente à $val = $val + 1 ou encore à $val++
    echo 'Je boucle : $totalVal = ' . $totalVal . ' et $val = ' . $val . '&lt;br /&gt;';
}
echo '&lt;br /&gt;Le total des valeurs saisies est : ' . $totalVal;

/**
 * Une autre écriture est possible, qui ressemble d'avantage à l'écriture algorithmique :
 *      while($val != stop) :
 *          //...
 *      endwhile;
**/
?&gt;</code></pre>
        <h3>Boucle RÉPÉTER ... TANT QUE</h3>
        <?php
        define('stop2', 10);
        $val = 2;
        $totalVal = 0;

        echo 'Valeur initiale : $totalVal = ' . $totalVal . ' et $val = ' . $val . '<br /><br />';

        do {
            $val += 1; // Ecriture équivalente à $val = $val + 1 ou encore à $val++
            $totalVal += $val; // Ecriture équivalente à $totalVal = $totalVal + $val
            echo 'Je boucle : $val = ' . $val . ' et $totalVal = ' . $totalVal . '<br />';
        } while($val <= stop2);
        echo '<br />Le total des valeurs saisies est : ' . $totalVal;
        ?>
        <pre><code class="php">
&lt;?php
define('stop2', 10);
$val = 2;
$totalVal = 0;

echo 'Valeur initiale : $totalVal = ' . $totalVal . ' et $val = ' . $val . '&lt;br /&gt;&lt;br /&gt;';

do {
    $val += 1; // Ecriture équivalente à $val = $val + 1 ou encore à $val++
    $totalVal += $val; // Ecriture équivalente à $totalVal = $totalVal + $val
    echo 'Je boucle : $val = ' . $val . ' et $totalVal = ' . $totalVal . '&lt;br /&gt;';
} while($val &lt;= stop2);
echo '&lt;br /&gt;Le total des valeurs saisies est : ' . $totalVal;
?&gt;</code></pre>
    </body>
</html>