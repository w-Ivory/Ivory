<?php
$datas = [
    ['letter' => 'a', 'goto' => 10],
    ['letter' => 'e', 'goto' => -1],
    ['letter' => 'e', 'goto' => 6],
    ['letter' => 'l', 'goto' => 1],
    ['letter' => 'p', 'goto' => 8],
    ['letter' => 'o', 'goto' => 11],
    ['letter' => 'x', 'goto' => 12],
    ['letter' => 'p', 'goto' => 3],
    ['letter' => 'r', 'goto' => 5],
    ['letter' => 'm', 'goto' => 7],
    ['letter' => 'b', 'goto' => 3],
    ['letter' => 'b', 'goto' => 0],
    ['letter' => 'a', 'goto' => 9]
];

/**
 * wordGen - Parcours un tableau pour construire une chaine de caractères
 * @param   array $db
 * @param   int $index
 * @return  string
**/
function wordGen( $db, $index ) {
    $word = '';

    while( isset( $db[$index] ) && $db[$index]['goto']!=-1 ) : // Tant que l'index existe dans le tableau et que la valeur affectée à la clé "goto" présente à cet index est différente de -1,
        $word .= $db[$index]['letter']; // On ajoute la lettre stockée
        $index = $db[$index]['goto']; // On récupère l'index suivant
    endwhile;

    $word .= isset( $db[$index] ) ? $db[$index]['letter'] : '<span style="background-color:red;color:white;display:block;padding:4px 7px;">Vous devez saisir un entier compris entre 1 et ' . count( $db ) . '!</span>'; // Si l'index existe dans le tableau, on ajoute la lettre stockée (qui sera la dernière lettre du mot généré)

    return $word;
}
?><!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0" />
        <title>Liste chainée | Le passage de données - Mise en pratique</title>

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
        <h1>Liste chainée | Le passage de données - Mise en pratique</h1>
        <p><em>Dans cet exercice, soit un ensemble de données défini comme suit :</em></p>
        <pre><code class="php">
