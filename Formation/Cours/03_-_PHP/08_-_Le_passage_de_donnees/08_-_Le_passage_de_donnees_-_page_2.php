<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0" />
        <title>Le passage de données - Page 2</title>

        <!-- // highlight.js : Coloration syntaxique du code -->
        <link rel="stylesheet" type="text/css" href="../../../_assets/plugins/highlight/styles/monokai_sublime.css">
        <script type="text/javascript" src="../../../_assets/plugins/highlight/highlight.pack.js"></script>
        <script type="text/javascript">
            hljs.initHighlightingOnLoad();
        </script>
        <!-- // -->

        <link rel="stylesheet" type="text/css" href="../../../_assets/css/style.css">
    </head>
    <body>
        <h1>Le passage de données - Page 2</h1>
        <a href="../08_-_Le_passage_de_donnees.php" style="color:rgb(0,0,0);" title="">&larr; Retour au cours</a>
        <hr />
        <h2>Traitement du passage de données avec la superglobale $_GET via l'URL d'une page :</h2>
        <p>
        <?php
        if( isset( $_GET ) && ( array_key_exists( 'prenom', $_GET ) || array_key_exists( 'nom', $_GET ) ) ) :
            echo 'Bonjour';
            if( array_key_exists( 'prenom', $_GET ) ) echo ' ' . $_GET['prenom'];
            if( array_key_exists( 'nom', $_GET ) ) echo ' ' . $_GET['nom'];
            echo ' ! ';
        else :
            echo 'Aucune donnée de nom et prénom n\'a été passée !';
        endif;
        ?>
        </p>
        <pre><code class="php">
&lt;?php
if( isset( $_GET['prenom'] ) && isset( $_GET['nom'] ) ) : // if( isset( $_GET ) && ( array_key_exists( 'prenom', $_GET ) || array_key_exists( 'nom', $_GET ) ) ) : // Si la superglobale $_GET existe ET l'une des clés "prenom" OU "nom" existent dans le tableau de la superglobale,
    echo 'Bonjour'; // On affiche la chaîne de caractères.
    if( array_key_exists( 'prenom', $_GET ) ) echo ' ' . $_GET['prenom']; // Si la clé "prenom" existe dans le tableau de la superglobale, on affiche la valeur contenue à la clé "prenom".
    if( array_key_exists( 'nom', $_GET ) ) echo ' ' . $_GET['nom']; // Si la clé "nom" existe dans le tableau de la superglobale, on affiche la valeur contenue à la clé "nom".
    echo ' ! ';
else : // Sinon,
    echo 'Aucune donnée de nom et prénom n\'a été passée !';
endif;
?&gt;</code></pre>
        <hr />
        <h2>Traitement du passage de données avec la superglobale $_GET via un formulaire :</h2>
        <p>
        <?php
        if( isset( $_GET ) && count( $_GET )>0 ) :
            if( array_key_exists( 'txt-nom', $_GET ) ) echo '<br />Passage de la valeur de "Chaîne de caractère" : ' . $_GET['txt-nom'];
            if( array_key_exists( 'txt-password', $_GET ) ) echo '<br /><br />Passage de la valeur de "Mot de passe" : ' . $_GET['txt-password'];
            if( array_key_exists( 'txt-tel', $_GET ) ) echo '<br /><br />Passage de la valeur de "Téléphone" : ' . $_GET['txt-tel'];
            if( array_key_exists( 'txt-email', $_GET ) ) echo '<br /><br />Passage de la valeur de "Email" : ' . $_GET['txt-email'];
            if( array_key_exists( 'txt-url', $_GET ) ) echo '<br /><br />Passage de la valeur de "URL" : ' . $_GET['txt-url'];
            if( array_key_exists( 'txt-number', $_GET ) ) echo '<br /><br />Passage de la valeur de "Nombre" : ' . $_GET['txt-number'];
            if( array_key_exists( 'txt-date', $_GET ) ) echo '<br /><br />Passage de la valeur de "Date" : ' . $_GET['txt-date'];
            if( array_key_exists( 'txt-time', $_GET ) ) echo '<br /><br />Passage de la valeur de "Heure" : ' . $_GET['txt-time'];
            if( array_key_exists( 'txt-range', $_GET ) ) echo '<br /><br />Passage de la valeur de "Gamme" : ' . $_GET['txt-range'];
            if( array_key_exists( 'txt-color', $_GET ) ) echo '<br /><br />Passage de la valeur de "Couleur" : ' . $_GET['txt-color'];
            if( array_key_exists( 'txt-hidden', $_GET ) ) echo '<br /><br />Passage de la valeur du champs caché : ' . $_GET['txt-hidden'];
            if( array_key_exists( 'txt-text', $_GET ) ) echo '<br /><br />Passage de la valeur de "Bloc de texte" : ' . nl2br( $_GET['txt-text'] ); // Afin de conserver les retours à la ligne, il faut utiliser la fonction PHP prête à l'emploi "nl2br()" qui transforme les retours à la ligne textuels en retour à la ligne HTML (http://php.net/manual/fr/function.nl2br.php).
            if( array_key_exists( 'list', $_GET ) ) echo '<br /><br />Passage de la valeur de "Liste de sélection" : ' . $_GET['list'];
            if( array_key_exists( 'radio', $_GET ) ) echo '<br /><br />Passage de la valeur de "Êtes-vous d\'accord ?" : ' . $_GET['radio'];
            if( array_key_exists( 'chk', $_GET ) ) :
                echo '<br /><br />Passage des valeurs de "Choix à cocher" :';
                foreach( $_GET['chk'] as $case ) :
                    echo '<br />&nbsp;&nbsp;&nbsp;' . $case;
                endforeach;
            endif;
        else :
            echo 'Aucune donnée GET n\'a été passée !';
        endif;
        ?>
        </p>
        <pre><code class="php">
