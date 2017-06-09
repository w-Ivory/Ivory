<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0" />
        <title>Articles aléatoires | Les tableaux - Mise en pratique</title>

        <link rel="stylesheet" type="text/css" href="../../_assets/css/style.css">

        <!-- // highlight.js : Coloration syntaxique du code -->
        <link rel="stylesheet" type="text/css" href="../../_assets/plugins/highlight/styles/monokai_sublime.css">
        <script type="text/javascript" src="../../_assets/plugins/highlight/highlight.pack.js"></script>
        <script type="text/javascript">
            hljs.initHighlightingOnLoad();
        </script>
        <!-- // -->

        <style type="text/css">
            <!--
            article {
                float:left;
                margin:0 .5%;
                width:30%;
            }
                h2 { margin-top:0; }
                figure~h2 { margin-top:0.83em; }
                figure {
                    display:block;
                    margin:0;
                    padding:0;
                }
                    img { width:100%; }
            -->
        </style>
    </head>

    <body>
        <h1>Articles aléatoires | Les tableaux - Mise en pratique</h1>
        <p>Dans cet exercice, nous souhaitons mettre en place un affichage de 3 articles aléatoires parmi 5. Nous allons donc devoir :</p>
        <ul>
            <li>créer une structure en PHP capable de stocker 5 articles, chaque article devant être composé :
                <ul>
                    <li>d'un titre</li>
                    <li>d'un texte</li>
                    <li>d'une adresse vers une image</li>
                </ul>
            </li>
            <li>déterminer aléatoirement 3 articles à afficher parmi les 5 stockés</li>
            <li>afficher chacun de ces articles selon une structure HTML différente :
                <ol>
                    <li>titre dans une balise h2, suivi de texte dans une balise p, suivi de image dans une balise img</li>
                    <li>titre dans une balise h2, suivi de image dans une balise img, suivi de texte dans une balise p</li>
                    <li>image dans une balise img, suivi de titre dans une balise h2, suivi de texte dans une balise p</li>
                </ol>
            </li>
        </ul>
        <hr />
        <?php
        /**
         * On définit un tableau d'articles
        **/
        $_arr_articles = array(
            array( 'titre'=>'Titre 1', 'texte'=>'Texte 1', 'image'=>'assets/images/img.jpg' ), /* Ligne représentant un article (automatiquement stocké à la clé 0) */
            array( 'titre'=>'Titre 2', 'texte'=>'Texte 2', 'image'=>'assets/images/objectif_3w_logo.png' ), /* Ligne représentant un article (automatiquement stocké à la clé 1) */
            array( 'titre'=>'Titre 3', 'texte'=>'Texte 3', 'image'=>'assets/images/picto_O3W.jpg' ), /* Ligne représentant un article (automatiquement stocké à la clé 2) */
            array( 'titre'=>'Titre 4', 'texte'=>'Texte 4', 'image'=>'assets/images/region.jpg' ), /* Ligne représentant un article (automatiquement stocké à la clé 3) */
            array( 'titre'=>'Titre 5', 'texte'=>'Texte 5', 'image'=>'assets/images/volutes.png' ) /* Ligne représentant un article (automatiquement stocké à la clé 4) */
        );

        shuffle( $_arr_articles ); // On tri de manière aléatoire les articles dans le tableau (http://php.net/manual/fr/function.shuffle.php)

        /**
         * Comme les articles sont maintenant mélangés dans le tableau, les 3 premiers articles seront toujours différents.
         * Nous pouvons donc afficher tout le temps les 3 premiers les uns après les autres.
        **/
        ?>
        <article>
            <h2><?php echo $_arr_articles[0]['titre']; // On affiche le titre du premier article. ?></h2>
            <p><?php echo $_arr_articles[0]['texte']; // On affiche le texte du premier article. ?></p>
            <figure><img alt="" src="<?php echo $_arr_articles[0]['image']; // On affiche l'image' du premier article. ?>" /></figure>
        </article>

        <article>
            <h2><?php echo $_arr_articles[1]['titre']; // On affiche le titre du deuxième article. ?></h2>
            <figure><img alt="" src="<?php echo $_arr_articles[1]['image']; // On affiche l'image' du deuxième article. ?>" /></figure>
            <p><?php echo $_arr_articles[1]['texte']; // On affiche le texte du deuxième article. ?></p>
        </article>

        <article>
            <figure><img alt="" src="<?php echo $_arr_articles[2]['image']; // On affiche l'image' du troisième article. ?>" /></figure>
            <h2><?php echo $_arr_articles[2]['titre']; // On affiche le titre du troisième article. ?></h2>
            <p><?php echo $_arr_articles[2]['texte']; // On affiche le texte du troisième article. ?></p>
        </article>
        <br style="clear:both;" />
        <pre><code class="css">
