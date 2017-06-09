<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0" />
        <title>Les tableaux</title>

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
        <h1>Les tableaux</h1>
        <p><em>Un tableau (array) est aussi une variable mais d'un type particulier.<br />Les variables comme nous les connaissons, se compose d'un nom qui l'identifie et d'une valeur. Un tableau quant à lui se compose aussi d'un nom mais peut prendre plusieurs valeurs en même temps.<br />Vous pouvez vous représenter mentalement son fonctionnement comme un classeur (la variable) ayant plusieurs tiroirs, chaque tiroir contenant une valeur.</em></p>
        <hr />
        <h2>Déclarer un tableau</h2>
        <p><em>Un tableau se déclare en affectant à une variable la fonction "array()".</em></p>
        <pre><code class="php">
&lt;?php
$monTableau = array(); // Déclaration d'un tableau vide
?&gt;</code></pre>
        <hr />
        <h2>Afficher l'ensemble des données d'un tableau</h2>
        <p><em>La structure de langage "echo" ne prend en charge que les chaînes de caractères. Afin de pouvoir afficher les éléments d'un tableau, nous devrons utiliser la procédure "print_r()".</em></p>
        <pre><code class="php">
&lt;?php
$monTableau = array(); // Déclaration d'un tableau vide
print_r($monTableau); // Affichage de la structure du tableau
?&gt;</code></pre>
        <hr />
        <h2>Les tableaux numérotés</h2>
        <p><em>Un tableau numéroté est une variable pour laquelle chaque valeur stockée est associée automatiquement à un numéro qui s'incrémente tout seul, <strong>le premier numéro attribué étant 0</strong>. Ce numéro est appelé une "clé".<br />Ils sont utilisés en général pour stocker une série d'éléments du même type.</em></p>
        <h3>Remplir un tableau numéroté</h3>
        <p><em>Par défaut, un tableau numéroté peut être rempli via une liste de valeurs séparées par des virgules. Le premier élément renseigné se verra donc attribuer la clé 0, le deuxième élément aura le numéro 1, le troisième élément le numéro 2, ...</em></p>
        Array
(
    [0] => Pommes
    [1] => Poires
    [2] => Scoubidous
)
        <pre><code class="php">
&lt;?php
$maListeDeCourses = array('Pommes', 'Poires', 'Scoubidous');
?&gt;</code></pre>
        <p><em>Si on le souhaite, on peut aussi enregistrer séparemment les valeurs :</em></p>
        Array
(
    [0] => Pommes
    [1] => Poires
    [2] => Scoubidous
)
        <pre><code class="php">
&lt;?php
$maListeDeCourses = array(); // Déclaration d'un tableau vide
$maListeDeCourses[] = 'Pommes'; // Affectation de la valeur "Pommes". Celle-ci étant la première renseignée, elle prendra la clé "0" du tableau
$maListeDeCourses[] = 'Poires'; // Affectation de la valeur "Poires". Celle-ci étant la deuxième renseignée, elle prendra la clé "1" du tableau
$maListeDeCourses[] = 'Scoubidous'; // ...
?&gt;</code></pre>
        <p><em>Si on le souhaite, on peut aussi attribuer manuellement les valeurs pour chaque clé :</em></p>
        Array
(
    [0] => Pommes
    [1] => Poires
    [2] => Scoubidous
)
        <pre><code class="php">
&lt;?php
$maListeDeCourses = array(); // Déclaration d'un tableau vide
$maListeDeCourses[0] = 'Pommes'; // Affectation de la valeur "Pommes" dans la clé "0" du tableau
$maListeDeCourses[1] = 'Poires'; // Affectation de la valeur "Poires" dans la clé "1" du tableau
$maListeDeCourses[2] = 'Scoubidous'; // ...
?&gt;</code></pre>
        <p class="block alert"><em>Attention de ce dernier cas à incrémenter correctement les clés afin de s'épargner des problèmatiques pour la suite.</em></p>
        <h3>Afficher une valeur contenue dans un tableau numéroté</h3>
        <p><em>Pour afficher un élément, il faut donner sa position dans le tableau : sa clé.</em></p>
        Le premier élément de ma liste de courses est : Pommes<br />Le deuxième élément de ma liste de courses est : Poires<br />Le troisième élément de ma liste de courses est : Scoubidous        <pre><code class="php">
