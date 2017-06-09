<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0" />
        <title>Le passage de données</title>

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
        <h1>Le passage de données</h1>
        <p><em>URL (Uniform Resource Locator) : représente une adresse sur le web. C'est la cible d'un lien.</em></p>
        <p class="block alert"><em>Que vous utilisiez l'une ou l'autre des méthodes décrites ci-dessous, pensez à toujours faire des tests sur l'existence ET sur la validité des données que vous recevrez car elles seront le plus souvent passées depuis une saisie utilisateur ... donc il faut anticiper sur l'étourderie et la bêtise humaine.</em></p>
        <hr />
        <h2>Avec la méthode GET</h2>
        <h3>Via l'URL d'une page</h3>
        <p><em>L'envoi de paramètres dans l'URL se décompose en plusieurs morceaux :</em></p>
        <ol>
            <li>l'ajout d'un point d'interrogation après le nom de la page : spécifie que l'on va faire passer des paramètres dans l'URL,</li>
            <li>une chaîne de caractère correspondant à la clé servant de repère pour identifier la valeur,</li>
            <li>le symbole égal pour associer cette clé à une valeur,</li>
            <li>la valeur à transmettre,</li>
            <li>optionnellement l'esperluette pour séparé la transmission d'une autre valeur.</li>
        </ol>
        <p><em>En résumé : page.php?cle1=valeur1&cle2=valeur2&...&clen=valeurn</em></p>
        <p><em>La récupération de ces valeur se fait via une variable de type tableau dite "superglobale" : $_GET, où chaque association clé => valeur passée est récupérée.</em></p>
        <div id="get-lien">
            <a href="08_-_Le_passage_de_donnees/08_-_Le_passage_de_donnees_-_page_2.php?prenom=Hassen&nom=CEEF" title="">Lien avec envoi de paramètres dans l'URL</a>
        </div>
        <pre><code class="html">
&lt;!-- // On transmet via l'URL la valeur "Hassen" à la clé "prenom" ET la valeur "CEEF" à la clé "nom". --&gt;
&lt;a href="page_de_traitement.php?prenom=Hassen&nom=CEEF" title=""&gt;Lien avec envoi de paramètres dans l'URL&lt;/a&gt;</code>
<code class="php">
&lt;?php
/**
 * La superglobale $_GET n'est donc plus un tableau vide mais est de la forme :
 *     $_GET = array(
 *         'prenom' => 'Hassen',
 *         'nom'    => 'CEEF'
 *     );
**/
if( isset( $_GET ) && array_key_exists( 'prenom', $_GET ) && array_key_exists( 'nom', $_GET ) ) : // On teste l'existence des données
    echo 'Bonjour';
    if( isset( $_GET ) && array_key_exists( 'prenom', $_GET ) ) echo ' ' . $_GET['prenom'];
    if( isset( $_GET ) && array_key_exists( 'nom', $_GET ) ) echo ' ' . $_GET['nom'];
    echo ' ! ';
else :
    echo 'Aucune donnée de nom et prénom n\'a été passée !';
endif;
?&gt;</code></pre>
        <p class="block alert"><em>La superglobale "$_GET" est déclarée par défaut dans toutes les pages PHP comme un tableau vide et se remplit via les données passées dans l'URL.</em></p>
        <h3>Via un formulaire</h3>
        <p><em>Nous venons de voir que la méthode "GET" nous permet de faire passer une association clé/valeur entre deux pages mais uniquement via des données déjà codées.<br />Afin de permettre une saisie utilisateur, nous allons avoir besoin de créer un formulaire de saisie en HTML.</em></p>
        <h4>Déclarer un bloc de formulaire</h4>
        <p><em>Pour insérer un formulaire en HTML, on se sert de la balise "&lt;form&gt;".<br />Parmi plusieurs attributs, deux sont essentiels :</em></p>
        <ul style="font-style:italic;">
            <li><strong>action</strong> : indique la page dans laquelle se trouve le code PHP qui va traiter notre saisie. Par défaut si la valeur est vide, le formulaire va recharger la page courante.</li>
            <li><strong>method</strong> : définit la méthode de transmission des données.</li>
        </ul>
        <pre><code class="html">
