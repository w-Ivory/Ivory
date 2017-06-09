<?php
// Définition du title de la page.
$metaTitle = 'Le partitionnement et l\'inclusion de pages';
// Définition du titre principal de la page.
$pageTitle = $metaTitle;

// Inclusion du fichier contenant l'en-tête de la page
include('inc/header.php');
?>
        <p><em>En PHP, nous pouvons facilement insérer d'autres pages (on peut aussi insérer seulement des morceaux de pages) à l'intérieur d'une page. Cela va nous permettre de centraliser des morceaux de codes que l'on peut trouver sur plusieurs pages et ainsi simplifier notre maintenance.</em></p>
        <pre><code class="php">
&lt;?php include('inc/header.php'); ?&gt;
&lt;?php include('inc/footer.html'); ?&gt;
</code></pre>

<?php include('inc/footer.html'); ?>