<?php
session_start(); // On autorise la page à accéder à la superglobale de session (http://php.net/manual/fr/function.session-start.php).

if( isset( $_GET ) && array_key_exists( 'destroy', $_GET ) ) : // Si la clé "destroy" est passée en paramètre dans l'URL,
    unset( $_SESSION['shoppingList'] ); // On détruit la session pour vider l'historique (http://php.net/manual/fr/function.unset.php).
    $page = $_SERVER['PHP_SELF']; // On utilise la superglobale "$_SERVER" pour récupérer le nom de la page en cours d'utilisation (http://php.net/manual/fr/reserved.variables.server.php).
    header( 'Location:' . $page ); // On utilise la fonction "header" pour rediriger vers une autre page (http://php.net/manual/fr/function.header.php).
endif;

/**
 * addToCart - Ajoute un élément à la liste
 * @param   string  $article
 * @param   int     $quantity
 * @param   array   $cart
 * @return  mixed (string/false)
**/
function addToCart( $article, $quantity, &$cart ) {
    if( isset( $cart[$article] ) ) : // Si l'article existe déjà,
        $cart[$article] += $quantity; // On ajoute la quantité dans le produit existant.
        if( $cart[$article] < 1 ) : // Si la quantité est négative,
            unset( $cart[$article] ); // On supprime l'article de la liste.
            return '<div class="block ok">L\'article <strong><em>' . $article . '</em></strong> a bien été supprimé !</div>'; // On affiche un message.
        endif;

        return '<div class="block ok">L\'article <strong><em>' . $article . '</em></strong> a bien été modifié !</div>'; // On affiche un message.
    else : // Sinon,
        $cart[$article] = $quantity; // On stocke dans la liste de courses.
        return '<div class="block ok">L\'article <strong><em>' . $article . '</em></strong> a bien été ajouté !</div>'; // On affiche un message.
    endif;

    return false;
}