article {
    float:left;
    margin:0 .5%;
    width:30%;
}
    h2 { margin-top:0; }
    figure~h2 { margin-top:0.83em; }
    figure {
        display:block;
        margin:0;
        padding:0;
    }
        img { width:100%; }</code>
        <code class="php">
&lt;?php
/**
 * On définit un tableau d'articles
**/
$_arr_articles = array(
    array( 'titre'=&gt;'Titre 1', 'texte'=&gt;'Texte 1', 'image'=&gt;'assets/images/img.jpg' ), /* Ligne représentant un article (automatiquement stocké à la clé 0) */
    array( 'titre'=&gt;'Titre 2', 'texte'=&gt;'Texte 2', 'image'=&gt;'assets/images/objectif_3w_logo.png' ), /* Ligne représentant un article (automatiquement stocké à la clé 1) */
    array( 'titre'=&gt;'Titre 3', 'texte'=&gt;'Texte 3', 'image'=&gt;'assets/images/picto_O3W.jpg' ), /* Ligne représentant un article (automatiquement stocké à la clé 2) */
    array( 'titre'=&gt;'Titre 4', 'texte'=&gt;'Texte 4', 'image'=&gt;'assets/images/region.jpg' ), /* Ligne représentant un article (automatiquement stocké à la clé 3) */
    array( 'titre'=&gt;'Titre 5', 'texte'=&gt;'Texte 5', 'image'=&gt;'assets/images/volutes.png' ) /* Ligne représentant un article (automatiquement stocké à la clé 4) */
);

shuffle( $_arr_articles ); // On tri de manière aléatoire les articles dans le tableau (http://php.net/manual/fr/function.shuffle.php)

/**
 * Comme les articles sont maintenant mélangés dans le tableau, les 3 premiers articles seront toujours différents.
 * Nous pouvons donc afficher tout le temps les 3 premiers les uns après les autres.
**/
?&gt;
&lt;article&gt;
    &lt;h2&gt;&lt;?php echo $_arr_articles[0]['titre']; // On affiche le titre du premier article. ?&gt;&lt;/h2&gt;
    &lt;p&gt;&lt;?php echo $_arr_articles[0]['texte']; // On affiche le texte du premier article. ?&gt;&lt;/p&gt;
    &lt;figure&gt;&lt;img alt="" src="&lt;?php echo $_arr_articles[0]['image']; // On affiche l'image' du premier article. ?&gt;" /&gt;&lt;/figure&gt;
&lt;/article&gt;

&lt;article&gt;
    &lt;h2&gt;&lt;?php echo $_arr_articles[1]['titre']; // On affiche le titre du deuxième article. ?&gt;&lt;/h2&gt;
    &lt;figure&gt;&lt;img alt="" src="&lt;?php echo $_arr_articles[1]['image']; // On affiche l'image' du deuxième article. ?&gt;" /&gt;&lt;/figure&gt;
    &lt;p&gt;&lt;?php echo $_arr_articles[1]['texte']; // On affiche le texte du deuxième article. ?&gt;&lt;/p&gt;
&lt;/article&gt;

&lt;article&gt;
    &lt;figure&gt;&lt;img alt="" src="&lt;?php echo $_arr_articles[2]['image']; // On affiche l'image' du troisième article. ?&gt;" /&gt;&lt;/figure&gt;
    &lt;h2&gt;&lt;?php echo $_arr_articles[2]['titre']; // On affiche le titre du troisième article. ?&gt;&lt;/h2&gt;
    &lt;p&gt;&lt;?php echo $_arr_articles[2]['texte']; // On affiche le texte du troisième article. ?&gt;&lt;/p&gt;