&lt;?php
$maListeDeCourses = array('Pommes', 'Poires', 'Scoubidous');
echo 'Le premier élément de ma liste de courses est : ' . $maListeDeCourses[0];
echo '&lt;br /&gt;Le deuxième élément de ma liste de courses est : ' . $maListeDeCourses[1];
echo '&lt;br /&gt;Le troisième élément de ma liste de courses est : ' . $maListeDeCourses[2];
?&gt;</code></pre>
        <p><em>Comme ma liste est numérotée, je peux donc parcourir mon tableau avec une boucle.<br />Pour nous aider, la bibliothèque PHP nous fournit une fonction qui nous retourne le nombre d'éléments d'un tableau : la fonction "count()".</em></p>
        <br />Pommes<br />Poires<br />Scoubidous        <pre><code class="php">
&lt;?php
$maListeDeCourses = array('Pommes', 'Poires', 'Scoubidous');
for($cpt=0; $cpt&lt;count($maListeDeCourses); $cpt++) { // count() fournit le nombre d'éléments dans le tableau passé en paramètre.
    echo '&lt;br /&gt;' . $maListeDeCourses[$cpt];
}
?&gt;</code></pre>
        <hr />
        <h2>Les tableaux associatifs</h2>
        <p><em>Les tableaux associatifs fonctionnent sur le même principe, sauf qu'au lieu de numéroter les tiroirs on va les étiqueter en leur donnant à chacune un nom différent.<br />On utilise le marqueur "=>" pour dire que l'on associe une clé à une valeur.</em></p>
        Array
(
    [nom] => TIVELET
    [prenom] => Damien
    [anneeNaissance] => 1982
    [role] => Formateur
    [entreprise] => Objectif 3W
)
        <pre><code class="php">
&lt;?php
$ficheIdentite = array(
    'nom'           => 'TIVELET', // Associe la clé "nom" à la valeur "TIVELET"
    'prenom'        => 'Damien', // Associe la clé "prenom" à la valeur "Damien"
    'anneeNaissance'=> 1982, // ...
    'role'          => 'Formateur',
    'entreprise'    => 'Objectif 3W'
);
print_r($ficheIdentite);
?&gt;</code></pre>
        <p class="block alert"><em>On rappelle que tant que nous ne rencontrons pas de point-virgule dans notre code, ce dernier considère que l'instruction en cours n'est pas terminée.<br />La déclaration de mon tableau sur plusieurs lignes n'est donc qu'une seule instruction mais devient plus lisible pour la maintenance du code.<br />On aurait pu tout aussi bien écrire : $ficheIdentite = array('nom'=>'TIVELET', 'prenom'=>'Damien', 'role'=>'Formateur', 'entreprise'=>'Objectif 3W');</em></p>
        <p><em>Si on le souhaite, on peut aussi attribuer manuellement les valeurs pour chaque clé :</em></p>
        Array
(
    [nom] => TIVELET
    [prenom] => Damien
    [anneeNaissance] => 1982
    [role] => Formateur
    [entreprise] => Objectif 3W
)
        <pre><code class="php">
