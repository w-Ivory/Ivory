<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0" />
        <title>Introduction à la POO</title>

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
        <h1>Introduction à la POO</h1>
        <p><em>La Programmation Orientée Objet consiste à faire de son code une représentation d'une entité. Ce n'est pas un outil magique qui va programmer à votre place ou qui va vous épargner du travail, mais une aide à l'organisation de votre code dans le but d'en assurer une meilleure maintenance, d'en facilité les évolutions et la réutilisabilité.<br />La notion "orientée objet" en POO est, à l'instar du quotidien, une représentation virtuelle des objets qui vous entourent pour lesquelles ses caractéristiques (taille, matière, couleur, ...) seraient des variables, et ses fonctionnalités (s'ouvre, s'allume, avance, démarre, ...) seraient des fonctions.<br />Pour comprendre ce concept de programmation et pouvoir l'appliquer, nous allons avoir besoin de nouvelles notions :</em></p>
        <hr />
        <h2>La classe</h2>
        <p><em>Une "classe" en POO est un schéma de construction. Si vous compariez la POO à un chantier de construction d'un lotissement où toutes les maisons sont identiques, la classe serait le plan d'architecte servant de modèle pour les maisons. Puisqu'elles seront toutes identiques, elles seront basées sur le même et unique plan. La classe définirait donc les côtes, les matériaux utilisés et les dispositions des séparations et ouvertures.</em></p>
        <p><em>On définit une classe de la manière suivante :</em></p>
        <pre><code class="php">
&lt;?php
class NomDeLaClasse { // On définit une classe en PHP grâce au mot-clé "class" suivi du nom de la classe.
}
</code></pre>
        <div class="block alert">
            <p><em>Par convention (nous verrons plus tard à quoi va nous servir cette notion de convention) :</em></p>
            <ul>
                <li>Le nom d'une classe
                    <ul>
                        <li>ne possède aucun caractère spécial (accents compris) ou espace,</li>
                        <li>débute toujours par une majuscule,</li>
                        <li>et si son nom est composé de plusieurs mots, chacun d'eux débutera aussi par une majuscule (on appelle ce procédé le "camel case").</li>
                    </ul>
                </li>
                <li>Une classe est une entité regroupant des variables et des fonctions. Puisqu'elle représente l'intégralité de cette entité, une classe sera enregistré dans un fichier qui ne contient qu'elle et qui portera le même nom qu'elle. On retrouve souvent l'extension ".class.php" au fichiers de classe pour bien notifier qu'il s'agit d'une classe.</li>
                <li>Étant dans un fichier à part, une classe ne peut donc être utilisée que si elle est incluse dans le script qui l'utilise (<a href="http://php.net/manual/fr/function.include-once.php" target="_blank">Fonction include_once</a> ou <a href="http://php.net/manual/fr/function.require-once.php" target="_blank">Fonction require_once</a>).</li>
            </ul>
            <p><em>Remarquez aussi que nous n'avons pas fermé la balise d'ouverture de PHP dans notre script de déclaration de la classe. Étant donné que notre fichier ne contiendra que du code PHP, il est possible (et même recommandé par des développeurs expérimentés !) de retirer la balise de fermeture ?&gt; à la fin du fichier. Cela peut paraître surprenant, mais c'est en fait un moyen efficace d'éviter d'insérer des lignes blanches à la fin du code PHP, ce qui a tendance à produire des bogues du type « Headers already sent by ».</em></p>
        </div>
        <hr />
        <h2>L'objet</h2>
        <p><em>Un "objet" en POO est, à l'instar du quotidien, un élément défini par des caractéristiques et des fonctionnalités. Il faut donc le voir comme une représentation virtuelle des objets qui vous entourent pour lesquelles les caractéristiques (taille, matière, couleur, ...) seraient des variables (appelées "<strong>propriétés</strong>" ou aussi "<strong>attributs</strong>" ou "<strong>variables membres</strong>"), et leurs fonctionnalités (s'ouvre, s'allume, avance, démarre, ...) seraient des fonctions (appelées "<strong>méthodes</strong>" ou encore "<strong>fonctions membres</strong>").</em></p>
        <p><em>Un objet est une "<strong>instance</strong>" d'une classe; c'est à dire qu'il est une déclaration unique basée sur le modèle de la classe.<br />Plusieurs objets peuvent donc être des instances d'une même classe. Pour reprendre l'exemple du chantier de construction : nous avons déterminé que la classe représente le plan de chaque maison du lotissement; l'objet représente donc la maison construite selon les caractéristiques du plan, avec les fonctionnalités liées au plan, et avec des valeurs qui lui sont propres (adresse postale de la maison).<br />Chaque maison est donc unique puisqu'elles sont construites sur des parcelles de terrain différentes, mais elles se ressemblent toutes.</em></p>
        <p><em>On instancie un objet de la manière suivante :</em></p>
        <pre><code class="php">
&lt;?php
require_once( 'maclasse.class.php' ); // On inclut la définition de la classe.
$objet = new NomDeLaClasse; // On affecte à la variable "$objet" une nouvelle instance de la classe avec le mot-clé "new". Cette variable est désormais un objet.
</code></pre>
    </body>
</html>