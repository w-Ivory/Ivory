<?php
class Perroquet extends Oiseau
{
	private $motsAppris;

	public function __construct($nom, $age)
	{
		parent::__construct($nom, $age);
		$this->motsAppris = array();
	}

	public function ApprendreMot($mot)
	{
		if(!$this->ConnaitMot($mot))
			$this->motsAppris[] = $mot;
	}

	public function ConnaitMot($mot)
	{
		//*
		return in_array($mot, $this->motsAppris);
		/*/
		if(in_array($mot, $this->motsAppris))
		{
			return true;
		}
		return false;//*/
	}

	public function Crier()
	{
		if(count($this->motsAppris) == 0)
		{
			$mot = 'Brahhhhhh';
		}
		else
		{
			$mot = $this->motsAppris[array_rand($this->motsAppris)];
		}

		echo 'Le perroquet fait ' . $mot;
	}
}