&lt;?php
if( isset( $_GET ) && count( $_GET )>0 ) :
    if( array_key_exists( 'txt-nom', $_GET ) ) echo '&lt;br /&gt;Passage de la valeur de "Chaîne de caractère" : ' . $_GET['txt-nom'];
    if( array_key_exists( 'txt-password', $_GET ) ) echo '&lt;br /&gt;&lt;br /&gt;Passage de la valeur de "Mot de passe" : ' . $_GET['txt-password'];
    if( array_key_exists( 'txt-tel', $_GET ) ) echo '&lt;br /&gt;&lt;br /&gt;Passage de la valeur de "Téléphone" : ' . $_GET['txt-tel'];
    if( array_key_exists( 'txt-email', $_GET ) ) echo '&lt;br /&gt;&lt;br /&gt;Passage de la valeur de "Email" : ' . $_GET['txt-email'];
    if( array_key_exists( 'txt-url', $_GET ) ) echo '&lt;br /&gt;&lt;br /&gt;Passage de la valeur de "URL" : ' . $_GET['txt-url'];
    if( array_key_exists( 'txt-number', $_GET ) ) echo '&lt;br /&gt;&lt;br /&gt;Passage de la valeur de "Nombre" : ' . $_GET['txt-number'];
    if( array_key_exists( 'txt-date', $_GET ) ) echo '&lt;br /&gt;&lt;br /&gt;Passage de la valeur de "Date" : ' . $_GET['txt-date'];
    if( array_key_exists( 'txt-time', $_GET ) ) echo '&lt;br /&gt;&lt;br /&gt;Passage de la valeur de "Heure" : ' . $_GET['txt-time'];
    if( array_key_exists( 'txt-range', $_GET ) ) echo '&lt;br /&gt;&lt;br /&gt;Passage de la valeur de "Gamme" : ' . $_GET['txt-range'];
    if( array_key_exists( 'txt-color', $_GET ) ) echo '&lt;br /&gt;&lt;br /&gt;Passage de la valeur de "Couleur" : ' . $_GET['txt-color'];
    if( array_key_exists( 'txt-hidden', $_GET ) ) echo '&lt;br /&gt;&lt;br /&gt;Passage de la valeur du champs caché : ' . $_GET['txt-hidden'];
    if( array_key_exists( 'txt-text', $_GET ) ) echo '&lt;br /&gt;&lt;br /&gt;Passage de la valeur de "Bloc de texte" : ' . nl2br( $_GET['txt-text'] ); // Afin de conserver les retours à la ligne, il faut utiliser la fonction PHP prête à l'emploi "nl2br()" qui transforme les retours à la ligne textuels en retour à la ligne HTML (http://php.net/manual/fr/function.nl2br.php).
    if( array_key_exists( 'list', $_GET ) ) echo '&lt;br /&gt;&lt;br /&gt;Passage de la valeur de "Liste de sélection" : ' . $_GET['list'];
    if( array_key_exists( 'radio', $_GET ) ) echo '&lt;br /&gt;&lt;br /&gt;Passage de la valeur de "Êtes-vous d\'accord ?" : ' . $_GET['radio'];
    if( array_key_exists( 'chk', $_GET ) ) :
        echo '&lt;br /&gt;&lt;br /&gt;Passage des valeurs de "Choix à cocher" :';
        foreach( $_GET['chk'] as $case ) :
            echo '&lt;br /&gt;&nbsp;&nbsp;&nbsp;' . $case;
        endforeach;
    endif;
