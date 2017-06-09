<?php

class Queen extends Piece
{
	const PIECE_NAME = 'Queen';
	const PIECE_SYMBOLNUMBER = 9813;

	public function GetDestinationList()
	{
		return $this->GenerateDestinations(array(array(0, 1), array(1, 0), array(0, -1), array(-1, 0)), 1, INF, false);
	}
}