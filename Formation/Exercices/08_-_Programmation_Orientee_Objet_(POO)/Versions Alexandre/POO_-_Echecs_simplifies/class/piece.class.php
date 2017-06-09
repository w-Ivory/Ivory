<?php

//Chaque piece doit connaitre sa position et determiner les cases accessibles
abstract class Piece
{
	const WHITE = 1;
	const BLACK = 2;
	const ALL_COLORS = 0;
	const PIECE_NAME = 'NONE';
	const PIECE_SYMBOLNUMBER = 0;
	const PIECE_ESSENTIAL = false;
	private $m_pos;
	private $m_board;
	private $m_color;

	//Retourne la couleur qui joue ensuite
	public static function NextColor($color)
	{
		return (3 - $color);	//Ceci est une arnaque mathematique : transforme le 1 en 2 et le 2 en 1
	}
	
	public static function ColoredSymbol($symbolNumber, $color)
	{
		return '&#' . ($symbolNumber + ($color - 1) * 6);	//Les symboles noirs sont decales de 6
	}
	
	public function __construct(Board $board, Coord $coord, $color)
	{
		if(!$board->IsCoordValid($coord))
		{
			//On ne peut pas creer de piece a des coordonnees invalides : impossible de recuperer d'ici
			throw new ChessException("Impossible de creer une piece aux coordonnees invalides $pos");
		}

		$this->m_board = $board;
		$this->m_pos = $coord;
		$this->m_color= $color;
	}

	public function GetBoard()
	{
		return $this->m_board;
	}

	public function GetColor()
	{
		return $this->m_color;
	}
	
	public function GetSymbol()
	{
		return self::ColoredSymbol(static::PIECE_SYMBOLNUMBER, $this->m_color);
	}

	public function GetPos()
	{
		return $this->m_pos->Copy();
	}

	//Force la piece a cette position. Reagit a certains endroits (comme le pion en fin de ligne)
	public function SetPos(Coord $pos)
	{
		if(!$this->m_board->IsCoordValid($pos))
		{
			//On ne peut pas creer de piece a des coordonnees invalides : impossible de recuperer d'ici
			throw new ChessException("Impossible de placer une piece aux coordonnees invalides $pos");
		}

		//On veut une position independante, copie
		$this->m_pos = $pos->Copy();

		//Demande a l'echiquier de se mettre a jour
		$this->m_board->PieceMoved($this);
	}

	public function CanGoTo(Coord $to)
	{
		return in_array($to, $this->GetDestinationList());
	}

	//Implementation basique de GetDestinationList. $directions liste toutes les directions de mouvement possible sous la forme array(array(col_dir, line_dir), ...)
	protected function GenerateDestinations(array $directions, $minDist, $maxDist, $stopAtAlly = true, $stopAtEnnemy = true)
	{
		$result = array();
		foreach ($directions as $direction)
		{
			//Depart a partir de minDist
			$pos = $this->m_pos->Plus($direction[0] * $minDist, $direction[1] * $minDist);

			$i = $minDist;

			while($i <= $maxDist && $this->m_board->IsCoordValid($pos))
			{
				$piece = $this->m_board->At($pos);

				if($piece && $piece->m_color == $this->m_color)
				{
					if($stopAtAlly)
						break;
				}
				else	//N'ajouter la case que si il n'y a pas deja un allie
					$result[] = $pos;

				//On ajoute quand meme l'ennemi dans les cases possibles
				if($stopAtEnnemy && $piece && $piece->m_color != $this->m_color)
				{
					break;
				}

				$pos = $pos->Plus($direction[0], $direction[1]);
				++$i;
			}
		}

		return $result;
	}

	//Utilitaire pour les implementations de GetDestinationList. Retourne le tableau de coordonnees pris en entree, moins les cases deja occupees par des allies ou invalides
	protected function FilterValidDestinations(array $destinations)
	{
		foreach ($destinations as $key => $dest)
		{
			if((!$this->m_board->IsCoordValid($dest)) || (($piece = $this->m_board->At($dest)) && $piece->GetColor() == $this->GetColor()))
			{
				unset($destinations[$key]);
			}
		}

		return $destinations;
	}

	//Retourne toutes les coordonees accesibles pour cette piece.
	//Format : array de Coord
	public abstract function GetDestinationList();

	public function __toString()
	{
		return $this->GetSymbol();
	}
}