$datas = array(
    array('letter' => 'a', 'goto' => 10),
    array('letter' => 'e', 'goto' => -1),
    array('letter' => 'e', 'goto' => 6),
    array('letter' => 'l', 'goto' => 1),
    array('letter' => 'p', 'goto' => 8),
    array('letter' => 'o', 'goto' => 11),
    array('letter' => 'x', 'goto' => 12),
    array('letter' => 'p', 'goto' => 3),
    array('letter' => 'r', 'goto' => 5),
    array('letter' => 'm', 'goto' => 7),
    array('letter' => 'b', 'goto' => 3),
    array('letter' => 'b', 'goto' => 0),
    array('letter' => 'a', 'goto' => 9)
);</code></pre>
        <p><em>Chaque élément de $datas est une paire lettre-suivant, où lettre est un caractere à afficher, et suivant est la position de l'élément suivant dans $datas(-1 signifiant qu'il n'y a pas d'élément après celui-ci).<br />Par exemple l'élément 3 correspond à la lettre l qui est suivie par l'élément 1 (c'est à dire un e final)</em></p>
        <p><em>Le but est d'écrire une fonction acceptant en paramètre un index de départ, et qui permet d'obtenir le mot composé à partir de l'élément à cet index et de tous les éléments suivants.<br />Par exemple l'entrée 2 devrait permettre d'obtenir "exemple", l'entrée 4 "probable", l'entrée 0 "able".</em></p>
        <p><em>Tester cette fonction avec les entrées de tableau avec 3, 5, 1 et 13 (si vous n'êtes qu'un simple humain qui commence à compter à partir de 1) ou avec 2, 4, 0 et 12 (si vous êtes un développeur).</em></p>
        <blockquote><em>Exercice librement inspiré d'une énigme du jeu Human Ressource Machine, elle même inspirée du fonctionnement des listes chaînées.</em></blockquote>
        <hr />
        <form action="" method="POST" name="frm-generator" novalidate="novalidate">
            <label for="txt-index">Index de départ (entre 1 et <?php echo count( $datas ); ?>) :</label>
            <br /><input id="txt-index" name="index" type="number" min="1" max="<?php echo count( $datas ); ?>" type="number" value="<?php if( isset( $_POST['index'] ) ) echo $_POST['index']; ?>" />
            
            <br /><input<?php if( !isset( $_POST['user-type'] ) || ( isset( $_POST['user-type'] ) && $_POST['user-type']==1 ) ) echo ' checked="checked"'; ?> id="radio-humain" name="user-type" type="radio" value="1" /><label for="radio-humain">Je suis un simple humain</label> / <input<?php if( isset( $_POST['user-type'] ) && $_POST['user-type']==0 ) echo ' checked="checked"'; ?> id="radio-developer" name="user-type" type="radio" value="0" /><label for="radio-developer">Je suis un développeur</label>
            
            <br /><input type="submit" value="Générer un mot à partir de l'index" />
        </form>
        <?php
        if( isset( $_POST['index'] ) ) : // Si on soumet une valeur via le formulaire,
            if( is_numeric( $_POST['index'] ) ) : // Si cette valeur est numérique,
                if( isset( $_POST['user-type'] ) && is_numeric( $_POST['user-type'] ) && $_POST['user-type']==1 ) // Si on soumet un type d'utilisateur,
                    $_POST['index'] -= $_POST['user-type']; // On soustrait 1 à l'index de déaprt puisqu'un tableau débute à la clé 0 et que notre demande était un nombre entre 1 et ...
                
                echo '<span style="border:black thin solid;display:block;margin:10px 0;padding:4px 7px;">' . wordGen( $datas, $_POST['index'] ) . '</span>';
            else :
                echo '<span style="border:black thin solid;display:block;margin:10px 0;padding:4px 7px;"><span style="background-color:red;color:white;display:block;padding:4px 7px;">Vous devez saisir une valeur numérique !</span></span>';
            endif;
        endif;
        ?>
        <pre><code class="php">
$datas = [
    ['letter' =&gt; 'a', 'goto' =&gt; 10],
    ['letter' =&gt; 'e', 'goto' =&gt; -1],
    ['letter' =&gt; 'e', 'goto' =&gt; 6],
    ['letter' =&gt; 'l', 'goto' =&gt; 1],
    ['letter' =&gt; 'p', 'goto' =&gt; 8],
    ['letter' =&gt; 'o', 'goto' =&gt; 11],
    ['letter' =&gt; 'x', 'goto' =&gt; 12],
    ['letter' =&gt; 'p', 'goto' =&gt; 3],
    ['letter' =&gt; 'r', 'goto' =&gt; 5],
    ['letter' =&gt; 'm', 'goto' =&gt; 7],
    ['letter' =&gt; 'b', 'goto' =&gt; 3],
    ['letter' =&gt; 'b', 'goto' =&gt; 0],
    ['letter' =&gt; 'a', 'goto' =&gt; 9]
];

/**
 * wordGen - Parcours un tableau pour construire une chaine de caractères
 * @param   array $db
 * @param   int $index
 * @return  string
**/
function wordGen( $db, $index ) {
    $word = '';

    while( isset( $db[$index] ) && $db[$index]['goto']!=-1 ) : // Tant que l'index existe dans le tableau et que la valeur affectée à la clé "goto" présente à cet index est différente de -1,
        $word .= $db[$index]['letter']; // On ajoute la lettre stockée
        $index = $db[$index]['goto']; // On récupère l'index suivant
    endwhile;

    $word .= isset( $db[$index] ) ? $db[$index]['letter'] : '&lt;span style="background-color:red;color:white;display:block;padding:4px 7px;"&gt;Vous devez saisir un entier compris entre 1 et ' . count( $db ) . '!&lt;/span&gt;'; // Si l'index existe dans le tableau, on ajoute la lettre stockée (qui sera la dernière lettre du mot généré)

    return $word;
}</code>
<code class="html">
&lt;form action="" method="POST" name="frm-generator" novalidate="novalidate"&gt;
    &lt;label for="txt-index"&gt;Index de départ (entre 1 et &lt;?php echo count( $datas ); ?&gt;) :&lt;/label&gt;
    &lt;br /&gt;&lt;input id="txt-index" name="index" type="number" min="1" max="&lt;?php echo count( $datas ); ?&gt;" type="number" value="&lt;?php if( isset( $_POST['index'] ) ) echo $_POST['index']; ?&gt;" /&gt;
    
    &lt;br /&gt;&lt;input&lt;?php if( !isset( $_POST['user-type'] ) || ( isset( $_POST['user-type'] ) && $_POST['user-type']==1 ) ) echo ' checked="checked"'; ?&gt; id="radio-humain" name="user-type" type="radio" value="1" /&gt;&lt;label for="radio-humain"&gt;Je suis un simple humain&lt;/label&gt; / &lt;input&lt;?php if( isset( $_POST['user-type'] ) && $_POST['user-type']==0 ) echo ' checked="checked"'; ?&gt; id="radio-developer" name="user-type" type="radio" value="0" /&gt;&lt;label for="radio-developer"&gt;Je suis un développeur&lt;/label&gt;
    
    &lt;br /&gt;&lt;input type="submit" value="Générer un mot à partir de l'index" /&gt;
&lt;/form&gt;
&lt;?php
if( isset( $_POST['index'] ) ) : // Si on soumet une valeur via le formulaire,
    if( is_numeric( $_POST['index'] ) ) : // Si cette valeur est numérique,
        if( isset( $_POST['user-type'] ) && is_numeric( $_POST['user-type'] ) ) // Si on soumet un type d'utilisateur,
            $_POST['index'] -= $_POST['user-type']; // On soustrait 1 à l'index de déaprt puisqu'un tableau débute à la clé 0 et que notre demande était un nombre entre 1 et ...
        echo '&lt;span style="border:black thin solid;display:block;margin:10px 0;padding:4px 7px;"&gt;' . wordGen( $datas, $_POST['index'] ) . '&lt;/span&gt;';
    else :
        echo '&lt;span style="border:black thin solid;display:block;margin:10px 0;padding:4px 7px;"&gt;&lt;span style="background-color:red;color:white;display:block;padding:4px 7px;"&gt;Vous devez saisir une valeur numérique !&lt;/span&gt;&lt;/span&gt;';
    endif;
endif;
?&gt;</code></pre>
    </body>
</html>