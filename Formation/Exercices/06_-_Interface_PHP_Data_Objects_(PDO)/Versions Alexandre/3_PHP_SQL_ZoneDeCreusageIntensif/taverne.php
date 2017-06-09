<?php

include('common.php');
$id = NeedGet('id');

try
{
	$taverne = MakeSelect($pdo, 'SELECT `v_nom`, `taverne`.*, (`t_chambres` - COUNT(`n_id`) ) AS chambresLibres FROM `taverne` JOIN `ville` ON `t_ville_fk` = `v_id` LEFT JOIN `groupe` ON `t_id`=`g_taverne_fk` LEFT JOIN `nain` ON `g_id`=`n_groupe_fk` WHERE `t_id`=:id', array('id'=>$id));
}
catch(PDOException $e)
{
	BackToIndex();
	die($e->getMessage());
}

$taverne = $taverne[0];

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf8"/>
	<title><?php echo $taverne['t_nom']; ?></title>
</head>
<body>
<?php
	echo $taverne['t_nom'] . ', <a href="ville.php?id=' . $taverne['t_ville_fk'] . '">' . $taverne['v_nom'] . '</a><br>';
	$bieres = array();
	if($taverne['t_blonde'])	//Mais?
	{
		$bieres[] = 'blonde';
	}
	if($taverne['t_brune'])		//C'est pas des booléens?!
	{
		$bieres[] = 'brune';
	}
	if($taverne['t_rousse'])	//Comment ça marche?
	{
		$bieres[] = 'rousse';
	}

	echo 'Nous possédons de la bière ';
	$last = array_pop($bieres);
	if(count($bieres) > 0)
		 echo implode(', ', $bieres) . ' et ';
	echo $last . '.';

	echo '<br>' . $taverne['t_chambres'] . ' chambres, dont ' . $taverne['chambresLibres'] . ' libres';
?>
</body>
</html>