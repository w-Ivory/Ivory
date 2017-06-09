<?php
//I'm Rick Harrisson and this is my pawn.

class Pawn extends Piece
{
	const PIECE_NAME = 'Pawn';
	const PIECE_SYMBOLNUMBER = 9817;
	private $m_direction;

	public function __construct(Board $board, Coord $coord, $color)
	{
		parent::__construct($board, $coord, $color);

		$this->m_direction = self::DirectionFromColor($color);
	}

	private static function DirectionFromColor($color)
	{
		switch($color)
		{
		case self::WHITE:
			return 1;
		case self::BLACK:
			return -1;
		default:
			return 0;
		}
	}

	public function GetDestinationList()
	{
		return $this->GenerateDestinations(array(array(0, $this->m_direction)), 1, 1);
	}

	public function SetPos(Coord $pos)
	{
		parent::SetPos($pos);

		//Si la prochaine case n'est pas valide, c'est qu'on est arrive au bout
		if(!$this->GetBoard()->IsCoordValid($this->GetPos()->Plus(0, $this->m_direction)))
		{
			//Faire la promotion seulement a l'aller, pas au retour
			if($this->m_direction == self::DirectionFromColor($this->GetColor()))
			{
				$this->GetBoard()->Promote($this);
			}
			
			$this->m_direction = -$this->m_direction;	//Inverse la direction
		}
	}
	
	//Retourne la position ou effectuer la promotion. Actuellement derriere le pion
	public function GetPromotionPos()
	{
		return $this->GetPos()->Plus(0, -$this->m_direction);
	}
}