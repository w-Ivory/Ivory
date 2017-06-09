<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0" />
        <title>Le constructeur et le destructeur</title>

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
        <h1>Le constructeur et le destructeur</h1>
        <p><em>Nous avons vu comment déclarer des propriétés et leur affecter type et valeur par l'intermédiaire des méthodes appelées "setters". Ces dernières nous ont donc permis de manipuler nos propriétés après l'instanciation de nos objets; elles sont donc très utilies pour la mise à jour des valeurs.<br />De nombreux contextes vont nous forcer à fournir des données aux instances dès leur création afin d'initialiser un comportement; alors comment faire puisque nos méthodes nécessitent une instance pour être appelées ?</em></p>
        <hr />
        <h2>L'initialisation de l'instance : le constructeur</h2>
        <p><em>Depuis que nous avons découvert la POO, nous utilisons le mot-clé "<strong>new</strong>".<br />Nous savons que ce mot-clé crée une nouvelle instance d'une classe. Mais qu'est-ce que cela signifie ?</em></p>
        <p><em>Derrière l'instruction "new" se cache 2 événements principaux :</em></p>
        <ul style="font-style:italic;">
            <li>une référence dans la mémoire de la machine</li>
            <li>un appel à une "<strong>méthode magique</strong>" appelée le constructeur : "__construct()"</li>
        </ul>
        <p><em>Par défaut, il n'est pas nécessaire de définir un constructeur dans notre classe; l'instanciation n'exécutera donc rien de particulier.<br />En revanche si nous souhaitons créer un comportement lors de cet événément dans la vie de notre objet, nous pouvons nous-même définir notre constructeur.</em></p>
        <pre><code class="php">
&lt;?php
class NomDeLaClasse {
    /**
     * Constructeur de la classe
    **/
    public function __construct() {
        echo 'Bonjour !';
    }
}
</code></pre>
        <div class="block alert">Le nom de la méthode doit toujours être "__construct". C'est grâce à cette convention que la méthode peut être appelée automatiquement par PHP lors de l'instanciation et devient donc une "méthode magique".</div>
        <p><em>Le constructeur, associé avec nos setters, peut donc se révéler très utile si nous souhaitons affecter des valeurs à nos propriétés dès l'instanciation.<br />Dans ce cas, notre constructeur devra être capable de récupérer nos valeurs par l'intermédiaire de paramètres. Le fait d'indiquer des paramètres à faire passer au constructeur implique donc aussi de faire passer ces valeurs lors de l'instanciation :</em></p>
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
     * Constructeur de la classe
    **/
    public function __construct( $val1, $val2, $val3 ) {
        $this-&gt;setNomDeLaPropriete1( $val1 );
        $this-&gt;setNomDeLaPropriete2( $val2 );
        $this-&gt;setNomDeLaPropriete3( $val3 );
    }

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

$objet = new NomDeLaClasse( 'Valeur 1', 'Valeur 2', 'Valeur 3' );

echo '&lt;ul&gt;
    &lt;li&gt;&lt;u&gt;Propriété 1 :&lt;/u&gt; ' . $objet-&gt;getNomDeLaPropriete1() . '&lt;/li&gt;
    &lt;li&gt;&lt;u&gt;Propriété 2 :&lt;/u&gt; ' . $objet-&gt;getNomDeLaPropriete2() . '&lt;/li&gt;
    &lt;li&gt;&lt;u&gt;Propriété 3 :&lt;/u&gt; ' . $objet-&gt;getNomDeLaPropriete3() . '&lt;/li&gt;
&lt;/ul&gt;';
</code></pre>
        <hr />
        <h2>La fin de l'utilisation de l'instance : le destructeur</h2>
        <p><em>Nous venons de constater qu'il était possible d'automatiser des traitements à la construction de notre instance.<br />Il peut parfois nous être utile aussi de faire la même chose lorsque l'on n'a plus besoin d'utiliser notre instance (comme libérer de la mémoire, vider une table temporaire en base de données, enchainer avec un nouveau type de traitement, ...).<br />Pour cela il existe une autre "méthode magique" appelée le destructeur : "__destruct()"</em></p>
        <pre><code class="php">
&lt;?php
class NomDeLaClasse {
    /**
     * Destructeur de la classe
    **/
    public function __destruct() {
        echo 'Au revoir';
    }
}
</code></pre>
        <p><em>Nous constatons en l'utilisant que le destructeur est appelé par défaut par PHP lorsque ce dernier est sûr et certain que l'instance n'est plus utilisée; c'est à dire à la fin du script.<br />Nous pouvons néanmoins indiquer par nous-même quand l'instance ne nous est plus utile en détruisant notre objet. Pour cela, nous utiliserons une fonction que nous connaissons déjà : "<strong>unset</strong>"</em></p>
        <pre><code class="php">
&lt;?php
class NomDeLaClasse {
    /**
     * Destructeur de la classe
    **/
    public function __destruct() {
        echo 'Au revoir';
    }
}

$objet = new NomDeLaClasse;
unset( $objet ); // On détruit l'objet, ce qui aura pour effet de déclencher l'appel du destructeur de la classe.
</code></pre>
    </body>
</html>