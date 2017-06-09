<?php

include('common.php');
$id=NeedGet('id');

$error='';
try
{
	$tavernesLibres = MakeSelect($pdo, 'SELECT `t_id`, `t_nom`, `t_ville_fk`, (`t_chambres` - COUNT(`nain`.`n_id`)) AS chambresLibres FROM `taverne` LEFT JOIN `groupe` ON `t_id` = `g_taverne_fk` AND `g_id`!=:id LEFT JOIN `nain` ON `g_id` = `n_groupe_fk` GROUP BY `t_id` HAVING chambresLibres >= (SELECT COUNT(`n_id`) FROM `nain` WHERE `n_groupe_fk`=:id);', array('id'=>$id));
}
catch(PDOException $e)
{
	BackToIndex();
	die($e->getMessage());
}

if(isset($_POST['debut']) && isset($_POST['fin']) && isset($_POST['tunnel']) && isset($_POST['taverne']))
{
	//Vérifier que la taverne en POST fait partie des tavernes libres
	$place = false;
	if($_POST['taverne'] === '')
	{
		$place = true;
	}
	else
	{
		foreach ($tavernesLibres as $taverne)
		{
			if($_POST['taverne'] == $taverne['t_id'])
			{
				$place = true;
				break;
			}
		}
	}
	
	if($place)
	{
		try
		{
			$result = MakeStatement($pdo, 'UPDATE `groupe` SET `g_debuttravail`=:debut, `g_fintravail`=:fin, `g_taverne_fk`=:taverne, `g_tunnel_fk`=:tunnel WHERE `g_id`=:id', array('debut'=>$_POST['debut'], 'fin'=>$_POST['fin'], 'tunnel'=>$_POST['tunnel'], 'taverne'=>$_POST['taverne'], 'id'=>$id));
			if($result === false)
				$error = 'Erreur';
		}
		catch(PDOException $e)
		{
			$error = $e->getMessage();
		}
	}
	else
	{
		$error = "Nombre de places dans la taverne insuffisant!";
	}
}

if($error != '')
{
	$error = 'Impossible de mettre les données à jour : ' . $error;
}

