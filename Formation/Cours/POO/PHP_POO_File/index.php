<?php
require('Fichier.class.php');

$fichier = new Fichier('Test.txt');
echo $fichier->Read();

echo '<hr/>';

$fichier->WriteLine('Monde');
echo $fichier->Read();