&lt;/article&gt;</code></pre>
        <hr />
        <h2>Un peu plus loin dans l'aléatoire</h2>
        <p>Nous allons faire le même exercice mais cette fois-ci, l'ordre d'affichage des éléments HTML sera lui aussi aléatoire.</p>
        <?php
        /**
         * ashuffle - Mélange les clés d'un tableau et conserve l'association des index
         * @param   array $arr
         * @return  array
        **/
        function ashuffle( $arr ) {
            $_arr_random = array(); // On définit un tableau vide.
            
            $_arr_keys = array_keys( $arr ); // On affecte à la variable _arr_keys toutes les clés du tableau passé en paramètre. La variable _arr_keys devient donc un tableau. (http://php.net/manual/fr/function.array-keys.php).
            shuffle( $_arr_keys ); // On tri de manière aléatoire les valeurs dans le tableau (http://php.net/manual/fr/function.shuffle.php).
            
            foreach( $_arr_keys as $value ) : // Pour chaque ligne d'enregistrement dans le tableau _arr_keys,
                $_arr_random[$value] = $arr[$value]; // On recompose un tableau en utilisant les clés mélangées et en leur affectant les valeurs correspondantes dans le tableau d'origine.
            endforeach;

            return $_arr_random; // On retourne le tableau mélangé.
        }

        /**
         * On définit un tableau d'articles
        **/
        $_arr_articles = array(
            array( 'titre'=>'Titre 1', 'texte'=>'Texte 1', 'image'=>'assets/images/img.jpg' ), /* Ligne représentant un article (automatiquement stocké à la clé 0) */
            array( 'titre'=>'Titre 2', 'texte'=>'Texte 2', 'image'=>'assets/images/objectif_3w_logo.png' ), /* Ligne représentant un article (automatiquement stocké à la clé 1) */
            array( 'titre'=>'Titre 3', 'texte'=>'Texte 3', 'image'=>'assets/images/picto_O3W.jpg' ), /* Ligne représentant un article (automatiquement stocké à la clé 2) */
            array( 'titre'=>'Titre 4', 'texte'=>'Texte 4', 'image'=>'assets/images/region.jpg' ), /* Ligne représentant un article (automatiquement stocké à la clé 3) */
            array( 'titre'=>'Titre 5', 'texte'=>'Texte 5', 'image'=>'assets/images/volutes.png' ) /* Ligne représentant un article (automatiquement stocké à la clé 4) */
        );

        $_int_limite = 3; // On définit une limite pour le nombre d'articles à afficher.

        for( $i=0; $i<$_int_limite; $i++ ) : // On répète les opérations suivantes autant de fois que nous l'indique la varibale limite
            /**
             * On définit un nombre aléatoire parmi toutes les clés du tableau _arr_articles; soit un nombre compris entre 0 et le nombre d'articles stockés dans le tableau _arr_articles moins 1 car on commence à la clé 0.
             *      rand(0,count($_arr_articles)-1) retourne donc un nombre aléatoire entre 0 et 4
             * Cette valeur aléatoire nous permet donc d'accéder aléatoirement à un article dans le tableau _arr_articles car chacun d'eux possède une clé numérique.
             *      $_arr_articles[rand(0,count($_arr_articles)-1)] correspond donc à un article aléatoirement pris dans le tableau
             * On passe l'article aléatoire en paramètre de la fonction ashuffle.
             *      Si on imagine que la valeur aléatoire est 3 :
             *          La fonction ashuffle reçoit donc un tableau structuré de cette manière : array( 'titre'=>'Titre 3', 'texte'=>'Texte 3', 'image'=>'assets/images/picto_O3W.jpg' ).
             *          La fonction array_keys retourne donc le tableau suivant : array( 0=>'titre', 1=>'texte', 2=>'image' ).
             *          La fonction shuffle peut donc retourner un résultat tel que : array( 0=>'image', 1=>'titre', 2=>'texte' ). Nous pouvons utliser shuffle car là nous n'avons pas besoin de conserver l'association clé/valeur dans ce tableau.
             *          Pour chaque ligne de ce tableau trié aléatoirement,
             *              Nous utilisons le tableau tampon _arr_random qui était vide jusque là.
             *              Nous créons une clé dans ce tableau qui correspond à la valeur du tableau _arr_keys actuellement pointée par le foreach.
             *              Dans notre exemple, cette première valeur est donc 'image'.
             *              Nous venons donc de créer une clé 'image' dans le tableau _arr_random.
             *              Nous associons à cette clé la valeur contenue à la même clé dans le tableau d'origine passé en paramètre de la fonction ashuffle; soit le tableau contenant les données de l'article.
             *              Dans notre exemple, cette valeur est donc 'assets/images/picto_O3W.jpg'.
             *              Nous venons donc de créer une première ligne ayant l'association clé/valeur 'image'=>'assets/images/picto_O3W.jpg'.
             *              Puis nous faisons ensuite cela avec les autres lignes.
             *          La fonction ashuffle nous retourne donc dans ce cas le tableau array('image'=>'assets/images/picto_O3W.jpg', 'titre'=>'Titre 3', 'texte'=>'Texte 3').
             * On affecte à la variable _arr_article le retour de la fonction ashuffle
            **/
            $_arr_article = ashuffle( $_arr_articles[rand(0,count($_arr_articles)-1)] );

            echo '<article>';
            /**
             * Comme le tableau _arr_article a été mélangé par la fonction ashuffle, l'ordre des éléments composant l'article est aléatoire.
             * Nous ne pouvons donc pas savoir dans quel ordre afficher les balises html.
             * En revanche, nous pouvons parcourir le tableau représentant l'article et afficher la balise en fonction de la clé que nous rencontrons.
            **/
            foreach( $_arr_article as $key => $value ) : // Pour chaque ligne du tableau _arr_article, on affecte à la variable key la clé en cours de lecture et à la variable value la valeur en cours de lecture,
                switch( $key ) : // En fonction de la clé en cours,
                    case 'titre': // Si cette clé est 'titre',
                        echo '<h2>' . $value . '</h2>'; // On affiche la balise h2 avec la valeur en cours (soit la valeur contenue à la clé 'titre' dans le tableau _arr_article : $_arr_article['titre']).
                        break;
                    case 'texte': // Si cette clé est 'texte',
                        echo '<p>' . $value . '</p>'; // On affiche la balise p avec la valeur en cours (soit la valeur contenue à la clé 'texte' dans le tableau _arr_article : $_arr_article['texte']).
                        break;
                    case 'image': // Si cette clé est 'image',
                        echo '<figure><img alt="" src="' . $value . '" /></figure>'; // On affiche la balise img avec la valeur en cours (soit la valeur contenue à la clé 'image' dans le tableau _arr_article : $_arr_article['image']).
                        break;
                endswitch;
            endforeach;
            echo '</article>';
        endfor;
        ?>
        <br style="clear:both;" />
        <pre><code class="php">
