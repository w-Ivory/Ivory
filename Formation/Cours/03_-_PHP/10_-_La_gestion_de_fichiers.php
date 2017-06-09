<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0" />
        <title>La gestion de fichiers</title>

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
        <h1>La gestion de fichiers</h1>
        <p><em>PHP permet d'enregistrer des données dans des fichiers sur le disque dur du serveur.</em></p>
        <hr />
        <h2>Droits d'accès aux fichiers</h2>
        <p><em>PHP ne possède pas un droit ultime dans le domaine de la gestion de fichiers sur le serveur, il nécessite avant tout un droit d'accès à un dossier.<br />De ce fait vous ne pourrez créer, modifier ou supprimer des fichiers que dans des dossiers pour lesquels votre code a un accès. Pour créer ces droits, on modifie le CHMOD du fichier ou du dossier. Cette opération se fait principalement via une commande sur le serveur ou via un logiciel FTP mais peut se faire aussi en PHP si l'utilisateur actif possède les droits (néanmoins, cela n'est pas conseillé).</em></p>
        <hr />
        <h2>Ouverture et fermeture</h2>
        <p><em>C'est bien beau de parler de lire ou d'écrire dans un fichier mais pour faire cela, il faut avant tout pouvoir l'ouvrir. Ensuite comme nous n'oublions pas qu'il faut libérer nos ressources pour optimiser notre code, nous devrons penser à fermer le fichier ouvert (ce qui nous évitera aussi de ne plus pouvoir accéder à ce fichier car il aurait été mal fermé).</em></p>
        <pre><code class="php">
&lt;?php
$ressourceFichier = fopen( $cheminFichier, 'r' ); // On ouvre le fichier cible en lecture seule et on stocke cette ressource dans une variable (http://php.net/manual/fr/function.fopen.php).
fclose( $ressourceFichier ); // On ferme la ressource ouverte sur le fichier (http://php.net/manual/fr/function.fclose.php).
?&gt;</code></pre>
        <p><em>Il existe plusieurs modes d'ouverture de fichier selon le besoin :</em></p>
        <ul style="font-style:italic;">
            <li><strong>r</strong> : Ouvre en <strong>lecture seule</strong>, et place le pointeur de fichier au début du fichier.</li>
            <li><strong>r+</strong> : Ouvre en <strong>lecture et écriture</strong>, et place le pointeur de fichier au début du fichier.</li>
            <li><strong>w</strong> : Ouvre en <strong>écriture seule</strong>, place le pointeur de fichier au début du fichier et réduit la taille du fichier à 0 (efface son contenu). Si le fichier n'existe pas, on tente de le créer.</li>
            <li><strong>w+</strong> : Ouvre en <strong>lecture et écriture</strong>, place le pointeur de fichier au début du fichier et réduit la taille du fichier à 0 (efface son contenu). Si le fichier n'existe pas, on tente de le créer.</li>
            <li><strong>a</strong> : Ouvre en <strong>écriture seule</strong>, place le pointeur de fichier à la fin du fichier. Si le fichier n'existe pas, on tente de le créer.</li>
            <li><strong>a+</strong> : Ouvre en <strong>lecture et écriture</strong>, place le pointeur de fichier à la fin du fichier. Si le fichier n'existe pas, on tente de le créer.</li>
        </ul>
        <hr />
        <h2>Lecture d'un fichier</h2>
        <p><em>Pour lire un fichier, il existe plusieurs méthodes :</em></p>
        <h3>Lecture complète - fread()</h3>
        <p><em>La fonction PHP prête à l'emploi "fread()" permet de lire dans un fichier jusqu'à un nombre d'octets spécifié. On utilise le plus souvent cette fonction lorsque l'on souhaite récupérer le contenu entier d'un fichier. Pour ce faire, il faut lui indiquer soit une taille siffisamment grande, soit directement la taille du fichier définie par la fonction PHP prête à l'emploi "filesize()".</em></p>
        <pre><code class="php">
&lt;?php
echo fread( $ressourceFichier, filesize( $cheminFichier ) ); // On affiche le contenu de tout le fichier. On utilise la fonction "filesize()" qui nous retourne la taille du fichier en octets. (http://php.net/manual/fr/function.fread.php)
?&gt;</code></pre>
        <a href="10_-_La_gestion_de_fichiers/10_-_La_gestion_de_fichiers_-_fread.php" title="">Voir un exemple d'utilisation avec un fichier PDF</a>
        <h3>Lecture ligne à ligne - fgets()</h3>
        <p><em>La fonction PHP prête à l'emploi "fgets()" permet de lire dans un fichier la ligne désignée par le curseur. Par défaut, il s'agit de la première ligne du fichier. Il faut donc ensuite parcourir tout le fichier (déplacer le curseur à la ligne suivante) pour lire toutes les lignes.</em></p>
        <pre><code class="php">
&lt;?php
echo fgets( $ressourceFichier ); // On affiche le contenu de la ligne désignée par le curseur dans le fichier (http://php.net/manual/fr/function.fgets.php).
?&gt;</code></pre>
        <a href="10_-_La_gestion_de_fichiers/10_-_La_gestion_de_fichiers_-_fgets.php" title="">Voir un exemple d'utilisation avec un fichier texte</a>
        <h3>Lecture caractère par caractère - fgetc()</h3>
        <p><em>La fonction PHP prête à l'emploi "fgetc()" permet de lire dans un fichier le caractère désigné par le curseur. Par défaut, il s'agit du premier caractère de la première ligne du fichier. Il faut donc ensuite parcourir tout le fichier pour lire tous les caractères de toutes les lignes.</em></p>
        <pre><code class="php">
&lt;?php
echo fgetc( $ressourceFichier ); // On affiche le caractère désigné par le curseur dans le fichier (http://php.net/manual/fr/function.fgetc.php).
?&gt;</code></pre>
        <a href="10_-_La_gestion_de_fichiers/10_-_La_gestion_de_fichiers_-_fgetc.php" title="">Voir un exemple d'utilisation avec un fichier texte</a>
        <p class="block alert"><em><strong>Attention</strong> : lire un fichier caractère par caractère peut être très gourmand en ressources !</em></p>
        <hr />
        <h2>Écriture dans un fichier</h2>
        <p><em>La fonction principale pour écrire dans un fichier est "fwrite()". Sachez qu'il existe aussi un alias à cette fonction : "fputs()".</em></p>
        <pre><code class="php">
&lt;?php
fwrite( $ressourceFichier, "Texte à insérer" ); // On écrit le texte à l'emplacmeent du curseur dans le fichier (http://php.net/manual/fr/function.fwrite.php).
?&gt;</code></pre>
        <a href="10_-_La_gestion_de_fichiers/10_-_La_gestion_de_fichiers_-_fwrite.php" title="">Voir un exemple d'utilisation dans un fichier texte</a>
        <h3>Le cas des sauts de ligne</h3>
        <p><em>Il existe une différence dans la gestion des sauts de ligne textuels selon les systèmes d'exploitation (Windows et UNIX).<br />Pour palier à ce problème, PHP nous fournit depuis sa version 5 une constante pré-définie nous indiquant quels caractères appliquer. Néanmoins, il peut s'avérer utile de tester cette constante et de la définir si elle n'existe pas (cas des versions de PHP antérieures à la 5).</em></p>
        <pre><code class="php">
&lt;?php
if( !defined( 'PHP_EOL') ) { // Si la constante PHP_EOL n'existe pas (http://php.net/manual/fr/reserved.constants.php), 
    if( strtoupper( substr( PHP_OS, 0, 3 ) ) == 'WIN' ) { // Si la version du système d'exploitation (fournie par la constantes pré-définie PHP_OS) correspond à un noyau Windows,
        define( 'PHP_EOL', "\r\n" ); // On définit la constante avec les caractères Windows.
    } else { // Sinon,
        define( 'PHP_EOL', "\n" ); // On définit la constante avec les caractères UNIX.
    }
}
?&gt;</code></pre>
        <p class="block alert"><em><strong>Attention</strong> : les caractères de saut de ligne doivent être interprétés par le code PHP et non considérés comme une chaîne de caractères !<br />Pour cela, vous devrez toujours utiliser des <strong>doubles guillemets</strong>.</em></p>
        <hr />
        <h2>Fonctions utiles</h2>
        <h3>Obtenir les informations sur un fichier : pathinfo()</h3>
        <p><?php
        $dossierFichier = '10_-_La_gestion_de_fichiers/';

        $nomFichier = 'Test.txt';
        $cheminFichier = $dossierFichier . $nomFichier;
        print_r( pathinfo( $cheminFichier ) );
        ?></p>
        <pre><code class="php">
&lt;?php
$dossierFichier = '10_-_La_gestion_de_fichiers/';

$nomFichier = 'Test.txt';
$cheminFichier = $dossierFichier . $nomFichier;
print_r( pathinfo( $cheminFichier ) );
?&gt;</code></pre>
        <h3>Obtenir le chemin physique d'un fichier sur le disque du serveur : realpath()</h3>
        <p><?php
        $dossierFichier = '10_-_La_gestion_de_fichiers/';

        $nomFichier = 'Test.txt';
        $cheminFichier = $dossierFichier . $nomFichier;
        echo realpath( $cheminFichier );
        ?></p>
        <pre><code class="php">
&lt;?php
$dossierFichier = '10_-_La_gestion_de_fichiers/';

$nomFichier = 'Test.txt';
$cheminFichier = $dossierFichier . $nomFichier;
echo realpath( $cheminFichier );
?&gt;</code></pre>
        <h3>Effacer un fichier : unlink()</h3>
        <p><?php
        $dossierFichier = '10_-_La_gestion_de_fichiers/';

        $nomFichier = 'monPremierFichier.txt';
        $cheminFichier = $dossierFichier . $nomFichier;
        if( file_exists( $cheminFichier ) ) :
            unlink( $cheminFichier );
        endif;
        ?></p>
        <pre><code class="php">
&lt;?php
$dossierFichier = '10_-_La_gestion_de_fichiers/';

$nomFichier = 'monPremierFichier.txt';
$cheminFichier = $dossierFichier . $nomFichier;
if( file_exists( $cheminFichier ) ) :
    unlink( $cheminFichier );
endif;
?&gt;</code></pre>
        <p class="block alert"><em>Il existe de nombreuses autres fonctions spécifiques aux systèmes de fichiers. Vous en trouverez la liste complète dans le <a href="http://php.net/manual/fr/ref.filesystem.php" target="_blank" title="">Manuel PHP : Fonctions sur les systèmes de fichiers</a></em></p>
        <p class="block alert"><em>PHP permet aussi de maniupler les dossiers. Vous trouverez la liste complète des fonctions dans le <a href="http://php.net/manual/fr/ref.dir.php" target="_blank" title="">Manuel PHP : Fonctions sur les dossiers</a></em></p>
    </body>
</html>