&lt;form action="page_de_traitement.php" method="GET"&gt;
    <!--
    // Intérieur du formulaire
    -->
&lt;/form&gt;
</code></pre>
        <h4>Les éléments de formulaire</h4>
        <p><em>Le HTML5 propose un grand choix d'éléments de formulaire ayant chacun un rôle précis. Vous en trouverez la liste complète ainsi que tous les attributs possibles sur le site du W3C (<a href="http://www.w3.org/TR/html5/forms.html" target="_blank" title="">www.w3.org/TR/html5/forms.html</a> ou de la W3School (<a href="http://www.w3schools.com/html/html_forms.asp" target="_blank" title="">www.w3schools.com/html/html_forms.asp</a>).<br />Dans un premier temps, nous n'allons nous intéresser qu'aux plus récurrents :</em></p>
        <ul style="font-style:italic;">
            <li><strong>&lt;label for="id_du_champ_cible"&gt;&lt;/label&gt;</strong><br />libellé textuel permettant de titrer un élément de saisie pour indiquer ce qui est attendu. L'attribut "for" permet de cibler un élément de saisie via son attribut "id".</li>
            <li><strong>&lt;input&gt;</strong><br />champ de saisie
                <ul>
                    <li><strong>&lt;input name="nom_du_champ_texte" type="text" value="" /&gt;</strong><br />l'attribut "type" indique une saisie textuelle (alphanumérique) lorsqu'on lui attribue la valeur "text". Sa valeur par défaut est une chaîne de caractères vide.</li>
                    <li><strong>&lt;input min="0" max="100" name="nom_du_champ_numerique" step="10" type="number" value="" /&gt;</strong><br />l'attribut "type" indique une saisie numérique lorsqu'on lui attribue la valeur "number". Sa valeur par défaut est une chaîne de caractères vide. On peut lui attribuer des limites avec les attributs "min" et "max", ainsi qu'un pas de progression avec l'attribut "step".</li>
                    <li><strong>&lt;input name="nom_du_champ_passe" type="password" value="" /&gt;</strong><br />l'attribut "type" indique une saisie masquée lorsqu'on lui attribue la valeur "password".</li>
                    <li><strong>&lt;input name="nom_du_champ_tel" type="tel" value="" /&gt;</strong><br />l'attribut "type" indique une saisie de numéro de téléphone lorsqu'on lui attribue la valeur "tel". Les navigateurs comprenant le HTML5 vont donc effectuer un test de format de saisie avant de soumettre le formulaire.</li>
                    <li><strong>&lt;input name="nom_du_champ_email" type="email" value="" /&gt;</strong><br />l'attribut "type" indique une saisie d'adresse email lorsqu'on lui attribue la valeur "email". Les navigateurs comprenant le HTML5 vont donc effectuer un test de format de saisie avant de soumettre le formulaire.</li>
                    <li><strong>&lt;input name="nom_du_champ_url" type="url" value="" /&gt;</strong><br />l'attribut "type" indique une saisie d'URL lorsqu'on lui attribue la valeur "url". Les navigateurs comprenant le HTML5 vont donc effectuer un test de format de saisie avant de soumettre le formulaire.</li>
                    <li><strong>&lt;input name="nom_du_champ_date" type="date" value="" /&gt;</strong><br />l'attribut "type" indique une saisie de date lorsqu'on lui attribue la valeur "date". Les navigateurs comprenant le HTML5 vont donc effectuer un test de format de saisie avant de soumettre le formulaire. Ils vont aussi afficher un champ qui aura un masque de saisie et la possibilité d'ouvrir un calendrier.</li>
                    <li><strong>&lt;input name="nom_du_champ_heure" type="time" value="" /&gt;</strong><br />l'attribut "type" indique une saisie d'heure lorsqu'on lui attribue la valeur "time". Les navigateurs comprenant le HTML5 vont donc effectuer un test de format de saisie avant de soumettre le formulaire. Ils vont aussi afficher un champ qui aura un masque de saisie.</li>
                    <li><strong>&lt;input min="0" max="100" name="nom_du_champ_range" step="10" type="range" value="" /&gt;</strong><br />l'attribut "type" indique une saisie d'heure lorsqu'on lui attribue la valeur "range". On peut lui attribuer des limites avec les attributs "min" et "max", ainsi qu'un pas de progression avec l'attribut "step". Les navigateurs comprenant le HTML5 vont donc effectuer un test de format de saisie avant de soumettre le formulaire. Ils vont aussi afficher un champ qui sera un curseur à faire glisser.</li>
                    <li><strong>&lt;input name="nom_du_champ_couleur" type="color" value="" /&gt;</strong><br />l'attribut "type" indique une saisie d'heure lorsqu'on lui attribue la valeur "color". Les navigateurs comprenant le HTML5 vont donc effectuer un test de format de saisie avant de soumettre le formulaire. Ils vont aussi afficher un sélecteur de couleur.</li>
                    <li><strong>&lt;input name="nom_du_champ_cache" type="hidden" value="" /&gt;</strong><br />l'attribut "type" indique un champ caché (donc invisible dans le formulaire) lorsqu'on lui attribue la valeur "hidden".</li>
                </ul>
            </li>
            <li><strong>&lt;textarea name="nom_du_champ_long"&gt;&lt;/textarea&gt;</strong><br />champ de saisie pour les textes longs avec retour à la ligne possible.</li>
            <li><strong>&lt;select name="nom_de_la_liste_de_choix"&gt;<br />&nbsp;&nbsp;&nbsp;&nbsp;&lt;option value=""&gt;&lt;/option&gt;<br />&lt;/select&gt;</strong><br />liste de choix.<br />Cette balise permet de proposer plusieurs choix grâce à la balise "&lt;option&gt;" (une balise "option" par choix). L'attribut "value" de la balise "option" permet de spécifier une valeur différente de celle qui s'affiche à l'écran (le texte compris entre la balise ouvrante et la balise fermante).<br />On peut sélectionner un choix par défaut en lui ajoutant l'attribut "selected".</li>
            <li><strong>&lt;input&gt;</strong><br />champ de sélection
                <ul>
                    <li><strong>&lt;input name="nom_du_champ_choix_unique" type="radio" value="" /&gt;</strong><br />La balise input de type "radio" s'utilise au minimum par paire. En associant le même nom (name) à plusieurs balises "input" de type "radio", ces dernières se retrouvent liées et seule un choix à la fois est possible.</li>
                    <li><strong>&lt;input name="nom_du_champ_choix_multiple" type="checkbox" value="" /&gt;</strong><br />En associant le même nom (name) à plusieurs balises "input" de type "checkbox", ces dernières se retrouvent liées. En ajoutant une paire de crochet au nom, on crée un tableau qui va rassembler toutes la valeurs des "input" de type "checkbok" portant ce nom.</li>
                </ul>
                On peut initialiser une case à l'état coché en lui ajoutant l'attribut "checked".
            </li>
            <li><strong>&lt;input type="submit" value="" /&gt;</strong><br />bouton de soumission du formulaire. L'attribut "value" correspond au texte affiché dans le bouton.</li>
        </ul>
        <p><em>La méthode de récupération des données est la même que via l'URL. L'association clé/valeur se fait avec le nom du champ contenu dans l'attribut "name" (clé) et la valeur saisie qui est attribuée à "value".</em></p>
        <p class="block alert"><em>Attention à la compatibilité ! Certains navigateurs ne comprennent pas encore tous les types de champ issus du HTML5 et leur comportement peut varier de l'un à l'autre. Assurez-vous donc toujours en PHP de l'intégrité des données reçues.</em></p>
        <style type="text/css">
            <!--
            #get-frm label {
                display:block;
                padding:5px 0;
            }
            #get-frm label.inline { display:inline-block; }
            -->
        </style>
        <div id="get-frm">
            <form action="08_-_Le_passage_de_donnees/08_-_Le_passage_de_donnees_-_page_2.php" method="GET" style="-webkit-columns:2;-moz-columns:2;columns:2;vertical-align:top;">
                <label for="nom">Chaîne de caractère :</label>
                <input id="nom" name="txt-nom" type="text" value="" />
                <label for="password">Mot de passe :</label>
                <input id="password" name="txt-password" type="password" value="" />
                <label for="tel">Téléphone :</label>
                <input id="tel" name="txt-tel" type="tel" value="" />
                <label for="email">Email :</label>
                <input id="email" name="txt-email" type="email" value="" />
                <label for="url">URL :</label>
                <input id="url" name="txt-url" type="url" value="" />
                <label for="number">Nombre :</label>
                <input id="number" min="0" max="100" name="txt-number" step="10" type="number" value="" />
                <label for="date">Date :</label>
                <input id="date" name="txt-date" type="date" value="" />
                <label for="time">Heure :</label>
                <input id="time" name="txt-time" type="time" value="" />
                <label for="range">Gamme :</label>
                <input id="range" min="0" max="100" name="txt-range" step="10" type="range" value="" />
                <label for="color">Couleur :</label>
                <input id="color" name="txt-color" type="color" value="#000000" />
                <br />
                <input id="hidden" name="txt-hidden" type="hidden" value="Valeur de champs caché" />
                <br />
                <label for="text">Bloc de texte :</label>
                <textarea id="text" name="txt-text" cols="50" rows="6">Lorem ipsum dolor sit amet