&lt;?php
/**
 * ashuffle - Mélange les clés d'un tableau et conserve l'association des index
 * @param   array $arr
 * @return  array
**/
function ashuffle( $arr ) {
    $_arr_random = array(); // On définit un tableau vide.
    
    $_arr_keys = array_keys( $arr ); // On affecte à la variable _arr_keys toutes les clés du tableau passé en paramètre. La variable _arr_keys devient donc un tableau. (http://php.net/manual/fr/function.array-keys.php).
    shuffle( $_arr_keys ); // On tri de manière aléatoire les valeurs dans le tableau (http://php.net/manual/fr/function.shuffle.php).
    
    foreach( $_arr_keys as $value ) : // Pour chaque ligne d'enregistrement dans le tableau _arr_keys,
        $_arr_random[$value] = $arr[$value]; // On recompose un tableau en utilisant les clés mélangées et en leur affectant les valeurs correspondantes dans le tableau d'origine.
    endforeach;

    return $_arr_random; // On retourne le tableau mélangé.
}

/**
 * On définit un tableau d'articles
**/
$_arr_articles = array(
    array( 'titre'=&gt;'Titre 1', 'texte'=&gt;'Texte 1', 'image'=&gt;'assets/images/img.jpg' ), /* Ligne représentant un article (automatiquement stocké à la clé 0) */
    array( 'titre'=&gt;'Titre 2', 'texte'=&gt;'Texte 2', 'image'=&gt;'assets/images/objectif_3w_logo.png' ), /* Ligne représentant un article (automatiquement stocké à la clé 1) */
    array( 'titre'=&gt;'Titre 3', 'texte'=&gt;'Texte 3', 'image'=&gt;'assets/images/picto_O3W.jpg' ), /* Ligne représentant un article (automatiquement stocké à la clé 2) */
    array( 'titre'=&gt;'Titre 4', 'texte'=&gt;'Texte 4', 'image'=&gt;'assets/images/region.jpg' ), /* Ligne représentant un article (automatiquement stocké à la clé 3) */
    array( 'titre'=&gt;'Titre 5', 'texte'=&gt;'Texte 5', 'image'=&gt;'assets/images/volutes.png' ) /* Ligne représentant un article (automatiquement stocké à la clé 4) */
);

$_int_limite = 3; // On définit une limite pour le nombre d'articles à afficher.

