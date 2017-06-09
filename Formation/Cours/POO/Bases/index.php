<?php

require('Personne.class.php');

function Foo()
{
	$test = new Personne("Jean-Marie Delacours", 63, "Homme?");
	$test->Parler();	//Toujours la syntaxe $sujet->Verbe([$complément])
}

$pedri = null;
$pedro = new Personne("Pedro", 33, "Homme", "es");			//Pour instancier une classe, on utilise new et on stocke l'objet créé
$francoise = new Personne("Françoise", 26, "Femme", "fr");	//Les paramètres sont ceux du constructeur
Foo();
$john = new Personne("JOHN CENA", 39, "Homme", 'en');

$pedri = $john;	//Ajoute une référence à John Cena, prolongeant légèrement sa durée de vie
