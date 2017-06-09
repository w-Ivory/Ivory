<?php
session_start();
session_destroy();

$_SESSION['bla'] = 'blabla';
?>

<a href="suite.php?toto=bonjour&titi=aurevoir">Lien suivant</a>