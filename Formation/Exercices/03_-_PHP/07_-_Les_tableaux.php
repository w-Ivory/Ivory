<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0" />
        <title>Les tableaux - Mise en pratique</title>

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
        <h1>Les tableaux - Mise en pratique</h1>
        <hr />
        <h2>Exemple : moyenne</h2>
        <p><em>Pour cet exercice :<br />Affichage de la moyenne des notes d'une promo saisies par le prof</em></p>
        <pre><code class="algo">
Algorithme moyenne {Affichage de la moyenne des notes d'une promo saisies par le prof}
    {déclarations : réservation d'espace mémoire}
    variables   somme, nbEleves, i: naturels
                notes : tableau[1 … 100] de naturels

    début
        {préparation du traitement}
        somme ← 0.0 {initialisation du total à 0 avant le cumul}
        répéter
            afficher("Nombre d'élèves (max. 100) ?")
            saisir(nbEleves)
        tant que nbEleves ≤ 0 ou nbEleves > 100
        pour i ← 1 à nbEleves faire
            afficher("Saisissez une note :")
            saisir(notes[i])
            somme ← somme + notes[i] {cumul}
        fpour
        afficher("Moyenne des notes ", somme/nbEleves)
        pour i ← 1 à nbEleves faire
            afficher(notes[i])
        fpour
    fin</code></pre>
        <?php
        $somme = 0;
        $notes = array();
        do {
            $nbEleves = rand(-200,200);
        } while($nbEleves<=0 || $nbEleves>100);

        if($nbEleves > 0) {
            for( $i = 0; $i < $nbEleves; $i++ ) {
                $notes['note' . $i] = rand(0,20);
                $somme += $notes['note' . $i]; // $somme = $somme + $notes[$i];
            }
            echo '<br />Moyenne des ' . count($notes) . ' notes saisies : ' . round($somme/$nbEleves,2); // La fonction round() permet d'arrondir un nombre. Elle prend comme premier argument le nombre à arrondir, puis en deuxième argument la précision de l'arrondi après la virgule (ici 2 chiffres après la virgule)
        }
        echo '<br />';
        print_r($notes);
        ?>
        <pre><code class="php">
&lt;?php
$somme = 0;
$notes = array();
do {
    $nbEleves = rand(-200,200); // On simule la saisie d'un utilisateur avec plusieurs valeurs possibles pouvant sortir du cadre demandé.
} while($nbEleves&lt;=0 || $nbEleves&gt;100); // On valide que la valeur saisie soit bien comprise entre 0 et 100.

if($nbEleves &gt; 0) { // Teste la valeur saisie afin d'éviter une division par zéro dans la cas où la valeur saisie serait 0 élèves.
    for( $i = 0; $i &lt; $nbEleves; $i++ ) {
        $notes['note' . $i] = rand(0,20); // On attribue une valeur aléatoire comprise entre 0 et 20 pour la note.
        $somme += $notes['note' . $i]; // $somme = $somme + $notes[$i];
    }
    echo '&lt;br /&gt;Moyenne des ' . count($notes) . ' notes saisies : ' . round($somme/$nbEleves,2); // La fonction round() permet d'arrondir un nombre. Elle prend comme premier argument le nombre à arrondir, puis en deuxième argument la précision de l'arrondi après la virgule (ici 2 chiffres après la virgule)
}
echo '&lt;br /&gt;';
print_r($notes);
?&gt;</code></pre>
        <hr />
        <h2>Ex. 0 : notesPromo</h2>
        <p><em>Pour cet exercice :<br />Écrire un programme qui affiche en ordre croissant les notes d'une promotion de 10 élèves, suivies de la note la plus faible, de la note la plus élevée et de la moyenne.</em></p>
        <pre><code class="algo">
Algorithme notesPromo {déclarations : réservation d'espace mémoire}
    constantes  stop: entier ← -1
    variables   somme: réel
                cptEleves, saisie: naturel
    type        notes : tableau[1 … MAX] de réels

    fonction minimum(t : tableau[1 … MAX] d'entiers; rang, nbElements : naturels) : naturel
        variables   i, indice : naturels

        début
            indice ← rang
            pour i ← rang+1 à nbElements faire
                si t[i] < t[indice] alors
                    indice ← i
                fin si
            fin pour
            retourner indice
        fin

    fonction inverser(E/S val1, E/S val2 : entiers)
        variables   tmp : naturel

        début
            tmp ← val1
            val1 ← val2
            val2 ← tmp
        fin

    fonction triParMinimumSuccessif(E/S t : tableau[1 … MAX] d'entiers, E nbElements : naturel)
        variables   i, indice : naturels

        début
            pour i ← 1 à nbElements-1 faire
                indice ← minimum(t, i, nbElements)
                si i ≠ indice alors
                    inverser(t[i],t[indice])
                fin si
            fin pour
        fin

    fonction moyenne(total : réel, compteur : naturel) : réel
        début
            retourner total / compteur
        fin

    début
        {préparation du traitement}
        cptEleves ← 0 {initialisation du nombre d'élèves}
        somme ← 0 {initialisation du total à 0 avant le cumul}

        répéter
            afficher("Saisissez une note pour l'élève n° :", cptEleves+1)
            saisir(saisie)
            si saisie > stop alors
                cptEleves ← cptEleves + 1 {incrémentation du nombre d'élèves}
                notes[cptEleves] ← saisie
                somme ← somme + notes[cptEleves] {cumul}
            fin si
        tant que saisie > stop

        triParMinimumSuccessif(notes,cptEleves)

        afficher("Notes de la promotion par ordre croissant : ")
        pour i ← 1 à cptEleves faire
            afficher(notes[i])
        fin pour
        
        afficher("Note la plus faible ", notes[1])
        afficher("Note la plus élevée ", notes[10])
        afficher("Moyenne des notes ", moyenne(somme, cptEleves))
    fin</code></pre>
        <?php
        define('stop', -1);
        function minimum( $t, $rang, $nbElements ) {
            $indice = $rang;
            for( $i = $rang+1; $i < $nbElements; $i++ ) {
                if( $t[$i] < $t[$indice] ) {
                    $indice = $i;
                }
            }
            return $indice;
        }
        function inverser( &$val1, &$val2 ) {
            $tmp = $val1;
            $val1 = $val2;
            $val2 = $tmp;
        }
        function triParMinimumSuccessif( &$t, $nbElements ) {
            for( $i = 0; $i < $nbElements-1; $i++ ) {
                $indice = minimum( $t, $i, $nbElements );
                if( $i != $indice ) {
                    inverser( $t[$i], $t[$indice] );
                }
            }
        }
        function triBulle( &$t, $nbElements ) {
            for( $i = 0; $i < $nbElements-1; $i++ ) {
                for( $j = $nbElements-1; $j > $i; $j-- ) {
                    if( $t[$j] < $t[$j-1] ) {
                        inverser( $t[$j], $t[$j-1] );
                    }
                }
            }
        }
        function moyenne($total, $compteur) {
            return round( $total / $compteur, 2 );
        }
        $cptEleves = 0;
        $somme = 0;
        $notes = array();
        do {
            $saisie = rand( -1, 20 );
            if( $saisie > stop ) {
                $cptEleves++;
                $notes[] = $saisie;
                $somme +=  $notes[count( $notes )-1];
            }
        } while( $saisie > stop );

        if(count($notes)>0) :
            echo 'Visu du tableau non trié pour contrôle :<br />';
            print_r($notes);
            $notesBkp = $notes;
            echo '<br />';
            echo '<br />';

            triParMinimumSuccessif( $notes, count( $notes ) );
            echo 'Notes de la promo par ordre croissant (tri par minimum successif) :';
            foreach( $notes as $value ) { 
                echo '<br />' . $value;
            }
            echo '<br />';

            triBulle( $notesBkp, $cptEleves );
            echo 'Notes de la promo par ordre croissant (tri à bulle) :';
            foreach( $notes as $value ) { 
                echo '<br />' . $value;
            }
            echo '<br />';

            echo '<br />Note la plus faible : ' . $notes[0];
            echo '<br />Note la plus élevée : ' . $notes[count( $notes )-1];
            echo '<br />Moyenne des notes : ' . moyenne( $somme, count( $notes ) );
        else :
            echo 'Traitement interrompu par la saisie immédiate de la valeur "-1"';
        endif;
        ?>
        <pre><code class="php">
&lt;?php
define('stop', -1);
function minimum( $t, $rang, $nbElements ) {
    $indice = $rang;
    for( $i = $rang+1; $i &lt; $nbElements; $i++ ) {
        if( $t[$i] &lt; $t[$indice] ) {
            $indice = $i;
        }
    }
    return $indice;
}
function inverser( &$val1, &$val2 ) {
    $tmp = $val1;
    $val1 = $val2;
    $val2 = $tmp;
}
function triParMinimumSuccessif( &$t, $nbElements ) {
    for( $i = 0; $i &lt; $nbElements-1; $i++ ) {
        $indice = minimum( $t, $i, $nbElements );
        if( $i != $indice ) {
            inverser( $t[$i], $t[$indice] );
        }
    }
}
function triBulle( &$t, $nbElements ) {
    for( $i = 0; $i &lt; $nbElements-1; $i++ ) {
        for( $j = $nbElements-1; $j &gt; $i; $j-- ) {
            if( $t[$j] &lt; $t[$j-1] ) {
                inverser( $t[$j], $t[$j-1] );
            }
        }
    }
}
function moyenne($total, $compteur) {
    return round( $total / $compteur, 2 );
}
$cptEleves = 0;
$somme = 0;
$notes = array();
do {
    $saisie = rand( -1, 20 );
    if( $saisie &gt; stop ) {
        $cptEleves++;
        $notes[] = $saisie;
        $somme +=  $notes[count( $notes )-1];
    }
} while( $saisie &gt; stop );

if(count($notes)&gt;0) :
    echo 'Visu du tableau non trié pour contrôle :&lt;br /&gt;';
    print_r($notes);
    $notesBkp = $notes;
    echo '&lt;br /&gt;';
    echo '&lt;br /&gt;';

    triParMinimumSuccessif( $notes, count( $notes ) );
    echo 'Notes de la promo par ordre croissant (tri par minimum successif) :';
    foreach( $notes as $value ) { 
        echo '&lt;br /&gt;' . $value;
    }
    echo '&lt;br /&gt;';

    triBulle( $notesBkp, $cptEleves );
    echo 'Notes de la promo par ordre croissant (tri à bulle) :';
    foreach( $notes as $value ) { 
        echo '&lt;br /&gt;' . $value;
    }
    echo '&lt;br /&gt;';

    echo '&lt;br /&gt;Note la plus faible : ' . $notes[0];
    echo '&lt;br /&gt;Note la plus élevée : ' . $notes[count( $notes )-1];
    echo '&lt;br /&gt;Moyenne des notes : ' . moyenne( $somme, count( $notes ) );
else :
    echo 'Traitement interrompu par la saisie immédiate de la valeur "-1"';
endif;
?&gt;</code></pre>
    </body>
</html>