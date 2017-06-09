<?php

//L'echiquier gere les pieces presentes et leurs interactions
class Board
{
	use TypeTests;
	private $m_game;
	private $m_minCol;
	private $m_maxCol;
	private $m_minLine;
	private $m_maxLine;
	private $m_pieces;
	private $m_deadPieces;

	public function __construct(Game $game, $size = 8)
	{
		$this->m_game = $game;
		
		if(!self::IsInt($size) || $size <= 0)
		{
			$size = 8;
		}

		//Generation des limites
		$this->m_minCol = 'a';
		$this->m_maxCol = chr(ord('a') + $size - 1);
		$this->m_minLine = 1;
		$this->m_maxLine = $size;
		
		$this->m_pieces = array();
		$this->m_deadPieces = array();
	}
	
	//Cree une piece du type specifie sur place
	//$type doit etre le nom d'un sous-type de Piece
	//Retourne la piece creee ou NULL si echec
	public function CreatePiece($type, $color, Coord $pos)
	{
		$piece = new $type($this, $pos, $color);
		if(!$this->PlacePiece($piece))
		{
			$piece = NULL;	//Si impossible a placer, la supprimer
		}
		
		return $piece;
	}
	
	//Ajoute la piece dans le tableau
	//Retourne false en cas d'echec(par exemple place prise)
	protected function PlacePiece(Piece $piece)
	{
		$key = (string)$piece->GetPos();
		if(!isset($this->m_pieces[$key]))
		{
			$this->m_pieces[$key] = $piece;
			return true;
		}
		return false;
	}
	
	//Enleve une piece du type et de la couleur specifie de la liste des pieces mortes
	//Retourne true si la piece a ete trouvee et enlevee
	public function RemoveDeadPiece($type, $color)
	{
		if($color == Piece::ALL_COLORS)
		{
			foreach($this->m_deadPieces as $singleColor => $unused)
			{
				if($this->SingleColorRemoveDeadPiece($type, $singleColor))
					return true;
			}
			return false;
		}
		else
		{
			return $this->SingleColorRemoveDeadPiece($type, $color);
		}
	}
	
	private function SingleColorRemoveDeadPiece($type, $color)
	{
		if(isset($this->m_deadPieces[$color]))
		{
			if(($key = array_search($type, $this->m_deadPieces[$color])) !== false)
			{
				unset($this->m_deadPieces[$color][$key]);
				return true;
			}
		}
		return false;
	}
	
	//Retourne un tableau des types pieces mortes de la couleur choisie
	//format : array('typename')
	public function GetDeadPieces($color)
	{
		if(isset($this->m_deadPieces[$color]))
		{
			return $this->m_deadPieces[$color];
		}
		else if($color == Piece::ALL_COLORS)
		{
			$res = array();
			
			foreach($this->m_deadPieces as $subArray)
			{
				$res = array_merge($res, $subArray);
			}
		}
		return array();
	}

	public function IsCoordValid(Coord $coord)
	{
		$col = $coord->GetColumn();
		$line = $coord->GetLine();

		return $col >= $this->m_minCol && $col <= $this->m_maxCol && $line >= $this->m_minLine && $line <= $this->m_maxLine;
	}

	//Deplace une piece selon les regles du jeu. Peut echouer.
	//Renvoie 1 si le mouvement a reussi, 2 si une piece a ete prise, 0 en cas d'echec
	public function MovePiece(Piece $piece, Coord $to)
	{
		if($piece->CanGoTo($to))
		{
			$result = 1;
			if($other = $this->At($to))	//On sait qu'on peut aller sur cette case, c'est donc une prise sur un ennemi
			{
				$this->KillPiece($other);
				++$result;
			}
			$this->UpdatePiecePos((string)$piece->GetPos(), (string)$to);
			$piece->SetPos($to);
			return $result;
		}
		return 0;
	}

	//Tue une piece du plateau. Renvoie true si la piece a bien ete trouvee et detruite
	public function KillPiece(Piece $toKill)
	{
		if($toKill::PIECE_ESSENTIAL)
		{
			$this->m_game->LoseGame($toKill->GetColor());
		}
		$key = (string)$toKill->GetPos();
		if($this->m_pieces[$key] === $toKill)
		{
			unset($this->m_pieces[$key]);
			if(!isset($this->m_deadPieces[$toKill->GetColor()]))
			{
				$this->m_deadPieces[$toKill->GetColor()] = array();
			}
			$this->m_deadPieces[$toKill->GetColor()][] = get_class($toKill);
			return true;
		}

		return false;
	}
	
	//Promotion d'un pion
	public function Promote(Pawn $pawn)
	{
		$this->m_game->MakePromotion($pawn->GetPromotionPos());
	}

	//Retourne la piece aux coordonnees indiquees ou NULL si vide
	public function At(Coord $at)
	{
		$key = (string)$at;
		return isset($this->m_pieces[$key]) ? $this->m_pieces[$key] : NULL;
	}

	//Appellee par Piece lorsqu'elle est deplacee
	//Force l'echiquier a reverifier la position de piece
	public function PieceMoved(Piece $moved)
	{
		$pos = $moved->GetPos();
		//Teste si les donnees sont deja a jour
		if(!$this->At($pos) === $moved)
		{
			if(($key = array_search($moved, $this->m_pieces, true)) !== false)
			{
				UpdatePiecePos($key, (string)$pos);
			}
		}
	}

	private function UpdatePiecePos($fromKey, $toKey)
	{
		$piece = $this->m_pieces[$fromKey];
		unset($this->m_pieces[$fromKey]);
		$this->m_pieces[$toKey] = $piece;
	}

	//Affiche l'echiquier. $additionalContent contient du texte a rajouter, indexe par case ('e2' => '<h4>Exemple</h4>')
	//$linkedCases marke les cases avec un lien et est constitue des indexs optionnels suivants :
	//'color' => Piece::(WHITE/BLACK/ALL_COLORS)
	//'list' => array de toutes les Coord a lier
	public function Draw(array $linkedCases = array(), array $additionalContent = array())
	{
		echo '<table class="chessBoard">';
		for($line = $this->m_minLine; $line <= $this->m_maxLine; ++$line)
		{
			echo '<tr>';
			for($column = $this->m_minCol; $column <= $this->m_maxCol; $column = chr(ord($column) + 1))
			{
				$coord = new Coord($column, $line);
				$key = (string)$coord;
				$piece = $this->At($coord);
				//Faire un lien si il y a une piece de la couleur a lier
				$makeLink = (isset($linkedCases['color']) && $piece && ($linkedCases['color'] == Piece::ALL_COLORS || $piece->GetColor() == $linkedCases['color']))
				//Ou si la case est explicitement listee
					|| (isset($linkedCases['list']) && in_array($coord, $linkedCases['list']));
				echo '<td>';
				if($makeLink)
				{
					echo '<a href=".?cl=' . $coord->GetColumn() . '&ln=' . $coord->GetLine() . '">';
				}
				if(isset($additionalContent[$key]))
				{
					echo $additionalContent[$key];
				}
				if($piece)
				{
					echo $piece;
				}
				if($makeLink)
				{
					echo '</a>';
				}
				echo '</td>';
			}
			echo '</tr>';
		}
		echo '</table>';
	}
}