Nullam sit amet molestie nisl, nec tempus tellus. Suspendisse commodo tellus eget cursus consequat. Nulla sit amet mauris vel mauris tincidunt finibus non at erat. Nam commodo tortor id tempor lacinia. Nulla commodo, mi nec cursus lobortis, tortor urna posuere tortor, vel elementum nibh justo in quam. Fusce imperdiet rhoncus facilisis. Maecenas pretium malesuada magna posuere ultricies. Pellentesque sed pellentesque libero. Integer mauris metus, faucibus at magna ac, ultrices finibus est. Fusce suscipit sed augue quis congue. Mauris auctor odio sit amet feugiat maximus. Sed dui neque, aliquam nec arcu a, vulputate tempus tellus. Donec ut ex et enim gravida sagittis at sed mauris.</textarea>
                <br />
                <label for="list">Liste de sélection :</label>
                <select name="list">
                    <option value="1">Choix 1</option>
                    <option value="2">Choix 2</option>
                    <option value="3">Choix 3</option>
                </select>
                <br />
                <label class="inline">Êtes-vous d'accord ?</label>
                <input id="radioOui" name="radio" type="radio" value="Oui" /><label class="inline" for="radioOui">Oui</label> / <input checked="checked" id="radioNon" name="radio" type="radio" value="Non" /><label class="inline" for="radioNon">Non</label>
                <br />
                <label>Choix à cocher :</label>
                <input id="chk1" name="chk[]" type="checkbox" value="1" /><label class="inline" for="chk1">Choix 1</label> / <input id="chk2" name="chk[]" type="checkbox" value="2" /><label class="inline" for="chk2">Choix 2</label> / <input id="chk3" name="chk[]" type="checkbox" value="3" /><label class="inline" for="chk3">Choix 3</label> / <input id="chk4" name="chk[]" type="checkbox" value="4" /><label class="inline" for="chk4">Choix 4</label>
                <br />
                <input type="submit" value="Soumettre le formulaire" />
            </form>
        </div>
        <pre><code class="html">
