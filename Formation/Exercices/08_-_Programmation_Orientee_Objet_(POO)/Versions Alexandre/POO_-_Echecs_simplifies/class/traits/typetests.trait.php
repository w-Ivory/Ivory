<?php

trait TypeTests
{
	//Utilitaire pour tester si val est un int ou au moins interpretable en tant que int
	private static function IsInt($val)
	{
		return ctype_digit(strval($val));
	}
}