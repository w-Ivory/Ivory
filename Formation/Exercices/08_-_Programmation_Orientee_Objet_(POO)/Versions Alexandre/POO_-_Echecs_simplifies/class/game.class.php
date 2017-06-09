<?php

//Game gere l'etat du jeu et transmet les instructions du joueur au plateau
class Game
{
	private $m_board;
	private $m_state;
	private $m_playingColor;
	private $m_lastError;
	private $m_focusPosition;
	private $m_logs;
	
	//Constantes pour l'etat du jeu
	const STATE_ENDTURN = -1;	//Signale la fin du tour, etat temporaire
	const STATE_NEWTURN = 1;	//En attente du joueur
	const STATE_PIECESELECTED = 2;	//Le joueur a selectione une piece, attente du choix de la destination
	const STATE_PROMOTION = 3;	//Attente du choix de la promotion
	const STATE_OVER = 0;	//Fin du jeu
	
	public function __construct()
	{
		$this->m_focusPosition = NULL;
		$this->m_state = self::STATE_NEWTURN;
		$this->m_playingColor = Piece::WHITE;		//Les blancs commencent
		$this->m_lastError = '';
		$this->m_board = new Board($this);
		$this->m_logs = array();
		
		//Placement des pieces
		$this->m_board->CreatePiece('King', Piece::WHITE, new Coord('e', 1));
		$this->m_board->CreatePiece('Queen', Piece::WHITE, new Coord('d', 1));
		$this->m_board->CreatePiece('Knight', Piece::WHITE, new Coord('c', 1));
		$this->m_board->CreatePiece('Knight', Piece::WHITE, new Coord('f', 1));
		$this->m_board->CreatePiece('Pawn', Piece::WHITE, new Coord('e', 2));
		$this->m_board->CreatePiece('Pawn', Piece::WHITE, new Coord('d', 2));
		$this->m_board->CreatePiece('Pawn', Piece::WHITE, new Coord('c', 2));
		$this->m_board->CreatePiece('Pawn', Piece::WHITE, new Coord('f', 2));
		
		$this->m_board->CreatePiece('King', Piece::BLACK, new Coord('e', 8));
		$this->m_board->CreatePiece('Queen', Piece::BLACK, new Coord('d', 8));
		$this->m_board->CreatePiece('Knight', Piece::BLACK, new Coord('c', 8));
		$this->m_board->CreatePiece('Knight', Piece::BLACK, new Coord('f', 8));
		$this->m_board->CreatePiece('Pawn', Piece::BLACK, new Coord('e', 7));
		$this->m_board->CreatePiece('Pawn', Piece::BLACK, new Coord('d', 7));
		$this->m_board->CreatePiece('Pawn', Piece::BLACK, new Coord('c', 7));
		$this->m_board->CreatePiece('Pawn', Piece::BLACK, new Coord('f', 7));
	}
	
	public function LoseGame($loser)
	{
		$this->m_state = self::STATE_OVER;
		$this->m_playingColor = Piece::NextColor($loser);
	}
	
	public function DrawBoard()
	{
		$links = array();
		$additional = array();
		
		//Decision des donnees additionelles et des cases cliquables
		switch($this->m_state)
		{
		case self::STATE_NEWTURN:
			$links['color'] = $this->m_playingColor;
			break;
			
		case self::STATE_PIECESELECTED:
			$links['list'] = $this->m_board->At($this->m_focusPosition)->GetDestinationList();
			break;
			
		case self::STATE_PROMOTION:
			$form = '<form action="." method="GET"><select name="promotion">';
			foreach($this->m_board->GetDeadPieces($this->m_playingColor) as $type)
			{
				$form .= '<option value="' . $type . '">' . Piece::ColoredSymbol($type::PIECE_SYMBOLNUMBER, $this->m_playingColor) . '</option>';
			}
			$form .= '</select><input type="submit"></form>';
			$additional[(string)$this->m_focusPosition] = $form;
			break;
			
		case self::STATE_OVER:
			break;
			
		case self::STATE_ENDTURN:	//Ne devrais jamais arriver
		default:
			throw new ChessException("Unknown game state : " . $this->m_state);
		}
		
		$this->m_board->Draw($links, $additional);
	}
	
	//Permet de connaitre la derniere erreur
	public function PeekError()
	{
		return $this->m_lastError;
	}
	
	//Renvoie la derniere erreur et la supprime
	public function ConsumeError()
	{
		$error = $this->m_lastError;
		$this->m_lastError = '';
		return $error;
	}
	
