<?php
session_start();
require( '09_-_Les_sessions_-_Le_livre_dont_vous_etes_le_hero/story.php' );

/**
 * verifyChapter - Vérifie si le chapitre indiqué est correct
 * @param   array   $db
 * @param   int     $n
 * @return  int
**/
function verifyChapter( $db, $n ) {
    return ( isset( $n ) && is_numeric( $n ) && isset( $db[$n] ) ? $n : 0 ); // Si un chapitre est transmis, que sa valeur est numérique et qu'il existe dans l'histoire, on conserve sa valeur. Sinon, on réinitialise l'histoire
}

/**
 * getChapter - Retourne le texte du chapitre en cours
 * @param   array   $db
 * @param   int     $n
 * @return  string
**/
function getChapter( $db, $n ) {
    $n = verifyChapter( $db, $n ); // On vérifie le chapitre

    return nl2br( $db[$n]['text'] );
}

/**
 * getChoices - Retourne le formulaire de choix
 * @param   array   $db
 * @param   int     $n
 * @return  string
**/
function getChoices( $db, $n ) {
    $n = verifyChapter( $db, $n ); // On vérifie le chapitre

    $choices = '
        <hr />
        <form action="" method="POST" name="frm-story" novalidate="novalidate">
            <label for="list-choice">Que faites-vous ? </label>';

    if( count( $db[$n]['choice'] )>1 ) : // S'il y a plusieurs choix possibles,
        $choices .= '
                <select id="list-choice" name="goto">';
        foreach( $db[$n]['choice'] as $value ) : // Pour chaque choix,
            $choices .= '
                    <option value="' . $value['goto'] . '">' . $value['text'] . '</option>';
        endforeach;
        $choices .= '
            </select>
            <input type="submit" value="Poursuivre l\'histoire" />';
    elseif( count( $db[$n]['choice'] )===1 ) : // S'il n'y a qu'un seul choix possible,
        $choices .= '
            <input name="goto" type="hidden" value="' . $db[$n]['choice'][0]['goto'] . '"><input type="submit" value="' . $db[$n]['choice'][0]['text'] . '" />';
    endif;

    $choices .= '
        </form>';

    return $choices;
}

/**
 * play - Démarre le jeu
 * @param   array   $db
 * @param   int     $n
 * @return  
**/
function play( $db, $n ) {
    $n = verifyChapter( $db, $n ); // On vérifie le chapitre

    echo getChapter( $db, $n ); // On affiche le chapitre en cours
    echo getChoices( $db, $n ); // On affiche le(s) choix
}
?><!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0" />
        <title>Le livre dont vous êtes le héro | Les sessions - Mise en pratique</title>

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
        <h1>Le livre dont vous êtes le héro | Les sessions - Mise en pratique</h1>
        <p><em>Le livre dont vous êtes le héro est un concept bien connu dans lequel il existe plusieurs points d'arrêt où un choix vous est proposé. Ce choix influence la suite de votre parcours dans l'histoire.</em></p>
        <p><em>Dans cet exercice, le fichier <a href="09_-_Les_sessions_-_Le_livre_dont_vous_etes_le_hero/story.php" title="Morceaux de l'hitoire">story.php</a> contenant les différents morceaux de l'histoire vous est mis à disposition.<br />Il vous est demandé :</em></p>
        <ol style="font-style:italic;">
            <li>de créer une fonction pour afficher le chapitre n</li>
            <li>mettre en place un formulaire proposant les choix possibles à chaque décision à prendre</li>
            <li>faire en sorte d'ajouter une persistance des données pour ne pas perdre le cours de l'histoire</li>
        </ol>
        <hr />
        <h2>Votre histoire</h2>
        <?php
        if( !isset( $_SESSION['makemyownstory']['current'] ) ) // Si aucune histoire n'est écrite,
            $_SESSION['makemyownstory']['current'] = 0; // On indique que nous sommes au premier chapitre

        if( isset( $_POST['goto'] ) && is_numeric( $_POST['goto'] ) && isset( $story[$_POST['goto']] ) ) // Si on effectue une action,
            $_SESSION['makemyownstory']['current'] = $_POST['goto']; // On change de chapitre

        play( $story, $_SESSION['makemyownstory']['current'] ); // On lance le jeu avec le chapitre en cours
        ?>
        <pre><code class="php">