&lt;form action="page_de_traitement.php" method="GET"&gt;
    &lt;label for="nom"&gt;Chaîne de caractère :&lt;/label&gt;
    &lt;input id="nom" name="txt-nom" type="text" value="" /&gt;
    &lt;label for="password"&gt;Mot de passe :&lt;/label&gt;
    &lt;input id="password" name="txt-password" type="password" value="" /&gt;
    &lt;label for="tel"&gt;Téléphone :&lt;/label&gt;
    &lt;input id="tel" name="txt-tel" type="tel" value="" /&gt;
    &lt;label for="email"&gt;Email :&lt;/label&gt;
    &lt;input id="email" name="txt-email" type="email" value="" /&gt;
    &lt;label for="url"&gt;URL :&lt;/label&gt;
    &lt;input id="url" name="txt-url" type="url" value="" /&gt;
    &lt;label for="number"&gt;Nombre :&lt;/label&gt;
    &lt;input id="number" min="0" max="100" name="txt-number" step="10" type="number" value="" /&gt;
    &lt;label for="date"&gt;Date :&lt;/label&gt;
    &lt;input id="date" name="txt-date" type="date" value="" /&gt;
    &lt;label for="time"&gt;Heure :&lt;/label&gt;
    &lt;input id="time" name="txt-time" type="time" value="" /&gt;
    &lt;label for="range"&gt;Gamme :&lt;/label&gt;
    &lt;input id="range" min="0" max="100" name="txt-range" step="10" type="range" value="" /&gt;
    &lt;label for="color"&gt;Couleur :&lt;/label&gt;
    &lt;input id="color" name="txt-color" type="color" value="" /&gt;
    &lt;br /&gt;
    &lt;input id="hidden" name="txt-hidden" type="hidden" value="" /&gt;
    &lt;br /&gt;
    &lt;label for="text"&gt;Bloc de texte :&lt;/label&gt;
    &lt;textarea id="text" name="txt-text" cols="50" rows="6"&gt;Lorem ipsum dolor sit amet

