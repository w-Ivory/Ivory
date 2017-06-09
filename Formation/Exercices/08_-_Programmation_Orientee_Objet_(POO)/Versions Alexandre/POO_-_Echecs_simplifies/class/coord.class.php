<?php

//Represente une coordonee sur l'echiquier
//Cette classe ne teste pas la validite d'une coordonnee, c'est a l'echiquier d'accepter ou refuser la coordonnee (permet des echiquiers customises)
class Coord
{
	use TypeTests;
	private $m_column;
	private $m_line;

	public function __construct($column, $line)
	{
		//Valeurs par defaut en cas de parametre invalide
		$this->m_column = 'a';
		$this->m_line = 1;

		$this->SetColumn($column);
		$this->SetLine($line);
	}

	//Utilitaire pour recuperer une coordonee a partir d'une chaine
	public static function FromString($str)
	{
		$res = str_split($str);
		return new Coord($res[0], $res[1]);
	}

	public function SetLine($line)
	{
		if(self::IsInt($line))
		{
			$this->m_line = $line;
		}
	}

	public function GetLine()
	{
		return $this->m_line;
	}

	public function SetColumn($column)
	{
		if(is_string($column) && strlen($column) == 1)
		{
			$column = strtolower($column);	//Les colonnes sont en minuscule
			$this->m_column = $column;
		}
	}

	public function GetColumn()
	{
		return $this->m_column;
	}

	//Fournit une copie de cette coordonee
	//similaire a $res = clone $coord;
	public function Copy()
	{
		return new Coord($this->m_column, $this->m_line);
	}

	//Retourne une nouvelle coordonee decalee de $line lignes et de $column colonnes. Les deux parametres sont des decalages entiers
	public function Plus($column, $line)
	{
		return new Coord(chr(ord($this->m_column) + $column), $this->m_line + $line);
	}

	//Retourne la difference entre $this et $other sous la forme array(diff_col, diff_line)
	public function Diff(Coord $other)
	{
		return array(ord($this->m_column) - ord($other->m_column), $this->line - $other->line);
	}

	public function __toString()
	{
		return $this->m_column . $this->m_line;
	}
}