&lt;?php
$ficheIdentite = array();
$ficheIdentite['nom'] = 'TIVELET';
$ficheIdentite['prenom'] = 'Damien';
$ficheIdentite['anneeNaissance'] = 1982;
$ficheIdentite['role'] = 'Formateur';
$ficheIdentite['entreprise'] = 'Objectif 3W';
print_r($ficheIdentite);
?&gt;</code></pre>
        <h3>Afficher une valeur contenue dans un tableau associatif</h3>
        <p><em>Pour afficher un élément, il faut donner sa position dans le tableau : sa clé.</em></p>
        Nom : TIVELET<br />Prénom : Damien<br />Année de naissance : 1982<br />Rôle : Formateur<br />Entreprise : Objectif 3W        <pre><code class="php">
&lt;?php
$ficheIdentite = array(
    'nom'           =&gt; 'TIVELET',
    'prenom'        =&gt; 'Damien',
    'anneeNaissance'=&gt; 1982,
    'role'          =&gt; 'Formateur',
    'entreprise'    =&gt; 'Objectif 3W'
);
echo 'Nom : ' . $ficheIdentite['nom'];
echo '&lt;br /&gt;Prénom : ' . $ficheIdentite['prenom'];
echo '&lt;br /&gt;Année de naissance : ' . $ficheIdentite['anneeNaissance'];
echo '&lt;br /&gt;Rôle : ' . $ficheIdentite['role'];
echo '&lt;br /&gt;Entreprise : ' . $ficheIdentite['entreprise'];
?&gt;</code></pre>
        <hr />
        <h2>Parcourir un tableau élément par élément</h2>
        <p><em>On a constaté que la boucle "for" fonctionne très bien pour un tableau numéroté dont les clés sont ordonnées et se succèdent.<br />Comment traiter alors un tableau numéroté qui ne respecte pas ces conditions ou un tableau associatif ?<br />Pour répondre à cette problématique, nous avons à notre disposition une nouvelle boucle : foreach.</em></p>
        <p><em>La boucle "foreach" va d'abord tester si un enregistrement est présent dans le tableau et si c'est le cas, va attribuer la valeur de l'élément courant à une variable ... et va ainsi parcourir tout le tableau en réaffectant à chaque fois la nouvelle valeur trouvée à cette variable.</em></p>
        Pommes<br />Poires<br />Scoubidous<br /><br />TIVELET<br />Damien<br />1982<br />Formateur<br />Objectif 3W<br />        <pre><code class="php">
&lt;?php
$maListeDeCourses = array('Pommes', 'Poires', 'Scoubidous');
foreach($maListeDeCourses as $monProduit) {
    echo $monProduit . '&lt;br /&gt;';
}
echo '&lt;br /&gt;';
$ficheIdentite = array(
    'nom'           =&gt; 'TIVELET',
    'prenom'        =&gt; 'Damien',
    'anneeNaissance'=&gt; 1982,
    'role'          =&gt; 'Formateur',
    'entreprise'    =&gt; 'Objectif 3W'
);
foreach($ficheIdentite as $monElement) {
    echo $monElement . '&lt;br /&gt;';
}
/**
 * Une autre écriture est possible, qui ressemble d'avantage à l'écriture algorithmique :
 *      foreach($ficheIdentite as $monElement) :
 *          //...
 *      endforeach;
**/
?&gt;</code></pre>
        <p><em>Toutefois, avec cet exemple, on ne récupère que la valeur. Or, on peut aussi récupérer la clé de l'élément.</em></p>
        La clé [nom] contient : TIVELET<br />La clé [prenom] contient : Damien<br />La clé [anneeNaissance] contient : 1982<br />La clé [role] contient : Formateur<br />La clé [entreprise] contient : Objectif 3W<br />        <pre><code class="php">
