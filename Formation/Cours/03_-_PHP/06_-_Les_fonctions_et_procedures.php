<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0" />
        <title>Les fonctions & les procédures</title>

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
        <h1>Les fonctions & les procédures</h1>
        <p><em>Comme les boucles, les fonctions/procédures permettent d'éviter la répétition du code PHP que l'on utilise souvent.<br />Une fonction/procédure est une série d'instructions qui effectue des actions et qui retourne une valeur. En général, dès que vous avez besoin d'effectuer des opérations un peu longues dont vous aurez à nouveau besoin plus tard, il est conseillé de vérifier s'il n'existe pas déjà une fonction/procédure qui fait cela pour vous. Et si elle n'existe pas, vous avez la possibilité de la créer.</em></p>
        <hr />
        <h2>Appeler une fonction/procédure</h2>
        <p><em>En PHP, on appelle une fonction/procédure directement par son nom, suivi de parenthèses et de notre point-virgule qui signifie que l'on termine une instruction.<br />Si on considère une procédure qui aurait pour identifiant uneProcedureImaginaire :</em></p>
        <pre><code class="php">
&lt;?php
uneProcedureImaginaire(); // Appel de la fonction nommée "uneProcedureImaginaire" sans passage de paramètre.
uneProcedureImaginaire('chaîne de caractère', 10, 4.5, true); // Appel de la procédure nommée "uneProcedureImaginaire" avec plusieurs paramètres de types différents (que l'on sépare par des virgules).
?&gt;</code></pre>
        <h3>Récupérer la valeur de retour de la fonction</h3>
        <p><em>Maintenant que nous savons appeler une fonction et même lui envoyer plusieurs paramètres, il faut récupérer ce qu'elle nous retourne.<br />Si on considère une procédure qui aurait pour identifiant uneProcedureImaginaire :</em></p>
        <pre><code class="php">
&lt;?php
$retourFonction = uneFonctionImaginaire(10); // Appel de la fonction nommée "uneFonctionImaginaire" et récupération dans une variable nommée "retourFonction".
?&gt;</code></pre>
        <hr />
        <h2>Les fonctions prêtes à l'emploi de PHP</h2>
        <p><em>PHP propose des centaines de fonctions prêtes à l'emploi.<br />Sur le site officiel, la documentation PHP les répertorie toutes, classées par catégories : <a href="http://fr.php.net/manual/fr/funcref.php" target="_blank" title="">http://fr.php.net/manual/fr/funcref.php</a></em></p>
        <h3>Sur les chaînes de caractères</h3>
        <?php
        $maChaine = 'Lorem ipsum dolor sit amet';
        echo 'La chaine "' . $maChaine . '" est composée de ' . strlen($maChaine) . ' caractères.';
        ?>
        <pre><code class="php">
&lt;?php
$maChaine = 'Lorem ipsum dolor sit amet';
echo 'La chaine "' . $maChaine . '" est composée de ' . strlen($maChaine) . ' caractères.'; // Retourne la taille de la chaîne (http://fr.php.net/manual/fr/function.strlen.php)
?&gt;</code></pre>
        <?php
        $maChaine = 'body class="%body%"';
        echo 'La chaîne ' . $maChaine . ' devient : ' . str_replace('%body%', 'maClass', $maChaine);
        ?>
        <pre><code class="php">
&lt;?php
$maChaine = 'body class="%body%"';
echo 'La chaîne ' . $maChaine . ' devient : ' . str_replace('%body%', 'maClass', $maChaine); // Remplace toutes les occurrences dans une chaîne (http://fr.php.net/manual/fr/function.str-replace.php)
?&gt;</code></pre>
        <?php
        $maChaine = 'Lorem ipsum dolor sit amet';
        $maSousChaine = 'ipsum';
        $pos = strpos($maChaine, $maSousChaine);
        if($pos !== false) :
            echo 'La chaîne "' . $maSousChaine . '" a été trouvée dans la chaîne "' . $maChaine . '" et débute à la position : ' . $pos;
        else :
            echo 'La chaîne "' . $maSousChaine . '" ne se trouve pas dans la chaîne "' . $maChaine . '"';
        endif;
        ?>
        <pre><code class="php">
&lt;?php
$maChaine = 'Lorem ipsum dolor sit amet';
$maSousChaine = 'ipsum';
$pos = strpos($maChaine, $maSousChaine); // Cherche la position de la première occurrence dans une chaîne (http://fr.php.net/manual/fr/function.strpos.php)
if($pos !== false) :
    echo 'La chaîne ' . $maSousChaine . ' a été trouvée dans la chaîne ' . $maChaine . ' et débute à la position ' . $pos;
else :
    echo 'La chaîne ' . $maSousChaine . ' ne se trouve pas dans la chaîne ' . $maChaine;
endif;
?&gt;</code></pre>
        <h3>Sur les dates</h3>
        <?php
        echo 'Nous sommes le ' . date('d/m/Y') . ' et il est ' . date('H:i:s');
        ?>
        <pre><code class="php">
