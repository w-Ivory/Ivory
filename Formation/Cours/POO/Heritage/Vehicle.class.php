<?php
class Vehicle
{
	private $nbRoues;
	private $nbPassagers;
	private $couleur;
	protected $etat;

	public function __construct($roues, $passagers, $couleur)
	{
		$this->nbRoues = $roues;
		$this->nbPassagers = $passagers;
		$this->couleur = $couleur;
		$this->etat = 100;
	}

	public function GetNbRoues()
	{
		return $this->nbRoues;
	}

	public function GetNbPassagers()
	{
		return $this->nbPassagers;
	}

	public function GetCouleur()
	{
		return $this->couleur;
	}

	public function SetCouleur($nouvelleCouleur)
	{
		$this->couleur = $nouvelleCouleur;
	}

	public function GetEtat()
	{
		return $this->etat;
	}

	public function Move()
	{
		echo 'Le vehicule a bougé!<br/>';
	}
}