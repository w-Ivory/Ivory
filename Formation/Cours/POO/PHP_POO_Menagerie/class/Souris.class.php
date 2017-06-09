<?php
class Souris extends Animal
{
	private $fromagePrefere;

	public function __construct($nom, $age, $fromagePrefere = 'Emmental')
	{
		parent::__construct($nom, $age);
		$this->fromagePrefere = $fromagePrefere;
	}

	public function GetFromagePrefere()
	{
		return $this->fromagePrefere;
	}

	public function Manger()
	{
		echo "La souris mange un morceau de " . $this->fromagePrefere;
	}

	public function Crier()
	{
		echo "La souris couine de manière pathétique";
	}
}