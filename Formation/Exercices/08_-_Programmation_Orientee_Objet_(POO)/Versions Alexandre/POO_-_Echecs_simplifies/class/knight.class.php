<?php

class Knight extends Piece
{
	const PIECE_NAME = 'Knight';
	const PIECE_SYMBOLNUMBER = 9816;

	public function GetDestinationList()
	{
		return $this->GenerateDestinations(array(array(0, 1), array(1, 0), array(0, -1), array(-1, 0)), 3, 3, false, false);
	}
}