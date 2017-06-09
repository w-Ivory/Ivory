<?php

include('common.php');
$id=NeedGet('id');

try
{
	$ville = MakeSelect($pdo, 'SELECT `v_nom`,`v_superficie` FROM `ville` WHERE `v_id`=:id', array('id'=>$_GET['id']));
	$nains = MakeSelect($pdo, 'SELECT `n_id`,`n_nom` FROM `nain` WHERE `n_ville_fk`=:id ORDER BY `n_nom` ASC', array('id'=>$_GET['id']));
	$tavernes = MakeSelect($pdo, 'SELECT `t_id`,`t_nom` FROM `taverne` WHERE `t_ville_fk`=:id ORDER BY `t_nom` ASC', array('id'=>$_GET['id']));
	$tunnels = MakeSelect($pdo, 'SELECT `tunnel`.*, dep.`v_nom` v_dep, ar.`v_nom` v_ar FROM `tunnel` JOIN `ville` dep ON `t_villedepart_fk`=dep.`v_id` JOIN `ville` ar ON `t_villearrivee_fk`=ar.`v_id` WHERE `t_villedepart_fk`=:id0 OR `t_villearrivee_fk`=:id1', array('id0'=>$id, 'id1'=>$id));
	/*SELECT v.`v_nom`, v.`v_superficie`, other.v_id other_id, other.v_nom other_nom, `t_progres`, GROUP_CONCAT(DISTINCT CONCAT('<li><a href=nain.php?id=', `n_id`, '">', `n_nom`, '</a></li>') SEPARATOR ''), GROUP_CONCAT(DISTINCT CONCAT('<li><a href=nain.php?id=', taverne.`t_id`, '">', `t_nom`, '</a></li>') SEPARATOR '')
FROM `ville` v
LEFT JOIN `nain` ON n_ville_fk = v.`v_id`
LEFT JOIN `taverne` ON t_ville_fk = v.`v_id`
LEFT JOIN `tunnel` ON `t_villedepart_fk`=v.`v_id` OR `t_villearrivee_fk`=v.`v_id`
LEFT JOIN `ville` other ON (`t_villedepart_fk`=other.v_id OR `t_villearrivee_fk`=other.v_id) AND other.v_nom != v.`v_nom`
WHERE v.`v_id`=1
GROUP BY v.v_id, other.v_id*/
}
catch(PDOException $e)
{
	BackToIndex();
	die($e->getMessage());
}

$ville = $ville[0];

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<title>La magnifique ville de <?php echo $ville['v_nom']; ?></title>
</head>
<body>
	<?php
		echo $ville['v_nom'] . ', ' . $ville['v_superficie'] . 'km²<br>';
	?>
	Habitants : <br>
	<ul>
		<?php
			foreach ($nains as $nain)
			{
				echo '<li><a href="nain.php?id=' . $nain['n_id'] . '">' . $nain['n_nom'] . '</a></li>';
			}
		?>
	</ul>
	Tavernes locales : <br>
	<ul>
		<?php
			foreach ($tavernes as $taverne)
			{
				echo '<li><a href="taverne.php?id=' . $taverne['t_id'] . '">' . $taverne['t_nom'] . '</a></li>';
			}
		?>
	</ul>
	État des tunnels : <br>
	<ul>
		<?php
			foreach ($tunnels as $tunnel)
			{
				$idVille = $tunnel['t_villedepart_fk'];
				$nomVille = $tunnel['v_dep'];
				if($id==$tunnel['t_villedepart_fk'])
				{
					$idVille = $tunnel['t_villearrivee_fk'];
					$nomVille = $tunnel['v_ar'];
				}
				$progres = $tunnel['t_progres'];
				if($progres >= 100)
				{
					$progres = 'Ouvert';
				}
				else
				{
					$progres .= '%';
				}

				echo '<li>Tunnel vers <a href="ville.php?id=' . $idVille . '">' . $nomVille . '</a> : ' . $progres . '</li>';
			}
		?>
	</ul>
</body>
</html>