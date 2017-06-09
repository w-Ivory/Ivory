<?php
function GetPDO()
{
	static $pdo = NULL;

	if(!isset($pdo))
	{
		try
		{
			$pdo = new PDO('mysql:host=localhost;dbname=graphe;charset=utf8', 'root', '',array( PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION ));
		}
		catch(PDOException $e)
		{
			die($e->getMessage());
		}
	}

	return $pdo;
}

//Generates a PDOStatement using query or prepare, depending on $params composition
//$sql is your query
//$params is an associative array with the form 'placeholderName'=>value. Defaults to empty
//May return false or throw on error
function MakeStatement($sql, $params = array())
{
	$pdo = GetPDO();
	$statement = false;
	if(count($params) > 0)
	{
		if(($statement = $pdo->prepare($sql)) !== false)
		{
			$hasNull = false;
			foreach ($params as $placeholder => $value)
			{
				if($statement->bindValue($placeholder, $value=='' ? null : $value) === false)
					return false;
			}
			if(!$statement->execute())
			{
				return false;
			}
		}
	}
	else
	{
		$statement = $pdo->query($sql);
	}

	return $statement;
}

//Specialisation of MakeStatement for SELECT queries
//$sql is your query
//$params is an associative array with the form 'placeholderName'=>value. Defaults to empty
//$fetchStyle is the PDO option passed to fetchAll. Defaults to PDO::FETCH_ASSOC
//$fetchArg is needed for some values of $fetchStyle
//Returns an array of all the results. Format of the results depends on $fetchStyle
//May return false or throw on error
function MakeSelect($sql, $params = array(), $fetchStyle = PDO::FETCH_ASSOC, $fetchArg = NULL)
{
	$statement = MakeStatement($sql, $params);

	if($statement === false)
	{
		return false;
	}

	$data = isset($fetchArg) ? $statement->fetchAll($fetchStyle, $fetchArg) : $statement->fetchAll($fetchStyle);
	$statement->closeCursor();

	return $data;
}

function square($x)
{
	return $x * $x;
}

function Intern_NodeCoord($node)
{
	return MakeSelect('SELECT `n_x`, `n_y` FROM `node` WHERE `n_id`=:id', array('id' => $node), PDO::FETCH_NUM)[0];
}

function Intern_Distance($node1, $node2)
{
	$coord1 = Intern_NodeCoord($node1);
	$coord2 = Intern_NodeCoord($node2);

	return sqrt(square($coord1[0] - $coord2[0]) + square($coord1[1] - $coord2[1]));
}

function Intern_GetNeighbors($node)
{
	return MakeSelect('SELECT `e_to` FROM `edge` WHERE `e_from`=:id', array('id' => $node), PDO::FETCH_COLUMN, 0);
}

function Intern_GetAllNodes()
{
	return MakeSelect('SELECT `n_id` FROM `node`', array(), PDO::FETCH_COLUMN, 0);
}