/**
 * deleteFromCart - Supprime un(ou plusieurs) élément(s) de la liste
 * @param   array   $article
 * @param   array   $cart
 * @return  mixed (string/false)
**/
function deleteFromCart( $article, &$cart ) {
    $confirmation = '';

    if( is_array( $article ) && count( $article )>1 ) : // Si on soumet un tableau d'articles,
        $confirmation .= '<div class="block ok">Les articles <ul>'; // On affiche un message.
        foreach( $article as $value ) : // Pour chaque article,
            if( isset( $cart[$value] ) ) :
                unset( $cart[$value] ); // On supprime l'article de la liste.
                $confirmation .= '<li><strong><em>' . $value . '</em></strong></li>'; // On affiche un message.
            endif;
        endforeach;
        $confirmation .= '</ul> ont bien été supprimés !</div>'; // On affiche un message.

        return $confirmation;
    else : // Sinon,
        if( isset( $cart[$article[0]] ) ) :
            unset( $cart[$article[0]] ); // On supprime l'article de la liste.

            return '<div class="block ok">L\'article <strong><em>' . $article[0] . '</em></strong> a bien été supprimé !</div>'; // On affiche un message.
        endif;
    endif;

    return false;
}
?><!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0" />
        <title>Liste de courses | Les sessions - Mise en pratique</title>

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
            /**
             * --------------------------------------------------
             * GENERALS
             * --------------------------------------------------
            **/
            body { font-family:Tahoma, Geneva, sans-serif; }
                ol > li { padding-bottom:10px;  }
                table { display:table; }
            /**
             * --------------------------------------------------
             * CLASSES
             * --------------------------------------------------
            **/
            /* BLOCKS */
            .block.ok {
                background-color:#34C924; /* vert pomme */
                color:#ffffff; /* blanc */
            }
            .block.error {
                background-color:#ff0000; /* rouge */
                color:#ffffff; /* blanc */
            }
            .block.error::before { content:'/!\\ '; }
                .block.error a { color:#ffffff; /* blanc */ }

            .list {
                border:#000000 thin solid;
                border-collapse:collapse;
                margin:10px 0;
                table-layout:fixed;
                text-align:center;
                width:600px;
            }
                    .list th, td {
                        border:#000000 thin solid;
                        padding:4px 7px;
                        text-align:left;
                    }
                    .list th {
                        background-color:#999999;
                        color:#FFFFFF;
                        font-weight:normal;
                    }
                .list thead th {
                    background-color:#515151;
                    color:#DEDEDE;
                    font-weight:bold;
                    text-align:center;
                }

            /**
             * --------------------------------------------------
             * TAGS
             * --------------------------------------------------
            **/
            input[type="color"],input[type="date"],input[type="datetime"],input[type="datetime-local"],input[type="email"],input[type="month"],input[type="number"],input[type="range"],input[type="search"],input[type="tel"],input[type="time"],input[type="url"],input[type="week"],input::-webkit-input-placeholder { -webkit-appearance:none; }
            input[type="search"]::-webkit-search-cancel-button,input[type="search"]::-webkit-search-decoration,input[type="search"]::-webkit-search-results-button,input[type="search"]::-webkit-search-results-decoration { -webkit-appearance:none; }
            /**
             * --------------------------------------------------
             * COMPONENTS
             * --------------------------------------------------
            **/
            /* FORMS */
            [data-role="form"] {
                margin:0;
                padding:0;
                position:relative;
                text-align:left;
            }
                [data-role="form"] input:not([type="checkbox"]):not([type="radio"]):not([type="file"]):not([type="submit"]):not([type="button"]),[data-role="form"] textarea,[data-role="form"] select {
                    background-color:rgba(255,255,255,.3);
                    border:rgba(21,21,21,.3) thin solid;
                    display:block;
                    line-height:normal;
                    padding:4px 7px;padding:.4rem .7rem;
                    position:relative;
                    vertical-align:middle;
                    width:100%;

                    /* transition */
                    -webkit-transition-duration:.2s;
                    -moz-transition-duration:.2s;
                    -ms-transition-duration:.2s;
                    -o-transition-duration:.2s;
                    transition-duration:.2s;
                    -webkit-transition-timing-function:ease-in-out;
                    -moz-transition-timing-function:ease-in-out;
                    -ms-transition-timing-function:ease-in-out;
                    -o-transition-timing-function:ease-in-out;
                    transition-timing-function:ease-in-out;
                }
                [data-role="form"] input:not([type="checkbox"]):not([type="radio"]):not([type="file"]):not([type="submit"]):not([type="button"]):focus,[data-role="form"] input:not([type="checkbox"]):not([type="radio"]):not([type="file"]):not([type="submit"]):not([type="button"]):active,[data-role="form"] input:not([type="checkbox"]):not([type="radio"]):not([type="file"]):not([type="submit"]):not([type="button"]).selected,[data-role="form"] textarea:focus,[data-role="form"] textarea:active,[data-role="form"] textarea.selected,[data-role="form"] select:focus,[data-role="form"] select:active,[data-role="form"] select.selected { background-color:rgb(255,255,255); }
                
                [data-role="form"] [data-role="submit"] {
                    background-color:rgb(0,138,166);
                    border:none;
                    color:rgb(255,255,255);
                    cursor:pointer;
                    display:inline-block;
                    font-weight:700;
                    margin:5px 0;margin:.5rem 0;
                    padding:4px 7px;padding:.4rem .7rem;
                    position:relative;
                    text-align:center;
                    text-decoration:none;
                    
                    /* sélection */
                    -webkit-user-select:none;
                    -moz-user-select:none;
                    -ms-user-select:none;
                    -o-user-select:none;
                    user-select:none;
                    /* transition */
                    -webkit-transition-duration:.2s;
                    -moz-transition-duration:.2s;
                    -ms-transition-duration:.2s;
                    -o-transition-duration:.2s;
                    transition-duration:.2s;
                    -webkit-transition-timing-function:ease-in-out;
                    -moz-transition-timing-function:ease-in-out;
                    -ms-transition-timing-function:ease-in-out;
                    -o-transition-timing-function:ease-in-out;
                    transition-timing-function:ease-in-out;
                }
                [data-role="form"] [data-role="submit"]:hover,[data-role="form"] [data-role="submit"]:focus,[data-role="form"] [data-role="submit"]:active { background-color:rgb(62,194,226); }

                [data-role="form"] .text-quote {}
            -->
        </style>
    </head>
    <body>
        <h1>Liste de courses | Les sessions - Mise en pratique</h1>
        <p><em>Pour cet exercice, nous allons gérer notre list de courses. Pour cela :</em></p>
        <ol style="font-style:italic;">
            <li>nous allons créer un formulaire avec 2 champs de saisie :
                <ul>
                    <li>un pour saisir le libellé de l’article,</li>
                    <li>un pour saisir la quantité.</li>
                </ul>
            </li>
            <li>nous allons stocker tous les articles et les quantités associées.</li>
            <li>nous allons faire afficher un tableau HTML récapitulatif au format :<br />
                <table class="list">
                    <thead>
                        <tr>
                            <th colspan="2">LISTE DES COURSES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>Articles</th>
                            <th>Quantité</th>
                        </tr>
                        <tr>
                            <td>Pommes</td>
                            <td>4</td>
                        </tr>
                        <tr>
                            <td>Poires</td>
                            <td>2</td>
                        </tr>
                        <tr>
                            <td>Scoubidous</td>
                            <td>10</td>
                        </tr>
                    </tbody>
                </table>
            </li>
            <li>nous allons modifier ce tableau HTML pour l’inclure dans un formaulaire, ajouter une case à cocher pour chaque article et un bouton "Supprimer" :<br />
                <table class="list">
                    <thead>
                        <tr>
                            <th colspan="3">LISTE DES COURSES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>Articles</th>
                            <th>Quantité</th>
                            <th>Supprimer</th>
                        </tr>
                        <tr>
                            <td>Pommes</td>
                            <td>4</td>
                            <td><input disabled type="checkbox" /></td>
                        </tr>
                        <tr>
                            <td>Poires</td>
                            <td>2</td>
                            <td><input checked disabled type="checkbox" /></td>
                        </tr>
                        <tr>
                            <td>Scoubidous</td>
                            <td>10</td>
                            <td><input disabled type="checkbox" /></td>
                        </tr>
                    </tbody>
                </table>
            </li>
            <li>À la soumission du formulaire, pour chaque article coché, nous allons le supprimer de notre stockage (la procédure "unset" nous permet de supprimer un enregistrement dans un tableau, nous l’avons même déjà utilisée pour supprimer une session que nous avions créer dans le tableau de session).<br />Il faudra donc que la list s’affiche sans les articles supprimés.</li>
        </ol>

        <hr />
        <h2>Ma liste de courses</h2>

        <form action="" data-role="form" method="POST">
            <label for="txt-article">Article : </label>
            <input id="txt-article" name="article" placeholder="Saisir un article (ex. : Pommes, poires, scoubidous, ...)" type="text" />
            <label for="txt-quantity">Quantité : </label>
            <input id="txt-quantity" name="quantity" placeholder="Saisir un nombre" type="number" />

            <input data-role="submit" type="submit" value="Ajouter à la liste" />
        </form>

        <?php
        if( isset( $_POST['article'] ) && isset( $_POST['quantity'] ) ) : // Si on soumet un article et une quantité,
            if( $_POST['article']!='' && is_numeric( $_POST['quantity'] ) ) : // Si les valeurs soumises correspondent aux formats attendus,
                if( ( $message = addToCart( $_POST['article'], $_POST['quantity'], $_SESSION['shoppingList'] ) )!==false )
                    echo $message;
                else
                    echo '<div class="block error">Un problème s\'est produit pendant l\'ajout.</div>';
            else : // Sinon,
                echo '<div class="block error">Veuillez préciser un article et/ou une quantité valide !</div>'; // On affiche un message.
            endif;
        endif;

        if( isset( $_SESSION['shoppingList'] ) ) : // Si on a créé une liste.
            if( isset( $_POST['delete'] ) ) : // Si on a soumis des articles à la suppression,
                if( ( $message = deleteFromCart( $_POST['delete'], $_SESSION['shoppingList'] ) )!==false )
                    echo $message;
                else
                    echo '<div class="block error">Un problème s\'est produit pendant la suppression.</div>';
            endif;

            if( count( $_SESSION['shoppingList'] ) > 0 ) : // S'il reste des articles dans la liste,
            /**
             * On affiche le tableau récapitulatif
            **/
        ?>
        <form action="" data-role="form" method="POST">
            <table class="list">
                <thead>
                    <tr>
                        <th colspan="3">LISTE DES COURSES</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>Articles</th>
                        <th>Quantité</th>
                        <th>Supprimer</th>
                    </tr>
                    <?php foreach( $_SESSION['shoppingList'] as $article => $quantity ) : // Pour chaque article de la liste de course, ?>
                    <tr>
                        <td><?php echo $article; // La clé du tableau correspond au libellé de l'article. ?></td>
                        <td><?php echo $quantity; // La valeur contenue à cette même clé dans le tableau correspond à la quantité. ?></td>
                        <td><input id="chk-delete<?php echo ucfirst( $article ); ?>" name="delete[]" type="checkbox" value="<?php echo $article; // On lie la checkbox à la clé de l'article dans le tableau. ?>" /></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <input data-role="submit" type="submit" value="Supprimer les articles cochés de la liste" />
            <a data-role="submit" href="?destroy" title="">Vider la liste</a>
        </form>
        <?php
            endif;
        endif;
        ?>
        <pre><code class="php">
&lt;?php
session_start(); // On autorise la page à accéder à la superglobale de session (http://php.net/manual/fr/function.session-start.php).

if( isset( $_GET ) && array_key_exists( 'destroy', $_GET ) ) : // Si la clé "destroy" est passée en paramètre dans l'URL,
    unset( $_SESSION['shoppingList'] ); // On détruit la session pour vider l'historique (http://php.net/manual/fr/function.unset.php).
    $page = $_SERVER['PHP_SELF']; // On utilise la superglobale "$_SERVER" pour récupérer le nom de la page en cours d'utilisation (http://php.net/manual/fr/reserved.variables.server.php).
    header( 'Location:' . $page ); // On utilise la fonction "header" pour rediriger vers une autre page (http://php.net/manual/fr/function.header.php).
endif;

/**
 * addToCart - Ajoute un élément à la liste
 * @param   string  $article
 * @param   int     $quantity
 * @param   array   $cart
 * @return  mixed (string/false)
**/
function addToCart( $article, $quantity, &$cart ) {
    if( isset( $cart[$article] ) ) : // Si l'article existe déjà,
        $cart[$article] += $quantity; // On ajoute la quantité dans le produit existant.
        if( $cart[$article] &lt; 1 ) : // Si la quantité est négative,
            unset( $cart[$article] ); // On supprime l'article de la liste.
            return '&lt;div class="block ok"&gt;L\'article &lt;strong&gt;&lt;em&gt;' . $article . '&lt;/em&gt;&lt;/strong&gt; a bien été supprimé !&lt;/div&gt;'; // On affiche un message.
        endif;

        return '&lt;div class="block ok"&gt;L\'article &lt;strong&gt;&lt;em&gt;' . $article . '&lt;/em&gt;&lt;/strong&gt; a bien été modifié !&lt;/div&gt;'; // On affiche un message.
    else : // Sinon,
        $cart[$article] = $quantity; // On stocke dans la liste de courses.
        return '&lt;div class="block ok"&gt;L\'article &lt;strong&gt;&lt;em&gt;' . $article . '&lt;/em&gt;&lt;/strong&gt; a bien été ajouté !&lt;/div&gt;'; // On affiche un message.
    endif;

    return false;
}


/**
 * deleteFromCart - Supprime un(ou plusieurs) élément(s) de la liste
 * @param   array   $article
 * @param   array   $cart
 * @return  mixed (string/false)
**/
function deleteFromCart( $article, &$cart ) {
    $confirmation = '';

    if( is_array( $article ) && count( $article )&gt;1 ) : // Si on soumet un tableau d'articles,
        $confirmation .= '&lt;div class="block ok"&gt;Les articles &lt;ul&gt;'; // On affiche un message.
        foreach( $article as $value ) : // Pour chaque article,
            if( isset( $cart[$value] ) ) :
                unset( $cart[$value] ); // On supprime l'article de la liste.
                $confirmation .= '&lt;li&gt;&lt;strong&gt;&lt;em&gt;' . $value . '&lt;/em&gt;&lt;/strong&gt;&lt;/li&gt;'; // On affiche un message.
            endif;
        endforeach;
        $confirmation .= '&lt;/ul&gt; ont bien été supprimés !&lt;/div&gt;'; // On affiche un message.

        return $confirmation;
    else : // Sinon,
        if( isset( $cart[$article[0]] ) ) :
            unset( $cart[$article[0]] ); // On supprime l'article de la liste.

            return '&lt;div class="block ok"&gt;L\'article &lt;strong&gt;&lt;em&gt;' . $article[0] . '&lt;/em&gt;&lt;/strong&gt; a bien été supprimé !&lt;/div&gt;'; // On affiche un message.
        endif;
    endif;

    return false;
}</code>
<code class="html">
&lt;form action="" data-role="form" method="POST"&gt;
    &lt;label for="txt-article"&gt;Article : &lt;/label&gt;
    &lt;input id="txt-article" name="article" placeholder="Saisir un article (ex. : Pommes, poires, scoubidous, ...)" type="text" /&gt;
    &lt;label for="txt-quantity"&gt;Quantité : &lt;/label&gt;
    &lt;input id="txt-quantity" name="quantity" placeholder="Saisir un nombre" type="number" /&gt;

    &lt;input data-role="submit" type="submit" value="Ajouter à la liste" /&gt;
&lt;/form&gt;

&lt;?php
if( isset( $_POST['article'] ) && isset( $_POST['quantity'] ) ) : // Si on soumet un article et une quantité,
    if( $_POST['article']!='' && is_numeric( $_POST['quantity'] ) ) : // Si les valeurs soumises correspondent aux formats attendus,
        if( ( $message = addToCart( $_POST['article'], $_POST['quantity'], $_SESSION['shoppingList'] ) )!==false )
            echo $message;
        else
            echo '&lt;div class="block error"&gt;Un problème s\'est produit pendant l\'ajout.&lt;/div&gt;';
    else : // Sinon,
        echo '&lt;div class="block error"&gt;Veuillez préciser un article et/ou une quantité valide !&lt;/div&gt;'; // On affiche un message.
    endif;
endif;

if( isset( $_SESSION['shoppingList'] ) ) : // Si on a créé une liste.
    if( isset( $_POST['delete'] ) ) : // Si on a soumis des articles à la suppression,
        if( ( $message = deleteFromCart( $_POST['delete'], $_SESSION['shoppingList'] ) )!==false )
            echo $message;
        else
            echo '&lt;div class="block error"&gt;Un problème s\'est produit pendant la suppression.&lt;/div&gt;';
    endif;

    if( count( $_SESSION['shoppingList'] ) &gt; 0 ) : // S'il reste des articles dans la liste,
    /**
     * On affiche le tableau récapitulatif
    **/
?&gt;
&lt;form action="" data-role="form" method="POST"&gt;
    &lt;table class="list"&gt;
        &lt;thead&gt;
            &lt;tr&gt;
                &lt;th colspan="3"&gt;LISTE DES COURSES&lt;/th&gt;
            &lt;/tr&gt;
        &lt;/thead&gt;
        &lt;tbody&gt;
            &lt;tr&gt;
                &lt;th&gt;Articles&lt;/th&gt;
                &lt;th&gt;Quantité&lt;/th&gt;
                &lt;th&gt;Supprimer&lt;/th&gt;
            &lt;/tr&gt;
            &lt;?php foreach( $_SESSION['shoppingList'] as $article =&gt; $quantity ) : // Pour chaque article de la liste de course, ?&gt;
            &lt;tr&gt;
                &lt;td&gt;&lt;?php echo $article; // La clé du tableau correspond au libellé de l'article. ?&gt;&lt;/td&gt;
                &lt;td&gt;&lt;?php echo $quantity; // La valeur contenue à cette même clé dans le tableau correspond à la quantité. ?&gt;&lt;/td&gt;
                &lt;td&gt;&lt;input id="chk-delete&lt;?php echo ucfirst( $article ); ?&gt;" name="delete[]" type="checkbox" value="&lt;?php echo $article; // On lie la checkbox à la clé de l'article dans le tableau. ?&gt;" /&gt;&lt;/td&gt;
            &lt;/tr&gt;
            &lt;?php endforeach; ?&gt;
        &lt;/tbody&gt;
    &lt;/table&gt;
    &lt;input data-role="submit" type="submit" value="Supprimer les articles cochés de la liste" /&gt;
    &lt;a data-role="submit" href="?destroy" title=""&gt;Vider la liste&lt;/a&gt;
&lt;/form&gt;
&lt;?php
    endif;
endif;</code></pre>
    </body>
</html>