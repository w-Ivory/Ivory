<?php
//Déclaration d'une classe nommée Personne
class Personne
{
	//Définition des données (variables membres ou propriétés) de Personne
	//Chaque (instance de) Personne en possèdera une copie
	private $nom;	//private interdit l'accès depuis l'extérieur de la classe
	private $age;
	private $sexe;
	private $nationalite;

	//Constructeur : fonction chargée d'initialiser l'objet. Appellée automatiquement lors de la création
	public function __construct($nom, $age, $sexe, $nationalite = "?")
	{
		$this->nom = $nom;			//Les membres (variables ou fonctions) sont utilisés par la biais de l'opérateur ->
		$this->age = $age;			//L'objet contenant est à gauche de l'opérateur. Dans les fonctions membres,
		$this->sexe = $sexe;		//il s'agit typiquement de $this, l'objet actuel
		$this->nationalite = $nationalite;

		echo 'Debut de vie de ' . $this->nom;
		echo '<br/>';
	}

	//Appellée lors de la conversion en chaîne de caractères.
	public function __tostring()
	{
		return $this->nom . ', ' . $this->age . ' ans';
	}

	//Appellée lors de la fin de vie de l'objet
	public function __destruct()
	{
		echo 'Fin de vie de ' . $this->nom;
		echo '<br/>';
	}

	//Définition des méthodes (ou fonctions membres) de Personne
	//Ce sont des actions disponibles pour chaque instance. Leur nom contient presque toujours un verbe
	public function Parler()	//Public autorise l'accès depuis n'importe où
	{
		switch ($this->nationalite)
		{
			case 'fr':
				echo "Bonjour";
				break;

			case 'es':
				echo "Hola";
				break;

			case 'it':
				echo "Ma qué";
				break;
			
			default:
				echo "Hello";
				break;
		}
		echo '<br/>';
	}

	//Les fonctions permettant de lire des membres sont appellées Getters sont généralement de la forme GetNomDonnée()
	public function GetNationalite()
	{
		return $this->nationalite;
	}

	//Les fonctions permettant de modifier des membres sont appellées Setters sont généralement de la forme SetNomDonnée($nouvelleValeur)
	//C'est ici que l'on peut vérifier que la nouvelle valeur est valide
	public function SetNationalite($value)
	{
		$this->nationalite = $value;
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

	public function GetSexe()
	{
		return $this->sexe;
	}
}