&lt;?php
$ficheIdentite = array(
    'nom'           =&gt; 'TIVELET',
    'prenom'        =&gt; 'Damien',
    'anneeNaissance'=&gt; 1982,
    'role'          =&gt; 'Formateur',
    'entreprise'    =&gt; 'Objectif 3W'
);
foreach($ficheIdentite as $cle=>$valeur) {
    echo 'La clé [' . $cle . '] contient : ' . $valeur . '&lt;br /&gt;';
}
?&gt;</code></pre>
        <hr />
        <h2>Rechercher dans un tableau</h2>
        <h3>Vérifier si une clé existe dans le tableau : array_key_exists</h3>
        <p><em>La fonction renvoie un booléen, c'est-à-dire true(vrai) si la clé est dans le tableau et false(faux) si la clé ne s'y trouve pas. Cela nous permet de faire un test facilement avec une structure alternative.</em></p>
        La clé [entreprise] existe dans le tableau et vaut : Objectif 3W<br />La clé [adresse] n'existe pas dans le tableau        <pre><code class="php">
&lt;?php
$ficheIdentite = array(
    'nom'           => 'TIVELET',
    'prenom'        => 'Damien',
    'anneeNaissance'=> 1982,
    'role'          => 'Formateur',
    'entreprise'    => 'Objectif 3W'
);
if(array_key_exists('entreprise', $ficheIdentite)) :
    echo 'La clé [entreprise] existe dans le tableau et vaut : ' . $ficheIdentite['entreprise'];
else :
    echo 'La clé [entreprise] n\'existe pas dans le tableau';
endif;
echo '&lt;br /&gt;';
if(array_key_exists('adresse', $ficheIdentite)) :
    echo 'La clé [adresse] existe dans le tableau et vaut : ' . $ficheIdentite['adresse'];
else :
    echo 'La clé [adresse] n\'existe pas dans le tableau';
endif;
?&gt;</code></pre>
        <h3>Vérifier si une valeur existe dans le tableau : in_array</h3>
        <p><em>Le principe est le même que "array_key_exists" mais cette fois on recherche dans les valeurs.</em></p>
        La valeur "Poires" est présente dans le tableau<br />La valeur "Reblochon" n'est pas présente dans le tableau        <pre><code class="php">
&lt;?php
$maListeDeCourses = array('Pommes', 'Poires', 'Scoubidous');
if(in_array('Poires', $maListeDeCourses)) :
    echo 'La valeur "Poires" est présente dans le tableau';
else :
    echo 'La valeur "Poires" n\'est pas présente dans le tableau';
endif;
echo '&lt;br /&gt;';
if(in_array('Reblochon', $maListeDeCourses)) :
    echo 'La valeur "Reblochon" est présente dans le tableau';
else :
    echo 'La valeur "Reblochon" n\'est pas présente dans le tableau';
endif;
?&gt;</code></pre>
        <h3>Récupérer la clé d'une valeur dans le tableau : array_search</h3>
        <p><em>La fonction renvoie "false" si elle ne trouve pas la valeur dans le tableau et renvoie sa clé si elle trouve.</em></p>
        La valeur "Poires" est présente dans le tableau à la clé : 1<br />La valeur "Reblochon" n'est pas présente dans le tableau<br />La valeur "Damien" est présente dans le tableau à la clé : prenom<br />La valeur "Montpellier" n'est pas présente dans le tableau        <pre><code class="php">
&lt;?php
$maListeDeCourses = array('Pommes', 'Poires', 'Scoubidous');
if(array_search('Poires', $maListeDeCourses)!==false) :
    echo 'La valeur "Poires" est présente dans le tableau à la clé : ' . array_search('Poires', $maListeDeCourses);
else :
    echo 'La valeur "Poires" n\'est pas présente dans le tableau';
endif;
echo '&lt;br /&gt;';
if(array_search('Reblochon', $maListeDeCourses)!==false) :
    echo 'La valeur "Reblochon" est présente dans le tableau à la clé : ' . array_search('Poires', $maListeDeCourses);
else :
    echo 'La valeur "Reblochon" n\'est pas présente dans le tableau';
endif;

