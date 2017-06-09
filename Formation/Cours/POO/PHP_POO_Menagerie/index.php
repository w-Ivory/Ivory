<?php

function autoload($name)
{
	require_once('class/' . $name . '.class.php');
}
spl_autoload_register('autoload');

$menagerie = array();
$menagerie[] = new Chat('Felix', 4, 'Gris');
$menagerie[] = new Chien('Rex', 5, 'Berger allemand');
$coco = new Perroquet('Coco', 2);
$coco->ApprendreMot("Salut");
$menagerie[] = $coco;

foreach ($menagerie as $animal)
{
	$animal->Crier();
	echo '<br/>';
	$animal->Manger();
	echo '<br/>';
}