	public function GetLogs()
	{
		return $this->m_logs;
	}
	
	//Retourne si la partie est en cours
	public function IsPlaying()
	{
		return $this->m_state != self::STATE_OVER;
	}
	
	public function GetWinner()
	{
		if($this->IsPlaying())
			return Piece::ALL_COLORS;
		
		return $this->m_playingColor;
	}
	
	public function GetPlayingColor()
	{
		return $this->m_playingColor;
	}
	
	public function MakePromotion(Coord $at)
	{
		if($this->IsPlaying() && count($this->m_board->GetDeadPieces($this->m_playingColor)) > 0)
		{
			$this->m_state = self::STATE_PROMOTION;
			$this->m_focusPosition = $at;
		}
	}
	
	//Recupere les entrees et traite les actions de l'utilisateur
	//Retourne true si l'action a ete traitee avec succes
	public function Exec(array $input)
	{
		$result = false;
		if(isset($input['ln']) && isset($input['cl']))
		{
			$coord = new Coord($input['cl'], $input['ln']);
			if($this->m_board->IsCoordValid($coord))
				$result |= $this->UserSelectCase($coord);
		}
		if(isset($input['promotion']))
		{
			$result |= $this->UserSelectPromotion($input['promotion']);
		}
		
		//Changement de tour
		if($this->m_state == self::STATE_ENDTURN)
		{
			$this->m_state = self::STATE_NEWTURN;
			$this->m_playingColor = Piece::NextColor($this->m_playingColor);
			$this->m_focusPosition = NULL;
		}
		
		return $result;
	}
	
	//Traite la promotion choise par l'utilisateur
	//Retourne true si elle est accepte
	private function UserSelectPromotion($type)
	{
		if($this->m_state == self::STATE_PROMOTION)
		{
			if($this->m_board->RemoveDeadPiece($type, $this->m_playingColor))
			{
				$piece = $this->m_board->CreatePiece($type, $this->m_playingColor, $this->m_focusPosition);
				if($piece)
				{
					$this->m_logs[count($this->m_logs) - 1] .= $piece->GetSymbol();	//Notation officielle, on ajoute le symbole de la promotion a la fin du mouvement
					$this->m_state = self::STATE_ENDTURN;
					return true;
				}
			}
			else
			{
				$this->m_lastError = 'Cette piece n\'est pas disponible';
			}
		}
		else
		{
			$this->m_lastError = 'Pas de promotion disponible';
		}
		
		return false;
	}
	
	//Traite la selection utilisateur
	//Retourne true si le mouvement est accepte
	private function UserSelectCase(Coord $selected)
	{
		switch($this->m_state)
		{
		case self::STATE_NEWTURN:
			return $this->UserChoosePiece($selected);
		case self::STATE_PIECESELECTED:
			return $this->UserChooseDestination($selected);
		case self::STATE_PROMOTION:
		case self::STATE_OVER:
			$this->m_lastError = 'Vous ne pouvez pas faire ca maintenant';
			return false;
			
		case self::STATE_ENDTURN:	//Ne devrais jamais arriver
		default:
			throw new ChessException("Unknown game state : " . $this->m_state);
		}
	}
	
	private function UserChoosePiece(Coord $selected)
	{
		$piece = $this->m_board->At($selected);
		
		if($piece && $piece->GetColor() == $this->m_playingColor)
		{
			if(count($piece->GetDestinationList()) != 0)
			{
				$this->m_focusPosition = $selected;
				$this->m_state = self::STATE_PIECESELECTED;
				return true;
			}
			$this->m_lastError = 'Cette piece ne peut aller nulle part';
		}
		else
		{
			$this->m_lastError = 'Veuillez selectionner une piece de votre couleur';
		}
		
		return false;
	}
	
	private function UserChooseDestination(Coord $dest)
	{
		$piece = $this->m_board->At($this->m_focusPosition);
		if($piece && $piece->CanGoTo($dest))
		{
			$from = $this->m_focusPosition;
			//Attention a bien changer l'etat avant le mouvement, car le mouvement peut ecraser l'etat lors de la promotion
			$this->m_state = self::STATE_ENDTURN;
			$result = $this->m_board->MovePiece($piece, $dest);
			if($result != 0)
			{
				$this->m_logs[] = $piece->GetSymbol() . $from . ($result == 1 ? '-' : 'x') . $dest;	//Notation officielle
				return true;
			}
		}
		else
		{
			$this->m_lastError = 'Destination inateignable';
		}
		
		return false;
	}
}