&lt;?php
echo 'Nous sommes le ' . date('d/m/Y') . ' et il est ' . date('H:i:s'); // Formate une date/heure locale (http://fr.php.net/manual/fr/function.date.php)
?&gt;</code></pre>
        <h3>Autres applications possibles</h3>
        <p><em>Les fonctions prêtes à l'emploi de PHP ne concernent pas que ces petites interactions mais peuvent être bien plus comme :</em></p>
        <ul style="font-style:italic;">
            <li>une fonction qui envoie un fichier sur un serveur,</li>
            <li>une fonction qui permet de créer des images miniatures,</li>
            <li>une fonction qui envoie un mail avec PHP,</li>
            <li>une fonction qui crypte des mots de passe,</li>
            <li>...</li>
        </ul>
        <hr />
        <h2>Créer ses propres fonctions/procédures</h2>
        <p><em>Quand écrire une fonction/procédure ? En général, si vous effectuez des opérations un peu complexes que vous pensez avoir besoin de refaire régulièrement.</em></p>
        <?php
        function afficherHelloYou($nom) {
            echo '<p>Bonjour ' . $nom . ' !</p>';
        }

        afficherHelloYou('Alex Térieur');
        afficherHelloYou('Alain Térieur');

        function retournerHelloYou($nom) {
            return '<p>Bonjour ' . $nom . ' !</p>';
        }
        echo retournerHelloYou('Ursulla Détresse');
        echo retournerHelloYou('Jean Aymar');
        ?>
        <pre><code class="php">
&lt;?php
function afficherHelloYou($nom) { // Procédure qui va dire bonjour à chaque personne passée en paramètre.
    echo '&lt;p&gt;Bonjour ' . $nom . ' !&lt;/p&gt;';
}

afficherHelloYou('Alex Térieur'); // Appel de la procédure avec la chaîne de caractère "Damien" passée en valeur de paramètre
afficherHelloYou('Alain Térieur');


function retournerHelloYou($nom) { // Procédure qui va retourner la chaîne de caractère bonjour modifiée avec le nom de la personne passée en paramètre.
    return '&lt;p&gt;Bonjour ' . $nom . ' !&lt;/p&gt;';
}
echo retournerHelloYou('Ursulla Détresse'); // Appel de la fonction avec la chaîne de caractère "Charles-Henri" passée en valeur de paramètre
echo retournerHelloYou('Jean Aymar');
?&gt;</code></pre>
        <hr />
        <h2>Fonctions/procédures récursives</h2>
        <p><em>Comme vu en algorithmique, une fonction/procédure récursive est une fonction/procédure qui s'appelle elle-même. L'exemple le plus parlant de récursivité est votre explorateur de fichiers.</em></p>
        <p><em>Prenons l'exemple de notre calcul de factorielle :<br /><small>Rappel : en mathématiques, la factorielle d'un entier naturel n est le produit des nombres entiers strictement positifs inférieurs ou égaux à n.</small></em></p>
        <?php
        function factorielle($n) {
            if($n===0) {
                return 1;
            } else {
                return $n * factorielle($n-1);
            }
        }
        $monEntier = 5;
        echo 'La factorielle de ' . $monEntier . ' est : ' . factorielle($monEntier);
        ?>
        <pre><code class="php">
&lt;?php
function factorielle($n) {
    if($n===0) {
        return 1;
    } else {
        return $n * factorielle($n-1);
    }
}
$monEntier = 5;
echo 'La factorielle de ' . $monEntier . ' est : ' . factorielle($monEntier);
?&gt;</code></pre>
        <p><em>On voit dans le code source que la fonction factorielle se rappelle elle-même : return $n * factorielle($n-1);<br />Que se passe-t-il concrètement dans notre machine lors d'un appel récursif ? Faisons un test en plaçant des message pour suivre son exécution :</em></p>
        <?php
        function afficherEtape($etape) {
            echo $etape;
        }
        function factorielleComment($n, $espacement) {
            $res = false;
            $retourLigne = '<br />';
            $indentation = '';
            for($cpt = 0; $cpt<($espacement*8); $cpt++) {
                $indentation .= '&nbsp;';
            }
            afficherEtape($retourLigne . $indentation . 'Début du calcul de factorielle(' . $n . ')');
            if($n===0) {
                $res = 1;
                afficherEtape($retourLigne . $indentation . 'Traitement du calcul de factorielle(' . $n . ') : renvoi de la valeur 1');
            } else {
                $res = $n * factorielleComment($n-1, $espacement+1);
                afficherEtape($retourLigne . $indentation . 'Traitement du calcul de factorielle(' . $n . ') : renvoi de la valeur ' . $n . ' * valeur renvoyée par factorielle(' . ($n - 1) . ')');
            }
            afficherEtape($retourLigne . $indentation . 'Fin du calcul de factorielle(' . $n . ')');
            if( $res!==false ) { return $res; }
        }
        $monEntier = 5;
        factorielleComment($monEntier, 0);
        ?>
        <pre><code class="php">
&lt;?php
function afficherEtape($etape) {
    echo $etape;
}
function factorielleComment($n, $espacement) {
    $res = false;
    $retourLigne = '&lt;br /&gt;';
    $indentation = '';
    for($cpt = 0; $cpt&lt;($espacement*8); $cpt++) {
        $indentation .= '&nbsp;';
    }
    afficherEtape($retourLigne . $indentation . 'Début du calcul de factorielle(' . $n . ')');
    if($n===0) {
        $res = 1;
        afficherEtape($retourLigne . $indentation . 'Traitement du calcul de factorielle(' . $n . ') : renvoi de la valeur 1');
    } else {
        $res = $n * factorielleComment($n-1, $espacement+1);
        afficherEtape($retourLigne . $indentation . 'Traitement du calcul de factorielle(' . $n . ') : renvoi de la valeur ' . $n . ' * valeur renvoyée par factorielle(' . ($n - 1) . ')');
    }
    afficherEtape($retourLigne . $indentation . 'Fin du calcul de factorielle(' . $n . ')');
    if( $res!==false ) { return $res; }
}
$monEntier = 5;
factorielleComment($monEntier, 0);
?&gt;</code></pre>
        <p class="block alert"><em>Le résultat ci-dessus nous montre bien que l'appel parent ne peut pas se terminer tant que la récursion n'est pas elle-même terminée, puisque le calcul de multiplication ne peut se faire qu'avec le résultat de cette récursion.</em></p>
    </body>
</html>