echo '&lt;br /&gt;';
$ficheIdentite = array(
    'nom'           =&gt; 'TIVELET',
    'prenom'        =&gt; 'Damien',
    'anneeNaissance'=&gt; 1982,
    'role'          =&gt; 'Formateur',
    'entreprise'    =&gt; 'Objectif 3W'
);
if(array_search('Damien', $ficheIdentite)!==false) :
    echo 'La valeur "Damien" est présente dans le tableau à la clé : ' . array_search('Damien', $ficheIdentite);
else :
    echo 'La valeur "Damien" n\'est pas présente dans le tableau';
endif;
echo '&lt;br /&gt;';
if(array_search('Montpellier', $ficheIdentite)!==false) :
    echo 'La valeur "Montpellier" est présente dans le tableau à la clé : ' . array_search('Montpellier', $ficheIdentite);
else :
    echo 'La valeur "Montpellier" n\'est pas présente dans le tableau';
endif;
?&gt;</code></pre>
        <hr />
        <h2>Trier les éléments d'un tableau</h2>
        <p><em>PHP propose plusieurs fonctions prêtes à l'emploi pour les tris avec pour chacune des particularités.<br>Sur le site officiel, la documentation PHP les répertorie toutes, classées par catégories : <a href="http://php.net/manual/fr/array.sorting.php" target="_blank" title="">php.net/manual/fr/array.sorting.php</a></em></p>
        <h3>Trier les valeurs par ordre croissant : sort</h3>
        <p><em>La fonction "sort()" trie le tableau. Les éléments seront triés du plus petit au plus grand.</em></p>
        Tableau non trié : Array
(
    [0] => img1.jpg
    [1] => img3.jpg
    [2] => img12.jpg
    [3] => img10.jpg
    [4] => img5.jpg
)
<br />Tableau trié : Array
(
    [0] => img1.jpg
    [1] => img10.jpg
    [2] => img12.jpg
    [3] => img3.jpg
    [4] => img5.jpg
)
        <pre><code class="php">
&lt;?php
$mesImages = array('img1.jpg', 'img3.jpg', 'img12.jpg', 'img10.jpg', 'img5.jpg');
echo 'Tableau non trié : ';
print_r($mesImages);
echo '&lt;br /&gt;';
echo 'Tableau trié : ';
sort($mesImages);
print_r($mesImages);
?&gt;</code></pre>
        <h3>Trier les valeurs par ordre décroissant : rsort</h3>
        <p><em>La fonction "rsort()" trie le tableau. Les éléments seront triés du plus grand au plus petit.</em></p>
        Tableau non trié : Array
(
    [0] => img1.jpg
    [1] => img3.jpg
    [2] => img12.jpg
    [3] => img10.jpg
    [4] => img5.jpg
)
<br />Tableau trié normalement : Array
(
    [0] => img1.jpg
    [3] => img10.jpg
    [2] => img12.jpg
    [1] => img3.jpg
    [4] => img5.jpg
)
<br />Tableau trié par ordre décroissant : Array
(
    [0] => img5.jpg
    [1] => img3.jpg
    [2] => img12.jpg
    [3] => img10.jpg
    [4] => img1.jpg
)
        <pre><code class="php">
&lt;?php
$mesImages = array('img1.jpg', 'img3.jpg', 'img12.jpg', 'img10.jpg', 'img5.jpg');
echo 'Tableau non trié : ';
print_r($mesImages);
echo '&lt;br /&gt;';
echo 'Tableau trié normalement : ';
$mesImages = array('img1.jpg', 'img3.jpg', 'img12.jpg', 'img10.jpg', 'img5.jpg');
asort($mesImages);
print_r($mesImages);
echo '&lt;br /&gt;';
echo 'Tableau trié en ordre naturel : ';
$mesImages = array('img1.jpg', 'img3.jpg', 'img12.jpg', 'img10.jpg', 'img5.jpg');
rsort($mesImages);
print_r($mesImages);
?&gt;</code></pre>
        <h3>Trier les valeurs par ordre croissant en conservant l'association clé/valeur : asort</h3>
        <p><em>La fonction "asort()" trie le tableau de telle manière que la corrélation entre les index et les valeurs soit conservée. L'usage principal est lors de tri de tableaux associatifs où l'ordre des éléments est important.</em></p>
        Tableau non trié : Array