session_start();
require( '09_-_Les_sessions_-_Le_livre_dont_vous_etes_le_hero/story.php' );

/**
 * verifyChapter - Vérifie si le chapitre indiqué est correct
 * @param   array   $db
 * @param   int     $n
 * @return  int
**/
function verifyChapter( $db, $n ) {
    return ( isset( $n ) && is_numeric( $n ) && isset( $db[$n] ) ? $n : 0 ); // Si un chapitre est transmis, que sa valeur est numérique et qu'il existe dans l'histoire, on conserve sa valeur. Sinon, on réinitialise l'histoire
}

/**
 * getChapter - Retourne le texte du chapitre en cours
 * @param   array   $db
 * @param   int     $n
 * @return  string
**/
function getChapter( $db, $n ) {
    $n = verifyChapter( $db, $n ); // On vérifie le chapitre

    return nl2br( $db[$n]['text'] );
}

/**
 * getChoices - Retourne le formulaire de choix
 * @param   array   $db
 * @param   int     $n
 * @return  string
**/
function getChoices( $db, $n ) {
    $n = verifyChapter( $db, $n ); // On vérifie le chapitre

    $choices = '
        &lt;hr /&gt;
        &lt;form action="" method="POST" name="frm-story" novalidate="novalidate"&gt;
            &lt;label for="list-choice"&gt;Que faites-vous ? &lt;/label&gt;';

    if( count( $db[$n]['choice'] )&gt;1 ) : // S'il y a plusieurs choix possibles,
        $choices .= '
                &lt;select id="list-choice" name="goto"&gt;';
        foreach( $db[$n]['choice'] as $value ) : // Pour chaque choix,
            $choices .= '
                    &lt;option value="' . $value['goto'] . '"&gt;' . $value['text'] . '&lt;/option&gt;';
        endforeach;
        $choices .= '
            &lt;/select&gt;
            &lt;input type="submit" value="Poursuivre l\'histoire" /&gt;';
    elseif( count( $db[$n]['choice'] )===1 ) : // S'il n'y a qu'un seul choix possible,
        $choices .= '
            &lt;input name="goto" type="hidden" value="' . $db[$n]['choice'][0]['goto'] . '"&gt;&lt;input type="submit" value="' . $db[$n]['choice'][0]['text'] . '" /&gt;';
    endif;
    
    $choices .= '
        &lt;/form&gt;';

    return $choices;
}

/**
 * play - Démarre le jeu
 * @param   array   $db
 * @param   int     $n
 * @return  void
**/
function play( $db, $n ) {
    $n = verifyChapter( $db, $n ); // On vérifie le chapitre

    echo getChapter( $db, $n ); // On affiche le chapitre en cours
    echo getChoices( $db, $n ); // On affiche le(s) choix
}</code>
<pre><code class="php">
if( !isset( $_SESSION['makemyownstory']['current'] ) ) // Si aucune histoire n'est écrite,
    $_SESSION['makemyownstory']['current'] = 0; // On indique que nous sommes au premier chapitre

if( isset( $_POST['goto'] ) && is_numeric( $_POST['goto'] ) && isset( $story[$_POST['goto']] ) ) // Si on effectue une action,
    $_SESSION['makemyownstory']['current'] = $_POST['goto']; // On change de chapitre

play( $story, $_SESSION['makemyownstory']['current'] ); // On lance le jeu avec le chapitre en cours</code></pre></pre>
    </body>
</html>