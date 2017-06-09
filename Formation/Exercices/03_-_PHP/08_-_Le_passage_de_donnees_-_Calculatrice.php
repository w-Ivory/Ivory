<?php
function calc( $tab ) {
    if( isset( $tab ) && count( $tab )>0 ) : // Si on a soumis des données via notre formulaire,
        if( isset( $tab['operande1'] ) && $tab['operande1']!='' && isset( $tab['operande2'] ) && $tab['operande2']!='' ) : // Si les données attendues sont présentes et non vides,
            if( is_numeric( str_replace( ',', '.', $tab['operande1'] ) ) && is_numeric( str_replace( ',', '.', $tab['operande2'] ) ) ) : // Si les données sont numériques (une fois le caractère virgule remplacé par le caractère point pour respecter le format numérique),
                $tab['operande1'] = str_replace( ',', '.', $tab['operande1'] ); // On remplace le caractère virgule par le caractère point pour respecter le format numérique
                $tab['operande2'] = str_replace( ',', '.', $tab['operande2'] ); // On remplace le caractère virgule par le caractère point pour respecter le format numérique
                switch( $tab['operateur'] ) : // Selon l'opérateur,
                    case '+': // Dans le cas d'une addition :
                        return $tab['operande1'] + $tab['operande2']; // On effectue le calcul
                        break;
                    case '-':
                        return $tab['operande1'] - $tab['operande2']; // On effectue le calcul
                        break;
                    case '*':
                        return $tab['operande1'] * $tab['operande2']; // On effectue le calcul
                        break;
                    case '/':
                        if( $tab['operande2']=='0' ) : return 'La division par 0 n\'est pas possible !'; // Si le deuxième champs envoyé contient un 0, on indique une erreur.
                        else : return $tab['operande1'] / $tab['operande2']; // Sinon, on effectue le calcul.
                        endif;
                        break;
                endswitch;
            else :
                return ( !is_numeric( $tab['operande1'] ) ? $tab['operande1'] . ' n\'est pas un nombre valide pour une opération !' . ( !is_numeric( $tab['operande2'] ) ? '<br />' . $tab['operande2'] . ' n\'est pas un nombre valide pour une opération !' : '' ) : ( !is_numeric( $tab['operande2'] ) ? $tab['operande2'] . ' n\'est pas un nombre valide pour une opération !' : '' ) );
            endif;
        else :
            return ( !isset( $tab['operande1'] ) || $tab['operande1']=='' ? 'Veuillez saisir une valeur pour la première opérande !' . ( !isset( $tab['operande2'] ) || $tab['operande2']=='' ? '<br />Veuillez saisir une valeur pour la première opérande !' : '' ) : ( !isset( $tab['operande2'] ) || $tab['operande2']=='' ? 'Veuillez saisir une valeur pour la première opérande !' : '' ) );
        endif;
    endif;
} ?><!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0" />
        <title>Calculatrice | Le passage de données - Mise en pratique</title>

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
            input[type="text"] {
                color:blue;
                padding-left:10px;
                padding-right:10px;
                text-align:right;
                width:150px;
            }
            -->
        </style>
    </head>
    <body>
        <h1>Calculatrice | Le passage de données - Mise en pratique</h1>
        <hr />
        <form action="" method="POST" name="frm-calcul">
            <input name="operande1" type="text" placeholder="Saisir un nombre" value="<?php if( isset( $_POST['operande1'] ) ) { echo $_POST['operande1']; } ?>" />
            <select name="operateur">
                <option<?php if( isset( $_POST['operateur'] ) && $_POST['operateur']=='+' ) echo ' selected="selected"'; ?> value="+">+</option>
                <option<?php if( isset( $_POST['operateur'] ) && $_POST['operateur']=='-' ) echo ' selected="selected"'; ?> value="-">-</option>
                <option<?php if( isset( $_POST['operateur'] ) && $_POST['operateur']=='*' ) echo ' selected="selected"'; ?> value="*">x</option>
                <option<?php echo isset( $_POST['operateur'] ) && $_POST['operateur']=='/' ? ' selected="selected"' : ''; ?> value="/">/</option>
            </select>
            <input name="operande2" type="text" placeholder="Saisir un nombre" value="<?php echo isset( $_POST['operande2'] ) ? $_POST['operande2'] : 0; ?>" />
            <input type="submit" value="=" />
            
            <?php
            if( isset( $_POST ) && count( $_POST )>0 )
                echo is_numeric( calc( $_POST ) ) ? '<input disabled="disabled" placeholder="Résultat" type="text" value="' . calc( $_POST ) . '" />' : '<span style="background-color:red;color:white;display:block;margin:10px 0;padding:4px 7px;">' . calc( $_POST ) . '</span>';
            ?>

            <hr />
            <label>Historique :</label>
            <br />
            <textarea name="historique" cols="50" rows="50"><?php echo ( is_numeric( calc( $_POST ) ) ? calc( $_POST ) : '' ) . ( isset( $_POST['historique'] ) ? "\r\n" . $_POST['historique'] : '' ); ?></textarea>
        </form>
        <form action="" method="POST" name="frm-reset">
            <input type="submit" value="Reset">
        </form>
        <pre><code class="php">
