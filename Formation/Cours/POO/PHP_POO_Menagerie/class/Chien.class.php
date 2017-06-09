<?php
class Chien extends Animal
{
	private $race;

	public function __construct($nom, $age, $race)
	{
		parent::__construct($nom, $age);
		$this->race = $race;
	}

	public function GetRace()
	{
		return $this->race;
	}

	public function Manger()
	{
		echo 'Le chien mange ses croquettes';
	}

	public function Crier()
	{
		echo 'Le chien aboie et fait fuir les chats';
	}
}