for( $i=0; $i&lt;$_int_limite; $i++ ) : // On répète les opérations suivantes autant de fois que nous l'indique la varibale limite
    /**
     * On définit un nombre aléatoire parmi toutes les clés du tableau _arr_articles; soit un nombre compris entre 0 et le nombre d'articles stockés dans le tableau _arr_articles moins 1 car on commence à la clé 0.
     *      rand(0,count($_arr_articles)-1) retourne donc un nombre aléatoire entre 0 et 4
     * Cette valeur aléatoire nous permet donc d'accéder aléatoirement à un article dans le tableau _arr_articles car chacun d'eux possède une clé numérique.
     *      $_arr_articles[rand(0,count($_arr_articles)-1)] correspond donc à un article aléatoirement pris dans le tableau
     * On passe l'article aléatoire en paramètre de la fonction ashuffle.
     *      Si on imagine que la valeur aléatoire est 3 :
     *          La fonction ashuffle reçoit donc un tableau structuré de cette manière : array( 'titre'=&gt;'Titre 3', 'texte'=&gt;'Texte 3', 'image'=&gt;'assets/images/picto_O3W.jpg' ).
     *          La fonction array_keys retourne donc le tableau suivant : array( 0=&gt;'titre', 1=&gt;'texte', 2=&gt;'image' ).
     *          La fonction shuffle peut donc retourner un résultat tel que : array( 0=&gt;'image', 1=&gt;'titre', 2=&gt;'texte' ). Nous pouvons utliser shuffle car là nous n'avons pas besoin de conserver l'association clé/valeur dans ce tableau.
     *          Pour chaque ligne de ce tableau trié aléatoirement,
     *              Nous utilisons le tableau tampon _arr_random qui était vide jusque là.
     *              Nous créons une clé dans ce tableau qui correspond à la valeur du tableau _arr_keys actuellement pointée par le foreach.
     *              Dans notre exemple, cette première valeur est donc 'image'.
     *              Nous venons donc de créer une clé 'image' dans le tableau _arr_random.
     *              Nous associons à cette clé la valeur contenue à la même clé dans le tableau d'origine passé en paramètre de la fonction ashuffle; soit le tableau contenant les données de l'article.
     *              Dans notre exemple, cette valeur est donc 'assets/images/picto_O3W.jpg'.
     *              Nous venons donc de créer une première ligne ayant l'association clé/valeur 'image'=&gt;'assets/images/picto_O3W.jpg'.
     *              Puis nous faisons ensuite cela avec les autres lignes.
     *          La fonction ashuffle nous retourne donc dans ce cas le tableau array('image'=&gt;'assets/images/picto_O3W.jpg', 'titre'=&gt;'Titre 3', 'texte'=&gt;'Texte 3').
     * On affecte à la variable _arr_article le retour de la fonction ashuffle
    **/
    $_arr_article = ashuffle( $_arr_articles[rand(0,count($_arr_articles)-1)] );

    echo '&lt;article&gt;';
    /**
     * Comme le tableau _arr_article a été mélangé par la fonction ashuffle, l'ordre des éléments composant l'article est aléatoire.
     * Nous ne pouvons donc pas savoir dans quel ordre afficher les balises html.
     * En revanche, nous pouvons parcourir le tableau représentant l'article et afficher la balise en fonction de la clé que nous rencontrons.
    **/
    foreach( $_arr_article as $key =&gt; $value ) : // Pour chaque ligne du tableau _arr_article, on affecte à la variable key la clé en cours de lecture et à la variable value la valeur en cours de lecture,
        switch( $key ) : // En fonction de la clé en cours,
            case 'titre': // Si cette clé est 'titre',
                echo '&lt;h2&gt;' . $value . '&lt;/h2&gt;'; // On affiche la balise h2 avec la valeur en cours (soit la valeur contenue à la clé 'titre' dans le tableau _arr_article : $_arr_article['titre']).
                break;
            case 'texte': // Si cette clé est 'texte',
                echo '&lt;p&gt;' . $value . '&lt;/p&gt;'; // On affiche la balise p avec la valeur en cours (soit la valeur contenue à la clé 'texte' dans le tableau _arr_article : $_arr_article['texte']).
                break;
            case 'image': // Si cette clé est 'image',
                echo '&lt;figure&gt;&lt;img alt="" src="' . $value . '" /&gt;&lt;/figure&gt;'; // On affiche la balise img avec la valeur en cours (soit la valeur contenue à la clé 'image' dans le tableau _arr_article : $_arr_article['image']).
                break;
        endswitch;
    endforeach;
    echo '&lt;/article&gt;';