Nullam sit amet molestie nisl, nec tempus tellus. Suspendisse commodo tellus eget cursus consequat. Nulla sit amet mauris vel mauris tincidunt finibus non at erat. Nam commodo tortor id tempor lacinia. Nulla commodo, mi nec cursus lobortis, tortor urna posuere tortor, vel elementum nibh justo in quam. Fusce imperdiet rhoncus facilisis. Maecenas pretium malesuada magna posuere ultricies. Pellentesque sed pellentesque libero. Integer mauris metus, faucibus at magna ac, ultrices finibus est. Fusce suscipit sed augue quis congue. Mauris auctor odio sit amet feugiat maximus. Sed dui neque, aliquam nec arcu a, vulputate tempus tellus. Donec ut ex et enim gravida sagittis at sed mauris.&lt;/textarea&gt;
    &lt;br /&gt;
    &lt;label for="list"&gt;Liste de sélection :&lt;/label&gt;
    &lt;select name="list"&gt;
        &lt;option value="1"&gt;Choix 1&lt;/option&gt;
        &lt;option value="2"&gt;Choix 2&lt;/option&gt;
        &lt;option value="3"&gt;Choix 3&lt;/option&gt;
    &lt;/select&gt;
    &lt;br /&gt;
    &lt;label class="inline"&gt;Êtes-vous d'accord ?&lt;/label&gt;
    &lt;input id="radioOui" name="radio" type="radio" value="Oui" /&gt;&lt;label class="inline" for="radioOui"&gt;Oui&lt;/label&gt; / &lt;input checked="checked" id="radioNon" name="radio" type="radio" value="Non" /&gt;&lt;label class="inline" for="radioNon"&gt;Non&lt;/label&gt;
    &lt;br /&gt;
    &lt;label&gt;Choix à cocher :&lt;/label&gt;
    &lt;input id="chk1" name="chk[]" type="checkbox" value="1" /&gt;&lt;label class="inline" for="chk1"&gt;Choix 1&lt;/label&gt; / &lt;input id="chk2" name="chk[]" type="checkbox" value="2" /&gt;&lt;label class="inline" for="chk2"&gt;Choix 2&lt;/label&gt; / &lt;input id="chk3" name="chk[]" type="checkbox" value="3" /&gt;&lt;label class="inline" for="chk3"&gt;Choix 3&lt;/label&gt; / &lt;input id="chk4" name="chk[]" type="checkbox" value="4" /&gt;&lt;label class="inline" for="chk4"&gt;Choix 4&lt;/label&gt;
    &lt;br /&gt;
    &lt;input type="submit" value="Soumettre le formulaire" /&gt;