endif;
?&gt;</code></pre>
        <hr />
        <h2>Traitement du passage de données avec la superglobale $_POST :</h2>
        <p>
        <?php
        if( isset( $_POST ) && count( $_POST )>0 ) :
            if( array_key_exists( 'txt-nom', $_POST ) ) echo '<br />Passage de la valeur de "Chaîne de caractère" : ' . $_POST['txt-nom'];
            if( array_key_exists( 'txt-password', $_POST ) ) echo '<br /><br />Passage de la valeur de "Mot de passe" : ' . $_POST['txt-password'];
            if( array_key_exists( 'txt-tel', $_POST ) ) echo '<br /><br />Passage de la valeur de "Téléphone" : ' . $_POST['txt-tel'];
            if( array_key_exists( 'txt-email', $_POST ) ) echo '<br /><br />Passage de la valeur de "Email" : ' . $_POST['txt-email'];
            if( array_key_exists( 'txt-url', $_POST ) ) echo '<br /><br />Passage de la valeur de "URL" : ' . $_POST['txt-url'];
            if( array_key_exists( 'txt-number', $_POST ) ) echo '<br /><br />Passage de la valeur de "Nombre" : ' . $_POST['txt-number'];
            if( array_key_exists( 'txt-date', $_POST ) ) echo '<br /><br />Passage de la valeur de "Date" : ' . $_POST['txt-date'];
            if( array_key_exists( 'txt-time', $_POST ) ) echo '<br /><br />Passage de la valeur de "Heure" : ' . $_POST['txt-time'];
            if( array_key_exists( 'txt-range', $_POST ) ) echo '<br /><br />Passage de la valeur de "Gamme" : ' . $_POST['txt-range'];
            if( array_key_exists( 'txt-color', $_POST ) ) echo '<br /><br />Passage de la valeur de "Couleur" : ' . $_POST['txt-color'];
            if( array_key_exists( 'txt-hidden', $_POST ) ) echo '<br /><br />Passage de la valeur du champs caché : ' . $_POST['txt-hidden'];
            if( array_key_exists( 'txt-text', $_POST ) ) echo '<br /><br />Passage de la valeur de "Bloc de texte" : ' . nl2br( $_POST['txt-text'] ); // Afin de conserver les retours à la ligne, il faut utiliser la fonction PHP prête à l'emploi "nl2br()" qui transforme les retours à la ligne textuels en retour à la ligne HTML (http://php.net/manual/fr/function.nl2br.php).
            if( array_key_exists( 'list', $_POST ) ) echo '<br /><br />Passage de la valeur de "Liste de sélection" : ' . $_POST['list'];
            if( array_key_exists( 'radio', $_POST ) ) echo '<br /><br />Passage de la valeur de "Êtes-vous d\'accord ?" : ' . $_POST['radio'];
            if( array_key_exists( 'chk', $_POST ) ) :
                echo '<br /><br />Passage des valeurs de "Choix à cocher" :';
                foreach( $_POST['chk'] as $case ) :
                    echo '<br />&nbsp;&nbsp;&nbsp;' . $case;
                endforeach;
            endif;
        else :
            echo 'Aucune donnée POST n\'a été passée !';
        endif;
        ?>
        </p>
        <pre><code class="php">
