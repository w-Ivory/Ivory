<?php

//Sends the user, surprisingly, back to index
//does not stop page computation
function BackToIndex()
{
	header('Location:.');
}

//Verifies if the needed key exists in GET. If it does not, calls BackToIndex and stops the page
//(That means do not call this from index)
//Returns its content
function NeedGet($key)
{
	if(!isset($_GET[$key]))
	{
		BackToIndex();
		exit;
	}
	return $_GET[$key];
}

//Generates a PDOStatement using query or prepare, depending on $params composition
//$sql is your query
//$params is an associative array with the form 'placeholderName'=>value. Defaults to empty
//May return false or throw on error
function MakeStatement($pdo, $sql, $params = array())
{
	$statement = false;
	if(count($params) == 0)
	{
		$statement = $pdo->query($sql);
	}
	else
	{
		if(($statement = $pdo->prepare($sql)) !== false)
		{
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
	

	return $statement;
}

//Specialisation of MakeStatement for SELECT queries
//$sql is your query
//$params is an associative array with the form 'placeholderName'=>value. Defaults to empty
//$fetchStyle is the PDO option passed to fetchAll. Defaults to PDO::FETCH_ASSOC
//$fetchArg is needed for some values of $fetchStyle
//Returns an array of all the results. Format of the results depends on $fetchStyle
//May return false or throw on error
function MakeSelect($pdo, $sql, $params = array(), $fetchStyle = PDO::FETCH_ASSOC, $fetchArg = NULL)
{
	$statement = MakeStatement($pdo, $sql, $params);

	if($statement === false)
	{
		return false;
	}

	$data = isset($fetchArg) ? $statement->fetchAll($fetchStyle, $fetchArg) : $statement->fetchAll($fetchStyle);
	$statement->closeCursor();

	return $data;
}


try
{
	$pdo = new PDO('mysql:host=localhost;dbname=lesnains;charset=utf8', 'Gimly', 'PNnHVucZnEfjpATX',array( PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION ));
}
catch(PDOException $e)
{
	die($e->getMessage());
}