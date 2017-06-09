<?php

class King extends Piece
{
	const PIECE_NAME = 'King';
	const PIECE_SYMBOLNUMBER = 9812;
	const PIECE_ESSENTIAL = true;

	public function GetDestinationList()
	{
		return $this->GenerateDestinations(array(array(0, 1), array(1, 0), array(0, -1), array(-1, 0)), 1, 1);
	}
}