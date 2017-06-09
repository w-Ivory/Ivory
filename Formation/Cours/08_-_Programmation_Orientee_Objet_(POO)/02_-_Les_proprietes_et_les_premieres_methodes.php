<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0" />
        <title>Les propriétés : la déclaration, les méthodes d'affectation et de récupération</title>

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
        <h1>Les propriétés : la déclaration, les méthodes d'affectation et de récupération</h1>
        <p><em>Les propriétés (aussi appelées "attributs" ou "variables membres") sont le parallèle des variables que nous utilisons en programmation procédurale.<br />De ce fait, les mêmes règles s'appliquent à elles :</em></p>
        <ul style="font-style:italic;">
            <li>la charte de nommage reste la même qu'en algo : ne sont autorisés que les caractères alphanumériques non accentués, les chiffres et le caractère underscore "_"</li>
            <li>le premier caractère pour le nom d'une propriété doit absolument être le symbole dollar "$", suivi d'une lettre</li>
            <li>les propriétés peuvent prendre tous les types de données : les chaînes de caractères (string), les nombres entiers (int), les nombres décimaux (float), les booléens (bool), rien (null), les structures de tableau (array) et même un autre objet.</li>
        </ul>
        <p><em>En revanche comme la valeur d'une propriété va dépendre de l'instance, elle ne peut pas être initialisée à l'écriture de la classe.</em></p>
        <hr />
        <h2>Déclarer une propriété</h2>
        <p><em>Comme nous ne pouvons pas définir la valeur de la propriété dans la classe, nous ne pouvons pas non plus lui attribuer un type.<br />Cependant, la propriété doit pouvoir être accessible dans toute la classe afin d'être manipulée par l'instance. Elle doit donc bien être déclarée au niveau le plus haut de la classe pour que sa portée soit globale dans cette dernière.<br />Comme nous ne pouvons pas lui attribuer de valeur mais que la propriété doit tout de même exister, nous allons donc utiliser un mot-clé (que nous détaillerons plus tard) pour la déclarer.</em></p>
        <pre><code class="php">
&lt;?php
class NomDeLaClasse {
    /**
     * Déclaration de propriétés
    **/
    private $nomDeLaPropriete1;
    private $nomDeLaPropriete2;
    private $nomDeLaPropriete3;
}
</code></pre>
        <p><em>Les propriétés sont donc maintenant déclarées et accessibles partout dans la classe, pour chacune des instances de cette dernière.<br />Cependant comme aucune valeur ne leur a été attribuée, les propriétés sont actuellement nulles.</em></p>
        <hr />
        <h2>Affecter un type et une valeur à une propriété ("setter")</h2>
        <p><em>Nous venons de voir comment réserver un espace dans la mémoire de la machine, via une propriété dans la classe.<br />Cependant, nous ne pouvons pas encore manipuler cet espace en l'état actuel. Pour cela, nous allons devoir créer une méthode qui permettra à un objet d'affecter une valeur à une propriété pour son instance; on appelle cela un "<strong>setter</strong>".<br />Cette méthode est une fonction qui doit être accessible et pour laquelle une convention de nommage est fortement recommandée :</em></p>
        <ul style="font-style:italic;">
            <li>le nom de la méthode commence par le préfixe "set"</li>
            <li>le préfixe est suivi du nom de la propriété, commençant par une majuscule</li>
        </ul>
        <p><em>Comme cette méthode est censée affecter un type et une valeur à la propriété, elle doit pouvoir la récupérer par le biais d'un paramètre.</em></p>
        <p><em>Les setters sont en plus la meilleure solution pour pouvoir mettre en place un comportement sur l'affectation des types et des valeurs à nos propriétés. En effet puisque les méthodes sont des fonctions, nous pouvons les exploiter pour mettre en place des conditions de validation, de la sécurité sur la saisie ou tout autre traitement.</em></p>
        <pre><code class="php">
&lt;?php
class NomDeLaClasse {
    /**
     * Déclaration de propriétés
    **/
    private $nomDeLaPropriete1;
    private $nomDeLaPropriete2;
    private $nomDeLaPropriete3;

