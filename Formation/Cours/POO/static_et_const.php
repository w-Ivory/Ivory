<?php



class Unit
{
	//Un membre statique est stocké dans la classe, et non chaque instance
	//Accessible via NomClasse::$nomVariableStatique
	//Ou NomClasse::NomFonctionStatique($params)
	private static $cptInstances = 0;

	public static function GetNbInstances()
	{
		return self::$cptInstances;		//self est synonyme du nom de la classe actuelle, ici on l'utilise au lieu de Unit
	}

	public function __construct()
	{
		//Le compteur est statique et donc partagé par toutes les instances.
		self::$cptInstances++;
	}

	public function __destruct()
	{
		self::$cptInstances--;
	}


	//Création de constantes de classe.
	//Accessibles via NomClasse::NomConstante
	const REACTION_ENNEMY = 0;
	const REACTION_HOSTILE = 1;
	const REACTION_NEUTRAL = 2;
	const REACTION_FRIENDLY = 3;
	const REACTION_ALLY = 4;
	public function GetReactionTo($target)
	{
		/*
			Calcul de la reputation de target
			Imaginez qu'il y a plus de calculs pour obtenir $reputation
		*/
		$reputation = self::REACTION_NEUTRAL;


		return $reputation;
	}
}

class Beast extends Unit
{
	public function GetReactionTo($target)
	{
		$reaction = parent::GetReactionTo($target);		//On récupère le résultat de la version parente
		if($reaction < self::REACTION_FRIENDLY)
		{
			$reaction = self::REACTION_ENNEMY;			//Si on est pas ami, on est ennemi (les bêtes sont très aggressives)
		}

		return $reaction;
	}
}


$lion = new Beast();
if ($lion->GetReactionTo(NULL) == Unit::REACTION_ENNEMY)
{
	echo 'Le lion semble aggressif';
}
echo 'Il y a actuellement ' . Unit::GetNbInstances() . ' instances de Unit';	//Là où le -> est utilisé sur une instance, on utilise le :: sur une classe