endfor;
?&gt;</code></pre>
        <hr />
        <h2>De l'aléatoire ayant de la mémoire</h2>
        <p>Nous allons faire le même exercice mais cette fois-ci, nous ne voulons pas que le même article apparaisse plusieurs fois.</p>
        <?php
        /**
         * On définit un tableau d'articles
        **/
        $_arr_articles = array(
            array( 'titre'=>'Titre 1', 'texte'=>'Texte 1', 'image'=>'assets/images/img.jpg' ), /* Ligne représentant un article (automatiquement stocké à la clé 0) */
            array( 'titre'=>'Titre 2', 'texte'=>'Texte 2', 'image'=>'assets/images/objectif_3w_logo.png' ), /* Ligne représentant un article (automatiquement stocké à la clé 1) */
            array( 'titre'=>'Titre 3', 'texte'=>'Texte 3', 'image'=>'assets/images/picto_O3W.jpg' ), /* Ligne représentant un article (automatiquement stocké à la clé 2) */
            array( 'titre'=>'Titre 4', 'texte'=>'Texte 4', 'image'=>'assets/images/region.jpg' ), /* Ligne représentant un article (automatiquement stocké à la clé 3) */
            array( 'titre'=>'Titre 5', 'texte'=>'Texte 5', 'image'=>'assets/images/volutes.png' ) /* Ligne représentant un article (automatiquement stocké à la clé 4) */
        );

        $_int_limite = 3; // On définit une limite pour le nombre d'articles à afficher.
        $_arr_log = array(); // On crée un tableau vide qui nous servira à stocker les articles déjà affichés.

        for( $i=0; $i<$_int_limite; $i++ ) : // On répète les opérations suivantes autant de fois que nous l'indique la varibale limite
            do {
                /**
                 * On définit un nombre aléatoire parmi toutes les clés du tableau _arr_articles; soit un nombre compris entre 0 et le nombre d'articles stockés dans le tableau _arr_articles moins 1 car on commence à la clé 0.
                 *      rand(0,count($_arr_articles)-1) retourne donc un nombre aléatoire entre 0 et 4
                **/
                $_int_rand = rand(0,count($_arr_articles)-1);
            } while( in_array( $_int_rand, $_arr_log ) ); // On répète le bloc d'instructions tant que la clé choisie est présente dans le tableau des articles déjà affichés (http://php.net/manual/fr/function.in-array.php).

            /**
             * Cette valeur _int_rand nous permet donc d'accéder aléatoirement à un article dans le tableau _arr_articles car chacun d'eux possède une clé numérique.
             *      $_arr_articles[$_int_rand] correspond donc à un article aléatoirement pris dans le tableau
             * On passe l'article aléatoire en paramètre de la fonction ashuffle.
             *      Si on imagine que la valeur aléatoire est 3 :
             *          La fonction ashuffle reçoit donc un tableau structuré de cette manière : array( 'titre'=>'Titre 3', 'texte'=>'Texte 3', 'image'=>'assets/images/picto_O3W.jpg' ).
             *          La fonction array_keys retourne donc le tableau suivant : array( 0=>'titre', 1=>'texte', 2=>'image' ).
             *          La fonction shuffle peut donc retourner un résultat tel que : array( 0=>'image', 1=>'titre', 2=>'texte' ). Nous pouvons utliser shuffle car là nous n'avons pas besoin de conserver l'association clé/valeur dans ce tableau.
             *          Pour chaque ligne de ce tableau trié aléatoirement,
             *              Nous utilisons le tableau tampon _arr_random qui était vide jusque là.
             *              Nous créons une clé dans ce tableau qui correspond à la valeur du tableau _arr_keys actuellement pointée par le foreach.
             *              Dans notre exemple, cette première valeur est donc 'image'.
             *              Nous venons donc de créer une clé 'image' dans le tableau _arr_random.
             *              Nous associons à cette clé la valeur contenue à la même clé dans le tableau d'origine passé en paramètre de la fonction ashuffle; soit le tableau contenant les données de l'article.
             *              Dans notre exemple, cette valeur est donc 'assets/images/picto_O3W.jpg'.
             *              Nous venons donc de créer une première ligne ayant l'association clé/valeur 'image'=>'assets/images/picto_O3W.jpg'.
             *              Puis nous faisons ensuite cela avec les autres lignes.
             *          La fonction ashuffle nous retourne donc dans ce cas le tableau array('image'=>'assets/images/picto_O3W.jpg', 'titre'=>'Titre 3', 'texte'=>'Texte 3').
             * On affecte à la variable _arr_article le retour de la fonction ashuffle
            **/
            $_arr_article = ashuffle( $_arr_articles[$_int_rand] );

            echo '<article>';
            /**
             * Comme le tableau _arr_article a été mélangé par la fonction ashuffle, l'ordre des éléments composant l'article est aléatoire.
             * Nous ne pouvons donc pas savoir dans quel ordre afficher les balises html.
             * En revanche, nous pouvons parcourir le tableau représentant l'article et afficher la balise en fonction de la clé que nous rencontrons.
            **/
            foreach( $_arr_article as $key => $value ) : // Pour chaque ligne du tableau _arr_article, on affecte à la variable key la clé en cours de lecture et à la variable value la valeur en cours de lecture,
                switch( $key ) : // En fonction de la clé en cours,
                    case 'titre': // Si cette clé est 'titre',
                        echo '<h2>' . $value . '</h2>'; // On affiche la balise h2 avec la valeur en cours (soit la valeur contenue à la clé 'titre' dans le tableau _arr_article : $_arr_article['titre']).
                        break;
                    case 'texte': // Si cette clé est 'texte',
                        echo '<p>' . $value . '</p>'; // On affiche la balise p avec la valeur en cours (soit la valeur contenue à la clé 'texte' dans le tableau _arr_article : $_arr_article['texte']).
                        break;
                    case 'image': // Si cette clé est 'image',
                        echo '<figure><img alt="" src="' . $value . '" /></figure>'; // On affiche la balise img avec la valeur en cours (soit la valeur contenue à la clé 'image' dans le tableau _arr_article : $_arr_article['image']).
                        break;
                endswitch;
            endforeach;
            echo '</article>';

            $_arr_log[] = $_int_rand; // On stocke la clé dans le tableau des articles déjà affichés. Cela nous permettra à la prochaine boucle de ne pas ressortir une clé déjà utilisée.
        endfor;
        ?>
        <br style="clear:both;" />
        <pre><code class="php">