&lt;/form&gt;</code></pre>
        <hr />
        <h2>Avec la méthode POST</h2>
        <p><em>La méthode "POST" ne fonctionne que via une soummission de formulaire. Elle se base sur le même principe que la méthode "GET", à la seule différence qu'elle ne transmet plus les données de manière visible dans l'URL mais de manière invisible.</em></p>
        <p class="block alert"><em>ATTENTION car invisible ne veut pas dire inviolable. Ce n'est pas parce que nous ne voyons plus passer les données que ces dernières ne peuvent pas être interceptées par un logiciel espion et détournées.</em></p>
        <style type="text/css">
            <!--
            #post-frm label {
                display:block;
                padding:5px 0;
            }
            #post-frm label.inline { display:inline-block; }
            -->
        </style>
        <div id="post-frm">
            <form action="08_-_Le_passage_de_donnees/08_-_Le_passage_de_donnees_-_page_2.php" method="POST" style="-webkit-columns:2;-moz-columns:2;columns:2;vertical-align:top;">
                <label for="nom">Chaîne de caractère :</label>
                <input id="nom" name="txt-nom" type="text" value="" />
                <label for="password">Mot de passe :</label>
                <input id="password" name="txt-password" type="password" value="" />
                <label for="tel">Téléphone :</label>
                <input id="tel" name="txt-tel" type="tel" value="" />
                <label for="email">Email :</label>
                <input id="email" name="txt-email" type="email" value="" />
                <label for="url">URL :</label>
                <input id="url" name="txt-url" type="url" value="" />
                <label for="number">Nombre :</label>
                <input id="number" min="0" max="100" name="txt-number" step="10" type="number" value="" />
                <label for="date">Date :</label>
                <input id="date" name="txt-date" type="date" value="" />
                <label for="time">Heure :</label>
                <input id="time" name="txt-time" type="time" value="" />
                <label for="range">Gamme :</label>
                <input id="range" min="0" max="100" name="txt-range" step="10" type="range" value="" />
                <label for="color">Couleur :</label>
                <input id="color" name="txt-color" type="color" value="#000000" />
                <br />
                <input id="hidden" name="txt-hidden" type="hidden" value="Valeur de champs caché" />
                <br />
                <label for="text">Bloc de texte :</label>
                <textarea id="text" name="txt-text" cols="50" rows="6">Lorem ipsum dolor sit amet

Nullam sit amet molestie nisl, nec tempus tellus. Suspendisse commodo tellus eget cursus consequat. Nulla sit amet mauris vel mauris tincidunt finibus non at erat. Nam commodo tortor id tempor lacinia. Nulla commodo, mi nec cursus lobortis, tortor urna posuere tortor, vel elementum nibh justo in quam. Fusce imperdiet rhoncus facilisis. Maecenas pretium malesuada magna posuere ultricies. Pellentesque sed pellentesque libero. Integer mauris metus, faucibus at magna ac, ultrices finibus est. Fusce suscipit sed augue quis congue. Mauris auctor odio sit amet feugiat maximus. Sed dui neque, aliquam nec arcu a, vulputate tempus tellus. Donec ut ex et enim gravida sagittis at sed mauris.</textarea>
                <br />
                <label for="list">Liste de sélection :</label>
                <select name="list">
                    <option value="1">Choix 1</option>
                    <option value="2">Choix 2</option>
                    <option value="3">Choix 3</option>
                </select>
                <br />
                <label class="inline">Êtes-vous d'accord ?</label>
                <input id="radioOui" name="radio" type="radio" value="Oui" /><label class="inline" for="radioOui">Oui</label> / <input checked="checked" id="radioNon" name="radio" type="radio" value="Non" /><label class="inline" for="radioNon">Non</label>
                <br />
                <label>Choix à cocher :</label>
                <input id="chk1" name="chk[]" type="checkbox" value="1" /><label class="inline" for="chk1">Choix 1</label> / <input id="chk2" name="chk[]" type="checkbox" value="2" /><label class="inline" for="chk2">Choix 2</label> / <input id="chk3" name="chk[]" type="checkbox" value="3" /><label class="inline" for="chk3">Choix 3</label> / <input id="chk4" name="chk[]" type="checkbox" value="4" /><label class="inline" for="chk4">Choix 4</label>
                <br />
                <input type="submit" value="Soumettre le formulaire" />
            </form>
        </div>
        <pre><code class="html">