(
    [nom] => TIVELET
    [prenom] => Damien
    [anneeNaissance] => 1982
    [role] => Formateur
    [entreprise] => Objectif 3W
)
<br />Tableau trié : Array
(
    [prenom] => Damien
    [role] => Formateur
    [entreprise] => Objectif 3W
    [nom] => TIVELET
    [anneeNaissance] => 1982
)
        <pre><code class="php">
&lt;?php
$ficheIdentite = array(
    'nom'           => 'TIVELET',
    'prenom'        => 'Damien',
    'anneeNaissance'=> 1982,
    'role'          => 'Formateur',
    'entreprise'    => 'Objectif 3W'
);
echo 'Tableau non trié : ';
print_r($ficheIdentite);
echo '&lt;br /&gt;';
echo 'Tableau trié : ';
asort($ficheIdentite);
print_r($ficheIdentite);
?&gt;</code></pre>
        <h3>Trier les clés par ordre croissant en conservant l'association clé/valeur : ksort</h3>
        <p><em>La fonction "asort()" trie le tableau  suivant les clés, en maintenant la correspondance entre les clés et les valeurs. Cette fonction est pratique pour les tableaux associatifs.</em></p>
        Tableau non trié : Array
(
    [nom] => TIVELET
    [prenom] => Damien
    [anneeNaissance] => 1982
    [role] => Formateur
    [entreprise] => Objectif 3W
)
<br />Tableau trié : Array
(
    [anneeNaissance] => 1982
    [entreprise] => Objectif 3W
    [nom] => TIVELET
    [prenom] => Damien
    [role] => Formateur
)
        <pre><code class="php">
&lt;?php
$ficheIdentite = array(
    'nom'           => 'TIVELET',
    'prenom'        => 'Damien',
    'anneeNaissance'=> 1982,
    'role'          => 'Formateur',
    'entreprise'    => 'Objectif 3W'
);
echo 'Tableau non trié : ';
print_r($ficheIdentite);
echo '&lt;br /&gt;';
echo 'Tableau trié : ';
ksort($ficheIdentite);
print_r($ficheIdentite);
?&gt;</code></pre>
        <h3>Trier les valeurs par ordre "naturel" croissant en conservant l'association clé/valeur : natsort</h3>
        <p><em>La fonction "natsort()" implémente un algorithme de tri qui traite les chaînes alphanumériques du tableau array comme un être humain tout en conservant la relation clé/valeur. C'est ce qui est appelé l'"ordre naturel".</em></p>
        Tableau non trié : Array
(
    [0] => img1.jpg
    [1] => img3.jpg
    [2] => img12.jpg
    [3] => img10.jpg
    [4] => img5.jpg
)
<br />Tableau trié normalement : Array
(
    [0] => img1.jpg
    [3] => img10.jpg
    [2] => img12.jpg
    [1] => img3.jpg
    [4] => img5.jpg
)
<br />Tableau trié en ordre naturel : Array
(
    [0] => img1.jpg
    [1] => img3.jpg
    [4] => img5.jpg
    [3] => img10.jpg
    [2] => img12.jpg
)
        <pre><code class="php">
&lt;?php
$mesImages = array('img1.jpg', 'img3.jpg', 'img12.jpg', 'img10.jpg', 'img5.jpg');
echo 'Tableau non trié : ';
print_r($mesImages);
echo '&lt;br /&gt;';
echo 'Tableau trié normalement : ';
$mesImages = array('img1.jpg', 'img3.jpg', 'img12.jpg', 'img10.jpg', 'img5.jpg');
asort($mesImages);
print_r($mesImages);
echo '&lt;br /&gt;';
echo 'Tableau trié en ordre naturel : ';
$mesImages = array('img1.jpg', 'img3.jpg', 'img12.jpg', 'img10.jpg', 'img5.jpg');
natsort($mesImages);
print_r($mesImages);
?&gt;</code></pre>
        <hr />
        <h2>Les tableaux à plusieurs dimensions</h2>
        <p><em>Comme on l'a vu, un tableau à n dimension est un tableau stocké en valeur d'un autre tableau, stocké en valeur d'un autre tableau, ...</em></p>
        Array