    /**
     * Setters : affectation de valeurs aux propriétés.
    **/
    public function setNomDeLaPropriete1( $val ) {
        $this-&gt;nomDeLaPropriete1 = $val;
    }
    public function setNomDeLaPropriete2( $val ) {
        $this-&gt;nomDeLaPropriete2 = $val;
    }
    public function setNomDeLaPropriete3( $val ) {
        $this-&gt;nomDeLaPropriete3 = $val;
    }
}
</code></pre>
        <p><em>Nous incorporons ici une notion de plus dans l'écriture d'une classe : le mot-clé "<strong>$this</strong>".<br />Ce dernier fait référence directement à l'instance de l'objet qui a appelé la méthode qui manipule la propriété. Rappelons-nous que l'écriture d'une classe est le schéma qui permet de créer plusieurs objets, chacun d'eux étant identique dans la structure mais ayant une existance propre et distincte, ce qui signifie que modifier la valeur d'une propriété pour un objet ne doit pas modifier la valeur de la même propriété pour un autre objet.<br />"<strong>$this-></strong>nomDeLaPropriete" fait donc référence à la propriété "$nomDeLaPropriete" pour cet objet, c'est à dire l'objet que nous sommes en train d'utilisé.</em></p>
        <div class="block alert"><strong><u>Attention :</u></strong> le symbôle "$" n'existe plus devant le nom de la propriété, ce dernier étant remplacé par la référence "$this->" !</div>
        <hr />
        <h2>Récupérer la valeur d'une propriété ("getter")</h2>
        <p><em>Au même titre que l'affectation, la récupération d'une valeur n'est pas une manipulation autorisée directement en l'état actuel. Nous allons donc là encore devoir procéder par l'intermédiaire d'une méthode appelée un "<strong>getter</strong>".<br />Cette méthode est une fonction qui doit être accessible et pour laquelle une convention de nommage est fortement recommandée :</em></p>
        <ul style="font-style:italic;">
            <li>le nom de la méthode commence par le préfixe "get"</li>
            <li>le préfixe est suivi du nom de la propriété, commençant par une majuscule</li>
        </ul>
        <pre><code class="php">
&lt;?php
class NomDeLaClasse {
    /**
     * Déclaration de propriétés
    **/
    private $nomDeLaPropriete1;
    private $nomDeLaPropriete2;
    private $nomDeLaPropriete3;

    /**
     * Getters : lecture des valeurs contenues dans les propriétés
    **/
    public function getNomDeLaPropriete1() {
        return $this-&gt;nomDeLaPropriete1;
    }
    public function getNomDeLaPropriete2() {
        return $this-&gt;nomDeLaPropriete2;
    }
    public function getNomDeLaPropriete3() {
        return $this-&gt;nomDeLaPropriete3;
    }
}
</code></pre>
        <hr />
        <h2>Utilisation des setters et des getters</h2>
        <h3>Dans la classe elle-même</h3>
        <p><em>Nous aurons souvent besoin de manipuler nos méthodes dans notre classe elle-même pour telles ou telles raisons.<br />Comme pour nos propriétés, les méthodes sont écrites dans la classe mais manipulées par les instances. Elles doivent donc faire référence à ces dernières grâce au mot-clé "<strong>$this-></strong>".</em></p>
        <p><em>Prenons l'exemple d'une méthode qui permettrait de formater un affichage pour nos données :</em></p>
        <pre><code class="php">
&lt;?php
class NomDeLaClasse {
    /**
     * Déclaration de propriétés
    **/
    private $nomDeLaPropriete1;
    private $nomDeLaPropriete2;
    private $nomDeLaPropriete3;

    /**
     * Getters : lecture des valeurs contenues dans les propriétés
    **/
    public function getNomDeLaPropriete1() {
        return $this-&gt;nomDeLaPropriete1;
    }
    public function getNomDeLaPropriete2() {
        return $this-&gt;nomDeLaPropriete2;
    }
    public function getNomDeLaPropriete3() {
        return $this-&gt;nomDeLaPropriete3;
    }

    /**
     * Méthodes
    **/
    public function show() {
        echo '&lt;ul&gt;
    &lt;li&gt;&lt;u&gt;Propriété 1 :&lt;/u&gt; ' . $this-&gt;getNomDeLaPropriete1() . '&lt;/li&gt;
    &lt;li&gt;&lt;u&gt;Propriété 2 :&lt;/u&gt; ' . $this-&gt;getNomDeLaPropriete2() . '&lt;/li&gt;
    &lt;li&gt;&lt;u&gt;Propriété 3 :&lt;/u&gt; ' . $this-&gt;getNomDeLaPropriete3() . '&lt;/li&gt;
&lt;/ul&gt;';
    }
}
</code></pre>
        <h3>Depuis un objet</h3>
        <p><em>En dehors de la classe, notre seul accès aux méthodes se font par le biais des instances.<br />Nous avons donc besoin d'instancier un objet que nous utiliserons pour appeler les méthodes.</em></p>
        <pre><code class="php">
&lt;?php
require_once( 'maclasse.class.php' ); // On inclut la définition de la classe.
$objet = new NomDeLaClasse; // On affecte à la variable "$objet" une nouvelle instance de la classe avec le mot-clé "new". Cette variable est désormais un objet.

$objet-&gt;setNomDeLaPropriete1( 'Valeur 1' );
$objet-&gt;setNomDeLaPropriete2( 'Valeur 2' );
$objet-&gt;setNomDeLaPropriete3( 'Valeur 3' );

echo '&lt;ul&gt;
    &lt;li&gt;&lt;u&gt;Propriété 1 :&lt;/u&gt; ' . $objet-&gt;getNomDeLaPropriete1() . '&lt;/li&gt;
    &lt;li&gt;&lt;u&gt;Propriété 2 :&lt;/u&gt; ' . $objet-&gt;getNomDeLaPropriete2() . '&lt;/li&gt;
    &lt;li&gt;&lt;u&gt;Propriété 3 :&lt;/u&gt; ' . $objet-&gt;getNomDeLaPropriete3() . '&lt;/li&gt;
&lt;/ul&gt;';
</code></pre>
    </body>
</html>