&lt;form action="page_de_traitement.php" method="POST"&gt;
    &lt;label for="nom"&gt;Chaîne de caractère :&lt;/label&gt;
    &lt;input id="nom" name="txt-nom" type="text" value="" /&gt;
    &lt;label for="password"&gt;Mot de passe :&lt;/label&gt;
    &lt;input id="password" name="txt-password" type="password" value="" /&gt;
    &lt;label for="tel"&gt;Téléphone :&lt;/label&gt;
    &lt;input id="tel" name="txt-tel" type="tel" value="" /&gt;
    &lt;label for="email"&gt;Email :&lt;/label&gt;
    &lt;input id="email" name="txt-email" type="email" value="" /&gt;
    &lt;label for="url"&gt;URL :&lt;/label&gt;
    &lt;input id="url" name="txt-url" type="url" value="" /&gt;
    &lt;label for="number"&gt;Nombre :&lt;/label&gt;
    &lt;input id="number" min="0" max="100" name="txt-number" step="10" type="number" value="" /&gt;
    &lt;label for="date"&gt;Date :&lt;/label&gt;
    &lt;input id="date" name="txt-date" type="date" value="" /&gt;
    &lt;label for="time"&gt;Heure :&lt;/label&gt;
    &lt;input id="time" name="txt-time" type="time" value="" /&gt;
    &lt;label for="range"&gt;Gamme :&lt;/label&gt;
    &lt;input id="range" min="0" max="100" name="txt-range" step="10" type="range" value="" /&gt;
    &lt;label for="color"&gt;Couleur :&lt;/label&gt;
    &lt;input id="color" name="txt-color" type="color" value="" /&gt;
    &lt;br /&gt;
    &lt;input id="hidden" name="txt-hidden" type="hidden" value="" /&gt;
    &lt;br /&gt;
    &lt;label for="text"&gt;Bloc de texte :&lt;/label&gt;
    &lt;textarea id="text" name="txt-text" cols="50" rows="6"&gt;Lorem ipsum dolor sit amet

Nullam sit amet molestie nisl, nec tempus tellus. Suspendisse commodo tellus eget cursus consequat. Nulla sit amet mauris vel mauris tincidunt finibus non at erat. Nam commodo tortor id tempor lacinia. Nulla commodo, mi nec cursus lobortis, tortor urna posuere tortor, vel elementum nibh justo in quam. Fusce imperdiet rhoncus facilisis. Maecenas pretium malesuada magna posuere ultricies. Pellentesque sed pellentesque libero. Integer mauris metus, faucibus at magna ac, ultrices finibus est. Fusce suscipit sed augue quis congue. Mauris auctor odio sit amet feugiat maximus. Sed dui neque, aliquam nec arcu a, vulputate tempus tellus. Donec ut ex et enim gravida sagittis at sed mauris.&lt;/textarea&gt;
    &lt;br /&gt;
    &lt;label for="list"&gt;Liste de sélection :&lt;/label&gt;
    &lt;select name="list"&gt;
        &lt;option value="1"&gt;Choix 1&lt;/option&gt;
        &lt;option value="2"&gt;Choix 2&lt;/option&gt;
        &lt;option value="3"&gt;Choix 3&lt;/option&gt;
    &lt;/select&gt;
    &lt;br /&gt;
    &lt;label class="inline"&gt;Êtes-vous d'accord ?&lt;/label&gt;
    &lt;input id="radioOui" name="radio" type="radio" value="Oui" /&gt;&lt;label class="inline" for="radioOui"&gt;Oui&lt;/label&gt; / &lt;input checked="checked" id="radioNon" name="radio" type="radio" value="Non" /&gt;&lt;label class="inline" for="radioNon"&gt;Non&lt;/label&gt;
    &lt;br /&gt;
    &lt;label&gt;Choix à cocher :&lt;/label&gt;
    &lt;input id="chk1" name="chk[]" type="checkbox" value="1" /&gt;&lt;label class="inline" for="chk1"&gt;Choix 1&lt;/label&gt; / &lt;input id="chk2" name="chk[]" type="checkbox" value="2" /&gt;&lt;label class="inline" for="chk2"&gt;Choix 2&lt;/label&gt; / &lt;input id="chk3" name="chk[]" type="checkbox" value="3" /&gt;&lt;label class="inline" for="chk3"&gt;Choix 3&lt;/label&gt; / &lt;input id="chk4" name="chk[]" type="checkbox" value="4" /&gt;&lt;label class="inline" for="chk4"&gt;Choix 4&lt;/label&gt;
    &lt;br /&gt;
    &lt;input type="submit" value="Soumettre le formulaire" /&gt;