&lt;?php
if( isset( $_POST ) && count( $_POST )>0 ) :
    if( array_key_exists( 'txt-nom', $_POST ) ) echo '&lt;br /&gt;Passage de la valeur de "Chaîne de caractère" : ' . $_POST['txt-nom'];
    if( array_key_exists( 'txt-password', $_POST ) ) echo '&lt;br /&gt;&lt;br /&gt;Passage de la valeur de "Mot de passe" : ' . $_POST['txt-password'];
    if( array_key_exists( 'txt-tel', $_POST ) ) echo '&lt;br /&gt;&lt;br /&gt;Passage de la valeur de "Téléphone" : ' . $_POST['txt-tel'];
    if( array_key_exists( 'txt-email', $_POST ) ) echo '&lt;br /&gt;&lt;br /&gt;Passage de la valeur de "Email" : ' . $_POST['txt-email'];
    if( array_key_exists( 'txt-url', $_POST ) ) echo '&lt;br /&gt;&lt;br /&gt;Passage de la valeur de "URL" : ' . $_POST['txt-url'];
    if( array_key_exists( 'txt-number', $_POST ) ) echo '&lt;br /&gt;&lt;br /&gt;Passage de la valeur de "Nombre" : ' . $_POST['txt-number'];
    if( array_key_exists( 'txt-date', $_POST ) ) echo '&lt;br /&gt;&lt;br /&gt;Passage de la valeur de "Date" : ' . $_POST['txt-date'];
    if( array_key_exists( 'txt-time', $_POST ) ) echo '&lt;br /&gt;&lt;br /&gt;Passage de la valeur de "Heure" : ' . $_POST['txt-time'];
    if( array_key_exists( 'txt-range', $_POST ) ) echo '&lt;br /&gt;&lt;br /&gt;Passage de la valeur de "Gamme" : ' . $_POST['txt-range'];
    if( array_key_exists( 'txt-color', $_POST ) ) echo '&lt;br /&gt;&lt;br /&gt;Passage de la valeur de "Couleur" : ' . $_POST['txt-color'];
    if( array_key_exists( 'txt-hidden', $_POST ) ) echo '&lt;br /&gt;&lt;br /&gt;Passage de la valeur du champs caché : ' . $_POST['txt-hidden'];
    if( array_key_exists( 'txt-text', $_POST ) ) echo '&lt;br /&gt;&lt;br /&gt;Passage de la valeur de "Bloc de texte" : ' . nl2br( $_POST['txt-text'] ); // Afin de conserver les retours à la ligne, il faut utiliser la fonction PHP prête à l'emploi "nl2br()" qui transforme les retours à la ligne textuels en retour à la ligne HTML (http://php.net/manual/fr/function.nl2br.php).
    if( array_key_exists( 'list', $_POST ) ) echo '&lt;br /&gt;&lt;br /&gt;Passage de la valeur de "Liste de sélection" : ' . $_POST['list'];
    if( array_key_exists( 'radio', $_POST ) ) echo '&lt;br /&gt;&lt;br /&gt;Passage de la valeur de "Êtes-vous d\'accord ?" : ' . $_POST['radio'];
    if( array_key_exists( 'chk', $_POST ) ) :
        echo '&lt;br /&gt;&lt;br /&gt;Passage des valeurs de "Choix à cocher" :';
        foreach( $_POST['chk'] as $case ) :
            echo '&lt;br /&gt;&nbsp;&nbsp;&nbsp;' . $case;
        endforeach;
    endif;
endif;
?&gt;</code></pre>
        <hr />
        <h2>Sécuriser les formulaires PHP : htmlentities()</h2>
        <p>
        <?php
        if( isset( $_POST ) && count( $_POST )>0 ) :
            if( array_key_exists( 'txt-htmlentities', $_POST ) ) :
                echo '<br />Passage de la valeur de "Chaîne de caractère" : ';
                if( array_key_exists( 'radio-htmlentities', $_POST ) && $_POST['radio-htmlentities']=='Oui' ) :
                    echo htmlentities( $_POST['txt-htmlentities'] );
                else :
                    echo $_POST['txt-htmlentities'];
                endif;
            endif;
        else :
            echo 'Aucune donnée POST n\'a été passée !';
        endif;
        ?>
        </p>
        <pre><code class="php">
&lt;?php
if( isset( $_POST ) && count( $_POST )>0 ) :
    if( array_key_exists( 'txt-htmlentities', $_POST ) ) :
        echo '&lt;br /&gt;Passage de la valeur de "Chaîne de caractère" : ';
        if( array_key_exists( 'radio-htmlentities', $_POST ) && $_POST['radio-htmlentities']=='Oui' ) :
            echo htmlentities( $_POST['txt-htmlentities'] );
        else :
            echo $_POST['txt-htmlentities'];
        endif;
    endif;
else :
    echo 'Aucune donnée POST n\'a été passée !';
endif;
?&gt;</code></pre>
    </body>
</html>