&lt;?php
/**
 * ashuffle - Mélange les clés d'un tableau et conserve l'association des index
 * @param   array $arr
 * @return  array
**/
function ashuffle( $arr ) {
    $_arr_random = array(); // On définit un tableau vide.
    
    $_arr_keys = array_keys( $arr ); // On affecte à la variable _arr_keys toutes les clés du tableau passé en paramètre. La variable _arr_keys devient donc un tableau. (http://php.net/manual/fr/function.array-keys.php).
    shuffle( $_arr_keys ); // On tri de manière aléatoire les valeurs dans le tableau (http://php.net/manual/fr/function.shuffle.php).
    
    foreach( $_arr_keys as $value ) : // Pour chaque ligne d'enregistrement dans le tableau _arr_keys,
        $_arr_random[$value] = $arr[$value]; // On recompose un tableau en utilisant les clés mélangées et en leur affectant les valeurs correspondantes dans le tableau d'origine.
    endforeach;

    return $_arr_random; // On retourne le tableau mélangé.
}

/**
 * On définit un tableau d'articles
**/
$_arr_articles = array(
    array( 'titre'=&gt;'Titre 1', 'texte'=&gt;'Texte 1', 'image'=&gt;'assets/images/img.jpg' ), /* Ligne représentant un article (automatiquement stocké à la clé 0) */
    array( 'titre'=&gt;'Titre 2', 'texte'=&gt;'Texte 2', 'image'=&gt;'assets/images/objectif_3w_logo.png' ), /* Ligne représentant un article (automatiquement stocké à la clé 1) */
    array( 'titre'=&gt;'Titre 3', 'texte'=&gt;'Texte 3', 'image'=&gt;'assets/images/picto_O3W.jpg' ), /* Ligne représentant un article (automatiquement stocké à la clé 2) */
    array( 'titre'=&gt;'Titre 4', 'texte'=&gt;'Texte 4', 'image'=&gt;'assets/images/region.jpg' ), /* Ligne représentant un article (automatiquement stocké à la clé 3) */
    array( 'titre'=&gt;'Titre 5', 'texte'=&gt;'Texte 5', 'image'=&gt;'assets/images/volutes.png' ) /* Ligne représentant un article (automatiquement stocké à la clé 4) */
);

$_int_limite = 3; // On définit une limite pour le nombre d'articles à afficher.
$_arr_log = array(); // On crée un tableau vide qui nous servira à stocker les articles déjà affichés.

