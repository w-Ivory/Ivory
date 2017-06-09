<?php
class Animal
{
	private $nom;
	private $age;

	public function __construct($nomAnimal, $ageAnimal)
	{
		$this->nom = $nomAnimal;
		$this->age = $ageAnimal;
	}

	public function GetNom()
	{
		return $this->nom;
	}

	public function GetAge()
	{
		return $this->age;
	}

	public function Vieillir()
	{
		$this->age++;
	}

	public function Manger()
	{
		echo "L'animal mange...";
	}

	public function Crier()
	{
		echo "L'animal crie...";
	}
}