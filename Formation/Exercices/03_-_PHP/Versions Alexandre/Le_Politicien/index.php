<?php
if(!defined('PHP_EOL'))
{
	if(strtoupper(substr(PHP_OS, 0, 3)) == 'WIN')
	{
		define('PHP_EOL', "\r\n");
	}
	else
	{
		define('PHP_EOL', "\n");
	}
}

/**
 * ChargerPoliticien - Charge les donnees du fichier pour usage par le reste du programme
 * @param string $nomFichier Le chemin vers le fichier a charger
 * @return array Les donnees formattees (tableau des groupes, eux memes des tableau de repliques)
**/
function ChargerPoliticien($nomFichier)
{
	$file = fopen($nomFichier, 'r');

	$data = array();
	while(!feof($file))
	{
		$group = array();

		//*
		while(($ligne = fgets($file)) !== false && $ligne != PHP_EOL)	//Recupere la ligne dans $ligne et la compare a false et vérifie qu'elle ne soit pas vide
		{
			$group[] = $ligne;
		}/*/
		$ligne = fgets($file);
		while($ligne !== false && $ligne != PHP_EOL)
		{
			$group[] = $ligne;
			$ligne = fgets($file);
		}
		//*/

		$data[] = $group;
	}

	fclose($file);
	return $data;
}


function ExtraireReplique(&$groupe)
{
	$cle = array_rand($groupe);
	$resultat = $groupe[$cle];
	unset($groupe[$cle]);

	return $resultat;
}


/**
 * CreerPhrases - Genere des phrases dignes d'un politicien
 * @param array $data Donnees chargees par ChargerPoliticien
 * @param int $nbPhrases Nombre de phrases a generer
 * @return string
**/
function CreerPhrases($data, $nbPhrases)
{
	$resultat = '';

	for($phrase = 0; $phrase < $nbPhrases; $phrase++)
	{
		for($indexGroupe = 0; $indexGroupe < count($data); $indexGroupe++)
		{
			//if($phrase == 0 && $indexGroupe == 0)
			if($phrase + $indexGroupe == 0)
			{
				$resultat .= $data[0][0];
				unset($data[0][0]);
			}
			else
			{
				$resultat .= ' ' . ExtraireReplique($data[$indexGroupe]);
			}
		}
		$resultat .= '<br/>';
	}

	return $resultat;
}
/*function CreerPhrases($data, $nbPhrases)
{
	$resultat = $data[0][0];
	unset($data[0][0]);
	$indexGroupe = 1;

	for($phrase = 0; $phrase < $nbPhrases; $phrase++)
	{
		while($indexGroupe < count($data))
		{
			$resultat .= ' ' . ExtraireReplique($data[$indexGroupe]);
			$indexGroupe++;
		}
		$indexGroupe = 0;
		$resultat .= '<br/>';
	}

	return $resultat;
}*/

?>

<!DOCTYPE html>
<html>
	<head>
		<title>La politique dans ta face</title>
		<meta charset="utf-8">
	</head>
	<body>
		<h1>Le politicien moyen</h1>
		<?php
			$data = ChargerPoliticien('data_2.txt');

			echo CreerPhrases($data, 4);
		?>
	</body>
</html>