for( $i=0; $i&lt;$_int_limite; $i++ ) : // On répète les opérations suivantes autant de fois que nous l'indique la varibale limite
    do {
        /**
         * On définit un nombre aléatoire parmi toutes les clés du tableau _arr_articles; soit un nombre compris entre 0 et le nombre d'articles stockés dans le tableau _arr_articles moins 1 car on commence à la clé 0.
         *      rand(0,count($_arr_articles)-1) retourne donc un nombre aléatoire entre 0 et 4
        **/
        $_int_rand = rand(0,count($_arr_articles)-1);
    } while( in_array( $_int_rand, $_arr_log ) ); // On répète le bloc d'instructions tant que la clé choisie est présente dans le tableau des articles déjà affichés (http://php.net/manual/fr/function.in-array.php).

    /**
     * Cette valeur _int_rand nous permet donc d'accéder aléatoirement à un article dans le tableau _arr_articles car chacun d'eux possède une clé numérique.
     *      $_arr_articles[$_int_rand] correspond donc à un article aléatoirement pris dans le tableau
     * On passe l'article aléatoire en paramètre de la fonction ashuffle.
     *      Si on imagine que la valeur aléatoire est 3 :
     *          La fonction ashuffle reçoit donc un tableau structuré de cette manière : array( 'titre'=&gt;'Titre 3', 'texte'=&gt;'Texte 3', 'image'=&gt;'assets/images/picto_O3W.jpg' ).
     *          La fonction array_keys retourne donc le tableau suivant : array( 0=&gt;'titre', 1=&gt;'texte', 2=&gt;'image' ).
     *          La fonction shuffle peut donc retourner un résultat tel que : array( 0=&gt;'image', 1=&gt;'titre', 2=&gt;'texte' ). Nous pouvons utliser shuffle car là nous n'avons pas besoin de conserver l'association clé/valeur dans ce tableau.
     *          Pour chaque ligne de ce tableau trié aléatoirement,
     *              Nous utilisons le tableau tampon _arr_random qui était vide jusque là.
     *              Nous créons une clé dans ce tableau qui correspond à la valeur du tableau _arr_keys actuellement pointée par le foreach.
     *              Dans notre exemple, cette première valeur est donc 'image'.
     *              Nous venons donc de créer une clé 'image' dans le tableau _arr_random.
     *              Nous associons à cette clé la valeur contenue à la même clé dans le tableau d'origine passé en paramètre de la fonction ashuffle; soit le tableau contenant les données de l'article.
     *              Dans notre exemple, cette valeur est donc 'assets/images/picto_O3W.jpg'.
     *              Nous venons donc de créer une première ligne ayant l'association clé/valeur 'image'=&gt;'assets/images/picto_O3W.jpg'.
     *              Puis nous faisons ensuite cela avec les autres lignes.
     *          La fonction ashuffle nous retourne donc dans ce cas le tableau array('image'=&gt;'assets/images/picto_O3W.jpg', 'titre'=&gt;'Titre 3', 'texte'=&gt;'Texte 3').
     * On affecte à la variable _arr_article le retour de la fonction ashuffle
    **/
    $_arr_article = ashuffle( $_arr_articles[$_int_rand] );

    echo '&lt;article&gt;';
    /**
     * Comme le tableau _arr_article a été mélangé par la fonction ashuffle, l'ordre des éléments composant l'article est aléatoire.
     * Nous ne pouvons donc pas savoir dans quel ordre afficher les balises html.
     * En revanche, nous pouvons parcourir le tableau représentant l'article et afficher la balise en fonction de la clé que nous rencontrons.
    **/
    foreach( $_arr_article as $key =&gt; $value ) : // Pour chaque ligne du tableau _arr_article, on affecte à la variable key la clé en cours de lecture et à la variable value la valeur en cours de lecture,
        switch( $key ) : // En fonction de la clé en cours,
            case 'titre': // Si cette clé est 'titre',
                echo '&lt;h2&gt;' . $value . '&lt;/h2&gt;'; // On affiche la balise h2 avec la valeur en cours (soit la valeur contenue à la clé 'titre' dans le tableau _arr_article : $_arr_article['titre']).
                break;
            case 'texte': // Si cette clé est 'texte',
                echo '&lt;p&gt;' . $value . '&lt;/p&gt;'; // On affiche la balise p avec la valeur en cours (soit la valeur contenue à la clé 'texte' dans le tableau _arr_article : $_arr_article['texte']).
                break;
            case 'image': // Si cette clé est 'image',
                echo '&lt;figure&gt;&lt;img alt="" src="' . $value . '" /&gt;&lt;/figure&gt;'; // On affiche la balise img avec la valeur en cours (soit la valeur contenue à la clé 'image' dans le tableau _arr_article : $_arr_article['image']).
                break;
        endswitch;
    endforeach;
    echo '&lt;/article&gt;';

    $_arr_log[] = $_int_rand; // On stocke la clé dans le tableau des articles déjà affichés. Cela nous permettra à la prochaine boucle de ne pas ressortir une clé déjà utilisée.
endfor;
?&gt;</code></pre>
    </body>
</html>