<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0" />
        <title>Les sessions</title>

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
        <h1>Les sessions</h1>
        <p><em>Nous avons déjà pu travailler avec les superglobales $_GET et $_POST lors de nos passages de données.<br />Sachez qu'il existe plusieurs autres superglobales ayant des rôles spécifiques. L'une d'entre elles nous permet de stocker des informations qui seront accessibles dans toutes les pages de notre applicatif web durant le temps de notre utilisation : la superglobale $_SESSION.</em></p>
        <p><em>Là où les superglobales $_GET et $_POST ne nous permettent de faire transiter des données qu'entre deux pages et sont vidées à chaque fois, les sessions nous permettent de conserver des données au travers de toutes les pages de notre site.</em></p>
        <hr />
        <h2>Comment fonctionnent les sessions ?</h2>
        <h3>Le démarrage d'une session</h3>
        <p><em>Afin qu'une page puisse accéder à l'espace de stockage des sessions, il faut avant tout lui démarrer une instance. Cette déclaration va automatiquement générer un identifiant unique appelé "ID de session" (aussi appelé "PHPSESSID"). Il devient la référence entre l'ordinateur, le site et la session. Il est généralement transmis via les cookies.</em></p>
        <?php
        echo '<br />La fonction session_id() retourne la valeur : ' . session_id(); // Affiche l'ID de session via la fonction PHP prête à l'emploi liée aux sessions.
        echo '<br />La superglobale $_COOKIE retourne à la clé PHPSESSID la valeur : ' . $_COOKIE['PHPSESSID']; // Affiche l'ID de session via les cookies (superglobale $_COOKIE).
        ?>
        <pre><code class="php">
&lt;?php
session_start(); // On initialise l'accès aux sessions.

echo '&lt;br /&gt;La fonction session_id() retourne la valeur : ' . session_id(); // Affiche l'ID de session via la fonction PHP prête à l'emploi liée aux sessions.
echo '&lt;br /&gt;La superglobale $_COOKIE retourne à la clé PHPSESSID la valeur : ' . $_COOKIE['PHPSESSID']; // Affiche l'ID de session via les cookies (superglobale $_COOKIE).
?&gt;</code></pre>
        <p class="block alert"><em>Cette déclaration doit être écrite sur chaque page ayant besoin d'accéder aux sessions.</em></p>
        <h3>L'accès aux données de stockage en session</h3>
        <p><em>Pour l'exemple, nous allons initialiser des valeurs dans le tableau de la superglobale $_SESSION que nous allons afficher dans cette même page et dans une page accessible via un simple lien :</em></p>
        <?php
        $_SESSION['nom'] = 'LAVOITUREDANSLEGARAGE';
        $_SESSION['prenom'] = 'Edgard';

        echo $_SESSION['prenom'] . ' ' . $_SESSION['nom'];
        ?>
        <br />
        <a href="09_-_Les_sessions/09_-_Les_sessions_-_page_2.php" title="">Lien vers la page 2</a>
        <pre><code class="php">
&lt;?php
session_start(); // On initialise l'accès aux sessions.

$_SESSION['nom'] = 'LAVOITUREDANSLEGARAGE'; // On affecte la valeur à la clé "nom" dans le tableau de la superglobale de session.
$_SESSION['prenom'] = 'Edgard'; // On affecte la valeur à la clé "prenom" dans le tableau de la superglobale de session.

echo $_SESSION['prenom'] . ' ' . $_SESSION['nom']; // On affiche les valeurs présentes aux clés "prenom" et nom" dans le tableau de la superglobale de session.
?&gt;</code>
<code class="html">
&lt;a href="9 - Les sessions/9 - Les sessions - page 2.php" title=""&gt;Lien vers la page 2&lt;/a&gt;
</code></pre>
        <h3>La destruction d'une donnée de session</h3>
        <p><em>Afin d'éviter de perdre des données, on assigne souvent ces instructions à une condition qui dépend d'une action utilisateur.</em></p>
        <br />
        <a class="bt" href="09_-_Les_sessions/09_-_Les_sessions_-_page_2.php?destroy" title="">Détruire la session</a>
        <pre><code class="php">
&lt;?php
unset( $_SESSION['prenom'] ); // On vide et supprime la clé "prenom" dans le tableau de la superglobale $_SESSION.
session_destroy(); // On détruit toutes les sessions en cours.
?&gt;</code></pre>
        <p class="block alert"><em>La fonction "session_destroy()" est automatiquement appelée lors du "timeout" configuré sur le serveur; c'est à dire au bout d'un certain temps d'inactivité de l'internaute sur l'applicatif web.</em></p>
    </body>
</html>