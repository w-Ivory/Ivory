<?php

require('Vehicle.class.php');

class Car extends Vehicle
{
	private $moteur;
	private $tailleCoffre;

	public function __construct($moteur, $tailleCoffre, $couleur)
	{
		parent::__construct(4, 5, $couleur);
		$this->moteur = $moteur;
		$this->tailleCoffre = $tailleCoffre;
	}

	public function Klaxon()
	{
		echo 'tut tut';
		$this->etat -= 0.0001;
	}

	public function Move()
	{
		parent::Move();
		$this->etat -= 10;
	}
}