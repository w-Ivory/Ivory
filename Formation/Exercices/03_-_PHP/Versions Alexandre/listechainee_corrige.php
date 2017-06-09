<?php
$data = array(
array('lettre' => 'a', 'suivant' => 10),
array('lettre' => 'e', 'suivant' => -1),
array('lettre' => 'e', 'suivant' => 6),
array('lettre' => 'l', 'suivant' => 1),
array('lettre' => 'p', 'suivant' => 8),
array('lettre' => 'o', 'suivant' => 11),
array('lettre' => 'x', 'suivant' => 12),
array('lettre' => 'p', 'suivant' => 3),
array('lettre' => 'r', 'suivant' => 5),
array('lettre' => 'm', 'suivant' => 7),
array('lettre' => 'b', 'suivant' => 3),
array('lettre' => 'b', 'suivant' => 0),
array('lettre' => 'a', 'suivant' => 9)
);

function TrouverLigneSuivante($donnees, $ligneActuelle)
{
	return $donnees[$ligneActuelle]['suivant'];
}

function TrouverLettre($donnees, $ligne)
{
	return $donnees[$ligne]['lettre'];
}

function Extraire($donnees, $ligne)
{
	$resultat = "";
	$ligneActuelle = $ligne;
	while($ligneActuelle != -1)
	{
		$resultat .= TrouverLettre($donnees, $ligneActuelle);
		$ligneSuivante = TrouverLigneSuivante($donnees, $ligneActuelle);
		$ligneActuelle = $ligneSuivante;
	}

	return $resultat;
}

function Extraire_court($donnees, $ligne)
{
	$resultat = '';
	while($ligne != -1)
	{
		$resultat .= $donnees[$ligne]['lettre'];
		$ligne = $donnees[$ligne]['suivant'];
	}
	return $resultat;
}

function Extraire_rec($donnees, $ligne)
{
	if($ligne == -1)
		return '';
	return $donnees[$ligne]['lettre'] . Extraire_rec($donnees, $donnees[$ligne]['suivant']);
	//return $ligne == -1 ? '' : $donnees[$ligne]['lettre'] . Extraire_rec($donnees, $donnees[$ligne]['suivant']);
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Liste Chainee</title>
</head>
<body>
<form action="" method="get">
	<input type="number" name="val">
	<input type="submit">
</form>
<?php
	if(isset($_GET) && array_key_exists('val', $_GET))
	{
		echo Extraire($data, $_GET['val']) . '<br />';
		echo Extraire_court($data, $_GET['val']) . '<br />';
		echo Extraire_rec($data, $_GET['val']) . '<br />';
	}
?>
</body>
</html>

