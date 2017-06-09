<?php
/**
 * On définit un tableau d'articles
**/
$_arr_articles = array(
    array( 'titre'=>'Titre 1', 'texte'=>'Texte 1', 'image'=>'assets/img/img.jpg' ), /* Ligne représentant un article (automatiquement stocké à la clé 0) */
    array( 'titre'=>'Titre 2', 'texte'=>'Texte 2', 'image'=>'assets/img/objectif_3w_logo.png' ), /* Ligne représentant un article (automatiquement stocké à la clé 1) */
    array( 'titre'=>'Titre 3', 'texte'=>'Texte 3', 'image'=>'assets/img/picto_O3W.jpg' ), /* Ligne représentant un article (automatiquement stocké à la clé 2) */
    array( 'titre'=>'Titre 4', 'texte'=>'Texte 4', 'image'=>'assets/img/region.jpg' ), /* Ligne représentant un article (automatiquement stocké à la clé 3) */
    array( 'titre'=>'Titre 5', 'texte'=>'Texte 5', 'image'=>'assets/img/volutes.png' ) /* Ligne représentant un article (automatiquement stocké à la clé 4) */
);

shuffle( $_arr_articles ); // On tri de manière aléatoire les articles dans le tableau (http://php.net/manual/fr/function.shuffle.php)

/**
 * On crée un tableau de toutes les organisations possibles
**/
$_arr_dispo = array(
    array('Titre', 'Image', 'Texte'),
    array('Titre', 'Texte', 'Image'),
    array('Texte', 'Titre', 'Image'),
    array('Texte', 'Image', 'Titre'),
    array('Image', 'Texte', 'Titre'),
    array('Image', 'Titre', 'Texte')
);

shuffle($_arr_dispo);

/**
 * Comme les articles sont maintenant mélangés dans le tableau, les 3 premiers articles seront toujours différents.
 * Nous pouvons donc afficher tout le temps les 3 premiers les uns après les autres.
**/
$nbArticles = 3;
for($i = 0; $i < $nbArticles; $i++)
{
    echo '<article>';
    // Pour chaque ligne du tableau _arr_article, on affecte à la variable key la clé en cours de lecture et à la variable value la valeur en cours de lecture,
    foreach( $_arr_dispo[$i] as $item )
    {
        switch( $item )  // En fonction de la clé en cours,
        {
            case 'Titre': // Si cette clé est 'titre',
                echo '<h2>' . $_arr_articles[$i]['titre'] . '</h2>'; // On affiche la balise h2 avec la valeur en cours (soit la valeur contenue à la clé 'titre' dans le tableau _arr_article : $_arr_article['titre']).
                break;
            case 'Texte': // Si cette clé est 'texte',
                echo '<p>' . $_arr_articles[$i]['texte'] . '</p>'; // On affiche la balise p avec la valeur en cours (soit la valeur contenue à la clé 'texte' dans le tableau _arr_article : $_arr_article['texte']).
                break;
            case 'Image': // Si cette clé est 'image',
                echo '<figure><img alt="" src="' . $_arr_articles[$i]['image'] . '" /></figure>'; // On affiche la balise img avec la valeur en cours (soit la valeur contenue à la clé 'image' dans le tableau _arr_article : $_arr_article['image']).
                break;
        }
    }
    echo '</article>';
}






/*
$_arr_articles = array(
    array( 'titre'=>'Titre 1', 'texte'=>'Texte 1', 'image'=>'assets/img/img.jpg' ), // Ligne représentant un article (automatiquement stocké à la clé 0)
    array( 'titre'=>'Titre 2', 'texte'=>'Texte 2', 'image'=>'assets/img/objectif_3w_logo.png' ), // Ligne représentant un article (automatiquement stocké à la clé 1)
    array( 'titre'=>'Titre 3', 'texte'=>'Texte 3', 'image'=>'assets/img/picto_O3W.jpg' ), // Ligne représentant un article (automatiquement stocké à la clé 2)
    array( 'titre'=>'Titre 4', 'texte'=>'Texte 4', 'image'=>'assets/img/region.jpg' ), // Ligne représentant un article (automatiquement stocké à la clé 3)
    array( 'titre'=>'Titre 5', 'texte'=>'Texte 5', 'image'=>'assets/img/volutes.png' ) // Ligne représentant un article (automatiquement stocké à la clé 4)
);


$article = $_arr_articles[rand(0, count($_arr_articles) - 1)];
?>
<article>
    <h2><?php echo $article['titre']; // On affiche le titre du premier article. ?></h2>
    <p><?php echo $article['texte']; // On affiche le texte du premier article. ?></p>
    <figure><img alt="" src="<?php echo $article['image']; // On affiche l'image' du premier article. ?>" /></figure>
</article>

<?php $article = $_arr_articles[rand(0, count($_arr_articles) - 1)]; ?>
<article>
    <h2><?php echo $article['titre']; // On affiche le titre du deuxième article. ?></h2>
    <figure><img alt="" src="<?php echo $article['image']; // On affiche l'image' du deuxième article. ?>" /></figure>
    <p><?php echo $article['texte']; // On affiche le texte du deuxième article. ?></p>
</article>

<?php $article = $_arr_articles[rand(0, count($_arr_articles) - 1)]; ?>
<article>
    <figure><img alt="" src="<?php echo $article['image']; // On affiche l'image' du troisième article. ?>" /></figure>
    <h2><?php echo $article['titre']; // On affiche le titre du troisième article. ?></h2>
    <p><?php echo $article['texte']; // On affiche le texte du troisième article. ?></p>
</article>*/