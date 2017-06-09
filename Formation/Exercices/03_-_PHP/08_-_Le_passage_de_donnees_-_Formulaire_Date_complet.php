<?php
$date = [
    'days'      => ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'],
    'months'    => ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre']
];
?><!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0" />
        <title>Saisie de date | Le passage de données - Mise en pratique</title>

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
        <h1>Saisie de date | Le passage de données - Mise en pratique</h1>
        <p>Dans cet exercice, nous souhaitons mettre en place un sélecteur de date, élément par élément. Nous allons donc devoir :</p>
        <ul>
            <li>stocker dans des tableaux les jours (lundi, mardi, ...) et les mois (janvier, février, ...)</li>
            <li>créer un formulaire HTML avec :
                <ul>
                    <li>une liste déroulante pour le jour</li>
                    <li>un champ pour le numéro du jour dans le mois</li>
                    <li>une liste déroulante pour le mois</li>
                </ul>
            </li>
        </ul>
        <p>A la soumission du formulaire, vous devrez afficher en dessous la date sélectionnée.</p>
        <hr />
        <form action="" method="POST" name="frm-date">
            <fieldset>
                <legend>Composez une date :</legend>
                
                <?php if( isset( $_POST['month'] ) ) : ?>
                <select name="day">
                    <?php
                    foreach( $date['days'] as $key=>$item ) :
                        echo '<option' . ( isset( $_POST['day'] ) ? ( $_POST['day']==$item ? ' selected="selected"' : '' ) : ( $key==( date('N') - 1 ) ? ' selected="selected"' : '' ) ) . ' value="' . $item . '">' . $item . '</option>';
                    endforeach;
                    ?>
                </select>

                <?php /* ?>
                <input name="num" min="1" max="<?php
                switch( $_POST['month'] ) :
                    case 'Janvier':
                    case 'Mars':
                    case 'Mai':
                    case 'Juillet':
                    case 'Août':
                    case 'Octobre':
                    case 'Décembre':
                        echo '31';
                        break;
                    case 'Avril':
                    case 'Juin':
                    case 'Septembre':
                    case 'Novembre':
                        echo '30';
                        break;
                    case 'Février':
                        echo idate( 'L' )===1 ? '29' : '28'; // On teste les années bissextile (http://php.net/manual/fr/function.idate.php)
                        break;
                endswitch;
                ?>" type="number" value="<?php echo isset( $_POST['num'] ) ? $_POST['num'] : date('j'); ?>" />
                <?php */ ?>
                <input name="num" min="1" max="<?php echo date( 't', mktime( 0, 0, 0, array_search( $_POST['month'], $date['months'] ) + 1, 1, date( 'Y' ) ) ); ?>" type="number" value="<?php echo isset( $_POST['num'] ) ? $_POST['num'] : date('j'); ?>" />
                <?php endif; ?>

                <select name="month">
                    <?php
                    if( isset( $_POST['month'] ) && in_array( $_POST['month'], $date['months'] ) ) :
                        echo '<option selected="selected" value="' . $_POST['month'] . '">' . $_POST['month'] . '</option>';
                    else :
                        foreach( $date['months'] as $key=>$item ) :
                            echo '<option' . ( ( isset( $_POST['month'] ) && $_POST['month']==$item ) || $key==( date('n') - 1 ) ? ' selected="selected"' : '' ) . ' value="' . $item . '">' . $item . '</option>';
                        endforeach;
                    endif;
                    ?>
                </select>

                <input type="submit" value="Envoyer la date" />
            </fieldset>
        </form>

        <hr />
        <?php
        if( isset( $_POST ) && count( $_POST )==3 )
            echo '<p>Date choisie :' . ( isset( $_POST['day'] ) ? ' ' . $_POST['day'] : '' ) . ( isset( $_POST['num'] ) ? ' ' . $_POST['num'] : '' ) . ( isset( $_POST['month'] ) ? ' ' . $_POST['month'] : '' ) . '</p>';
        ?>

        <form action="" method="POST" name="frm-reset">
            <input type="submit" value="Reset">
        </form>
        <pre><code class="php">
&lt;?php
$date = [
    'days'      =&gt; ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
    'months'    =&gt; ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre']
];
?&gt;</code>
<code class="html">
&lt;form action="" method="POST" name="frm-date"&gt;
    &lt;fieldset&gt;
        &lt;legend&gt;Composez une date :&lt;/legend&gt;
        
        &lt;?php if( isset( $_POST['month'] ) ) : ?&gt;
        &lt;select name="day"&gt;
            &lt;?php
            foreach( $date['days'] as $key=&gt;$item ) :
                echo '&lt;option' . ( isset( $_POST['day'] ) ? ( $_POST['day']==$item ? ' selected="selected"' : '' ) : ( $key==( date('N') - 1 ) ? ' selected="selected"' : '' ) ) . ' value="' . $item . '"&gt;' . $item . '&lt;/option&gt;';
            endforeach;
            ?&gt;
        &lt;/select&gt;

        &lt;input name="num" min="1" max="&lt;?php echo date( 't', mktime( 0, 0, 0, array_search( $_POST['month'], $date['months'] ) + 1, 1, date( 'Y' ) ) ); ?&gt;" type="number" value="&lt;?php echo isset( $_POST['num'] ) ? $_POST['num'] : date('j'); ?&gt;" /&gt;
        &lt;?php endif; ?&gt;

        &lt;select name="month"&gt;
            &lt;?php
            if( isset( $_POST['month'] ) && in_array( $_POST['month'], $date['months'] ) ) :
                echo '&lt;option selected="selected" value="' . $_POST['month'] . '"&gt;' . $_POST['month'] . '&lt;/option&gt;';
            else :
                foreach( $date['months'] as $key=&gt;$item ) :
                    echo '&lt;option' . ( ( isset( $_POST['month'] ) && $_POST['month']==$item ) || $key==( date('n') - 1 ) ? ' selected="selected"' : '' ) . ' value="' . $item . '"&gt;' . $item . '&lt;/option&gt;';
                endforeach;
            endif;
            ?&gt;
        &lt;/select&gt;

        &lt;input type="submit" value="Envoyer la date" /&gt;
    &lt;/fieldset&gt;
&lt;/form&gt;

&lt;hr /&gt;
&lt;?php
if( isset( $_POST ) && count( $_POST )==3 )
    echo '&lt;p&gt;Date choisie :' . ( isset( $_POST['day'] ) ? ' ' . $_POST['day'] : '' ) . ( isset( $_POST['num'] ) ? ' ' . $_POST['num'] : '' ) . ( isset( $_POST['month'] ) ? ' ' . $_POST['month'] : '' ) . '&lt;/p&gt;';
?&gt;

&lt;form action="" method="POST" name="frm-reset"&gt;
    &lt;input type="submit" value="Reset"&gt;
&lt;/form&gt;</code></pre>
    </body>
</html>