&lt;php
function calc( $tab ) {
    if( isset( $tab ) && count( $tab )>0 ) : // Si on a soumis des données via notre formulaire,
        if( isset( $tab['operande1'] ) && $tab['operande1']!='' && isset( $tab['operande2'] ) && $tab['operande2']!='' ) : // Si les données attendues sont présentes et non vides,
            if( is_numeric( str_replace( ',', '.', $tab['operande1'] ) ) && is_numeric( str_replace( ',', '.', $tab['operande2'] ) ) ) : // Si les données sont numériques (une fois le caractère virgule remplacé par le caractère point pour respecter le format numérique),
                $tab['operande1'] = str_replace( ',', '.', $tab['operande1'] ); // On remplace le caractère virgule par le caractère point pour respecter le format numérique
                $tab['operande2'] = str_replace( ',', '.', $tab['operande2'] ); // On remplace le caractère virgule par le caractère point pour respecter le format numérique
                switch( $tab['operateur'] ) : // Selon l'opérateur,
                    case '+': // Dans le cas d'une addition :
                        return $tab['operande1'] + $tab['operande2']; // On effectue le calcul
                        break;
                    case '-':
                        return $tab['operande1'] - $tab['operande2']; // On effectue le calcul
                        break;
                    case '*':
                        return $tab['operande1'] * $tab['operande2']; // On effectue le calcul
                        break;
                    case '/':
                        if( $tab['operande2']=='0' ) : return 'La division par 0 n\'est pas possible !'; // Si le deuxième champs envoyé contient un 0, on indique une erreur.
                        else : return $tab['operande1'] / $tab['operande2']; // Sinon, on effectue le calcul.
                        endif;
                        break;
                endswitch;
            else :
                return ( !is_numeric( $tab['operande1'] ) ? $tab['operande1'] . ' n\'est pas un nombre valide pour une opération !' . ( !is_numeric( $tab['operande2'] ) ? '<br />' . $tab['operande2'] . ' n\'est pas un nombre valide pour une opération !' : '' ) : ( !is_numeric( $tab['operande2'] ) ? $tab['operande2'] . ' n\'est pas un nombre valide pour une opération !' : '' ) );
            endif;
        else :
            return ( !isset( $tab['operande1'] ) || $tab['operande1']=='' ? 'Veuillez saisir une valeur pour la première opérande !' . ( !isset( $tab['operande2'] ) || $tab['operande2']=='' ? '<br />Veuillez saisir une valeur pour la première opérande !' : '' ) : ( !isset( $tab['operande2'] ) || $tab['operande2']=='' ? 'Veuillez saisir une valeur pour la première opérande !' : '' ) );
        endif;
    endif;
}</code>
<code class="html">
&lt;form action="" method="POST" name="frm-calcul"&gt;
    &lt;input name="operande1" type="text" placeholder="Saisir un nombre" value="&lt;?php if( isset( $_POST['operande1'] ) ) { echo $_POST['operande1']; } ?&gt;" /&gt;
    &lt;select name="operateur"&gt;
        &lt;option&lt;?php if( isset( $_POST['operateur'] ) && $_POST['operateur']=='+' ) echo ' selected="selected"'; ?&gt; value="+"&gt;+&lt;/option&gt;
        &lt;option&lt;?php if( isset( $_POST['operateur'] ) && $_POST['operateur']=='-' ) echo ' selected="selected"'; ?&gt; value="-"&gt;-&lt;/option&gt;
        &lt;option&lt;?php if( isset( $_POST['operateur'] ) && $_POST['operateur']=='*' ) echo ' selected="selected"'; ?&gt; value="*"&gt;x&lt;/option&gt;
        &lt;option&lt;?php echo isset( $_POST['operateur'] ) && $_POST['operateur']=='/' ? ' selected="selected"' : ''; ?&gt; value="/"&gt;/&lt;/option&gt;
    &lt;/select&gt;
    &lt;input name="operande2" type="text" placeholder="Saisir un nombre" value="&lt;?php echo isset( $_POST['operande2'] ) ? $_POST['operande2'] : 0; ?&gt;" /&gt;
    &lt;input type="submit" value="=" /&gt;
    
    &lt;?php
    if( isset( $_POST ) && count( $_POST )&gt;0 )
        echo is_numeric( calc( $_POST ) ) ? '&lt;input disabled="disabled" placeholder="Résultat" type="text" value="' . calc( $_POST ) . '" /&gt;' : '&lt;span style="background-color:red;color:white;display:block;margin:10px 0;padding:4px 7px;"&gt;' . calc( $_POST ) . '&lt;/span&gt;';
    ?&gt;

    &lt;hr /&gt;
    &lt;label&gt;Historique :&lt;/label&gt;
    &lt;br /&gt;
    &lt;textarea name="historique" cols="50" rows="50"&gt;&lt;?php echo ( is_numeric( calc( $_POST ) ) ? calc( $_POST ) : '' ) . ( isset( $_POST['historique'] ) ? "\r\n" . $_POST['historique'] : '' ); ?&gt;&lt;/textarea&gt;
&lt;/form&gt;
&lt;form action="" method="POST" name="frm-reset"&gt;
    &lt;input type="submit" value="Reset"&gt;
&lt;/form&gt;</code></pre>
    </body>
</html>