try
{
	$groupe = MakeSelect($pdo, 'SELECT `groupe`.*, `t_nom`, dep.`v_nom` v_dep, ar.`v_nom` v_ar, `t_progres`, `t_villedepart_fk`, `t_villearrivee_fk` FROM `groupe` LEFT JOIN `taverne` ON `g_taverne_fk`=`taverne`.`t_id` LEFT JOIN `tunnel` ON `g_tunnel_fk`=`tunnel`.`t_id` LEFT JOIN `ville` dep ON `t_villedepart_fk` = dep.`v_id` LEFT JOIN `ville` ar ON `t_villearrivee_fk` = ar.`v_id` WHERE `g_id`=:id', array('id'=>$id))[0];
	$tunnels = MakeSelect($pdo, 'SELECT `t_id`, `t_progres`, dep.`v_nom` v_dep, ar.`v_nom` v_ar FROM `tunnel` JOIN `ville` dep ON `t_villedepart_fk` = dep.`v_id` JOIN `ville` ar ON `t_villearrivee_fk` = ar.`v_id`');
	$nains = MakeSelect($pdo, 'SELECT `n_id`, `n_nom` FROM `nain` WHERE `n_groupe_fk`=:id', array('id'=>$id));
	//SELECT `groupe`.*, `t_nom`, dep.`v_nom` v_dep, ar.`v_nom` v_ar, `t_progres`, `t_villedepart_fk`, `t_villearrivee_fk`, GROUP_CONCAT(CONCAT('<li><a href=nain.php?id=', `n_id`, '">', `n_nom`, '</a></li>') SEPARATOR '') AS nains FROM `groupe` LEFT JOIN `taverne` ON `g_taverne_fk`=`taverne`.`t_id` LEFT JOIN `tunnel` ON `g_tunnel_fk`=`tunnel`.`t_id` LEFT JOIN `ville` dep ON `t_villedepart_fk` = dep.`v_id` LEFT JOIN `ville` ar ON `t_villearrivee_fk` = ar.`v_id` LEFT JOIN `nain` ON `g_id`=`n_groupe_fk` WHERE `g_id`=:id
}
catch(PDOException $e)
{
	BackToIndex();
	die($e->getMessage());
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<title>Groupe n°<?php echo $groupe['g_id'] ?></title>
</head>
<body>
<?php
	if($error != '')
	{
		echo $error . '<br><br>';
	}

	echo 'Groupe n°' . $groupe['g_id'] . '<br>'
?>

Membres : <br>
	<ul>
		<?php
			foreach ($nains as $nain)
			{
				echo '<li><a href="nain.php?id=' . $nain['n_id'] . '">' . $nain['n_nom'] . '</a></li>';
			}
		?>
	</ul>
<?php
	if(isset($groupe['g_taverne_fk']))
	{
		echo 'Boivent dans <a href="taverne.php?id=' . $groupe['g_taverne_fk'] . '">' . $groupe['t_nom'] . '</a><br>';
	}
	else
	{
		echo 'OH MON DIEU ILS SONT SOBRES!!! Tavernes libres :<ul>';

		foreach ($tavernesLibres as $taverne)
		{
			$conseil = '';
			if(isset($groupe['g_tunnel_fk']) && ($taverne['t_ville_fk'] == $groupe['t_villedepart_fk'] || ($taverne['t_ville_fk'] == $groupe['t_villearrivee_fk'] && $groupe['t_progres'] >= 100) ))
			{
				$conseil = '(conseillée)';
			}

			echo '<li><a href="taverne.php?id=' . $taverne['t_id'] . '">' . $taverne['t_nom'] . $conseil . '</a></li>';
		}

		echo '</ul>';
	}
	if(isset($groupe['g_tunnel_fk']))
		echo ($groupe['t_progres'] >= 100 ? 'Entretiennent' : 'Creusent') . ' de ' . $groupe['g_debuttravail'] . ' à ' . $groupe['g_fintravail'] . ' le tunnel de <a href="ville.php?id=' . $groupe['t_villedepart_fk'] . '">' . $groupe['v_dep'] . '</a> à <a href="ville.php?id=' . $groupe['t_villearrivee_fk'] . '">' . $groupe['v_ar'] . '</a> ' . ($groupe['t_progres'] < 100 ? '('.$groupe['t_progres'].'%)' : '');

?>

<hr>
Changement attributions :
<form action="" method="post">
	<input type="time" name="debut" step=1 value="<?php echo $groupe['g_debuttravail']; ?>"/>
	<input type="time" name="fin" step=1 value="<?php echo $groupe['g_fintravail']; ?>"/>
	<select name="taverne">
		<option value="" <?php if(!isset($groupe['g_taverne_fk'])) echo 'selected'; ?>>Aucune</option>
		<?php
			foreach ($tavernesLibres as $taverne)
			{
				echo '<option value="' . $taverne['t_id'] . '"' . ($groupe['g_taverne_fk'] == $taverne['t_id'] ? ' selected' : '') . '>' . $taverne['t_nom'] . '</option>';
			}
		?>
	</select>
	<select name="tunnel">
		<option value="" <?php if(!isset($groupe['g_tunnel_fk'])) echo 'selected'; ?>>Aucun</option>
		<?php
			foreach ($tunnels as $tunnel)
			{
				echo '<option value="' . $tunnel['t_id'] . '"' . ($groupe['g_tunnel_fk'] == $tunnel['t_id'] ? ' selected' : '') . '>' . $tunnel['v_dep'] . ' -> ' . $tunnel['v_ar'] . '(' . $tunnel['t_progres'] . '%)</option>';
			}
		?>
	</select>
	<input type="submit"/>
</form>
</body>
</html>