&lt;/form&gt;</code></pre>
        <hr />
        <h2>Sécuriser les formulaires PHP : htmlentities()</h2>
        <p><em>Que ce soit par la méthode "GET" ou la méthode "POST", nous avons déjà dit que les données pouvaient être interceptées. De ce fait, l'utilisation d'un formulaire peut présenter plusieurs <strong>failles de sécurité</strong> dont la plus connues est la faille XSS (Cross Site Scripting) qui consiste à faire passer un script via un champs de formulaire, script qui sera ensuite interprété par la page de traitement en PHP.<br />Outre le fait de tester l'existence (présence de la clé dans le tableau) et l'intégrité (respect du type de donnée attendu) des données, nous allons maintenant utiliser une fonction PHP prête à l'emploi qui va empêcher l'interprétation des symboles délimitant du code à la réception des données.</em></p>
        <p><em>Essayez de passer le script suivant : <br />&lt;script&gt;alert('Vous venez de vous faire hacker !');&lt;/script&gt;</em></p>
        <p class="block alert"><em>La plupart des navigateurs récents gèrent les failles XSS ... MAIS CE N'EST PAS LE CAS DE TOUS !!!<br />Afin de tester, vous pouvez désactiver la protection dans Firefox en allant sur l'URL "about:config" puis en tapant dans la barre de recherche "urlbar.filter". Un double clic sur la ligne fera passer le paramètre à false et désactivera laprotection contre les failles XSS.</em></p>
        <style type="text/css">
            <!--
            #htmlentities-frm label {
                display:block;
                padding:5px 0;
            }
            #htmlentities-frm label.inline { display:inline-block; }
            -->
        </style>
        <div id="htmlentities-frm">
            <form action="08_-_Le_passage_de_donnees/08_-_Le_passage_de_donnees_-_page_2.php" method="POST" style="-webkit-columns:2;-moz-columns:2;columns:2;vertical-align:top;">
                <label for="htmlentities">Chaîne de caractère :</label>
                <input id="htmlentities" name="txt-htmlentities" type="text" value="" />
                <br />
                <label class="inline">Activer l'htmlentities ?</label>
                <input id="htmlentitiesOui" name="radio-htmlentities" type="radio" value="Oui" /><label class="inline" for="htmlentitiesOui">Oui</label> / <input checked="checked" id="htmlentitiesNon" name="radio-htmlentities" type="radio" value="Non" /><label class="inline" for="htmlentitiesNon">Non</label>
                <br />
                <input type="submit" value="Soumettre le formulaire" />
            </form>
        </div>
        <pre><code class="html">
&lt;form action="page_de_traitement.php" method="POST"&gt;
    &lt;label for="htmlentities"&gt;Chaîne de caractère :&lt;/label&gt;
    &lt;input id="htmlentities" name="txt-htmlentities" type="text" value="" /&gt;
    &lt;br /&gt;
    &lt;label class="inline"&gt;Activer l'htmlentities ?&lt;/label&gt;
    &lt;input id="htmlentitiesOui" name="radio-htmlentities" type="radio" value="Oui" /&gt;&lt;label class="inline" for="htmlentitiesOui"&gt;Oui&lt;/label&gt; / &lt;input checked="checked" id="htmlentitiesNon" name="radio-htmlentities" type="radio" value="Non" /&gt;&lt;label class="inline" for="htmlentitiesNon"&gt;Non&lt;/label&gt;
    &lt;br /&gt;
    &lt;input type="submit" value="Soumettre le formulaire" /&gt;
&lt;/form&gt;</code></pre>
    </body>
</html>