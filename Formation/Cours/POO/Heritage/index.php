<?php

require('Car.class.php');

$voiture = new Car('Essence', 5, 'Rouge');
echo $voiture->GetEtat() . '<br/>';
$voiture->Move();
echo $voiture->GetEtat() . '<br/>';