(
    [0] => Array
        (
            [nom] => TIVELET
            [prenom] => Damien
            [anneeNaissance] => 1982
            [role] => Formateur
            [entreprise] => Objectif 3W
        )

    [1] => Array
        (
            [nom] => MCFLY
            [prenom] => Marty
            [anneeNaissance] => 1955
            [role] => Voyageur du temps et père de lui-même
            [entreprise] => DOC INC.
        )

    [2] => Array
        (
            [nom] => BROWN
            [prenom] => Emmett
            [anneeNaissance] => 1914
            [role] => Savant excentrique
            [entreprise] => DeLorean
        )

)
<br /><br />Array(<br />&nbsp;&nbsp;&nbsp;&nbsp;[0] => Array(<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[nom] => TIVELET <br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[prenom] => Damien <br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[anneeNaissance] => 1982 <br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[role] => Formateur <br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[entreprise] => Objectif 3W <br />&nbsp;&nbsp;&nbsp;&nbsp;)<br />&nbsp;&nbsp;&nbsp;&nbsp;[1] => Array(<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[nom] => MCFLY <br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[prenom] => Marty <br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[anneeNaissance] => 1955 <br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[role] => Voyageur du temps et père de lui-même <br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[entreprise] => DOC INC. <br />&nbsp;&nbsp;&nbsp;&nbsp;)<br />&nbsp;&nbsp;&nbsp;&nbsp;[2] => Array(<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[nom] => BROWN <br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[prenom] => Emmett <br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[anneeNaissance] => 1914 <br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[role] => Savant excentrique <br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[entreprise] => DeLorean <br />&nbsp;&nbsp;&nbsp;&nbsp;)<br />)        <pre><code class="php">
&lt;?php
$tableauDimensions = array(
    array(
        'nom'           =&gt; 'TIVELET',
        'prenom'        =&gt; 'Damien',
        'anneeNaissance'=&gt; 1982,
        'role'          =&gt; 'Formateur',
        'entreprise'    =&gt; 'Objectif 3W'
    ),
    array(
        'nom'           =&gt; 'MCFLY',
        'prenom'        =&gt; 'Marty',
        'anneeNaissance'=&gt; 1955,
        'role'          =&gt; 'Voyageur du temps et père de lui-même',
        'entreprise'    =&gt; 'DOC INC.'
    ),
    array(
        'nom'           =&gt; 'BROWN',
        'prenom'        =&gt; 'Emmett',
        'anneeNaissance'=&gt; 1914,
        'role'          =&gt; 'Savant excentrique',
        'entreprise'    =&gt; 'DeLorean'
    )
);
print_r($tableauDimensions);

echo'&lt;br /&gt;';
echo'&lt;br /&gt;Array(';
foreach($tableauDimensions as $key=&gt;$dimension) : // Pour chaque élément de $tableauDimensions crée la variable $dimensions
    echo'&lt;br /&gt;&nbsp;&nbsp;&nbsp;&nbsp;[' . $key . '] =&gt; Array(';
    foreach($dimension as $cle=&gt;$element) : // Pour chaque élément de $dimensions crée la variable $element
        echo '&lt;br /&gt;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[' . $cle . '] =&gt; ' . $element . ' ';
    endforeach;
    echo '&lt;br /&gt;&nbsp;&nbsp;&nbsp;&nbsp;)';
endforeach;
echo '&lt;br /&gt;)';
?&gt;</code></pre>
    </body>
</html>