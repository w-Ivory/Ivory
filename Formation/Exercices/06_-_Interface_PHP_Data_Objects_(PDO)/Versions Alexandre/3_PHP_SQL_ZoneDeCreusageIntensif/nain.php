<?php
//SELECT * FROM `groupe` LEFT JOIN `taverne` ON `groupe`.`g_taverne_fk` = `t_id` WHERE `g_taverne_fk` IS NULL OR `t_chambres` > (SELECT COUNT(`n_id`) FROM `groupe` AS clients JOIN `nain` ON clients.`g_id` = `n_id` WHERE clients.`g_taverne_fk` = `t_id`)
include('common.php');
$id = NeedGet('id');
//After that line, we know that $_GET['id'] exists


$error = '';
if(isset($_POST['new_group']))
{
	try
	{
		if(($statement = MakeStatement($pdo, 'UPDATE `nain` SET `n_groupe_fk`=:group WHERE `n_id`=:id', array('group'=>$_POST['new_group'], 'id'=>$id))) === false)
		{
			$error = 'Impossible de mettre à jour les données!';
		}
	}
	catch (PDOException $e)
	{
		$error = 'Impossible de mettre à jour les données : ' . $e->getMessage();
	}
}

try
{
	$nain = MakeSelect($pdo, 'SELECT `n_nom`, `n_barbe`, `n_groupe_fk`, `n_ville_fk`, `t_nom`, `g_debuttravail`, `g_fintravail`, `g_taverne_fk`, `t_villedepart_fk`, `t_villearrivee_fk`, Orig.`v_nom` v_natale, Dep.`v_nom` v_depart, Ar.`v_nom` v_arrivee FROM `nain` JOIN `ville` Orig ON `n_ville_fk` = Orig.`v_id` LEFT JOIN `groupe` ON `n_groupe_fk` = `g_id` LEFT JOIN `taverne` ON `g_taverne_fk` = `taverne`.`t_id` LEFT JOIN `tunnel` ON `g_tunnel_fk` = `tunnel`.`t_id` LEFT JOIN `ville` Dep ON `t_villedepart_fk` = Dep.`v_id` LEFT JOIN `ville` Ar ON `t_villearrivee_fk` = Ar.`v_id` WHERE `n_id`=:id', array('id'=>$id));
	$groupes = MakeSelect($pdo, 'SELECT `g_id` FROM `groupe` ORDER BY `g_id` ASC', array(), PDO::FETCH_COLUMN, 0);
}
catch (PDOException $e)
{
	//die($e->getMessage());
	$nain = false;
	$error .= ($error === '' ? '' : ' - ') . $e->getMessage();
}
if($nain === false || $groupes === false)
{
	//query failed, we can't print this page
	BackToIndex();
	die($error);	//Call this for potential logs
}

//Only one result anyway
$nain = $nain[0];

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Page de <?php echo $nain['n_nom']; ?></title>
</head>
<body>
<?php
	if($error != '')
	{
		echo $error . '<br><br>';
	}

	echo 'Le nain '. $nain['n_nom'] . ' a une barbe de ' . $nain['n_barbe'] . 'cm<br>';
	echo 'Originaire de <a href="ville.php?id=' . $nain['n_ville_fk'] . '">' . $nain['v_natale'] . '</a><br>';

	if(isset($nain['g_taverne_fk']))
		echo 'Bois dans <a href="taverne.php?id=' . $nain['g_taverne_fk'] . '">' . $nain['t_nom'] . '</a><br>';

	if(isset($nain['n_groupe_fk']))
	{
		echo 'Membre du <a href="groupe.php?id=' . $nain['n_groupe_fk'] . '">groupe ' . $nain['n_groupe_fk'] . '</a><br>';
		if(isset($nain['t_villedepart_fk']))	//If these are present, all needed data is present
		{
			echo 'Travaille de ' . $nain['g_debuttravail'] . ' à ' . $nain['g_fintravail'] . ' dans le tunnel de <a href="ville.php?id=' . $nain['t_villedepart_fk'] . '">' . $nain['v_depart'] . '</a> à <a href="ville.php?id=' . $nain['t_villearrivee_fk'] . '">' . $nain['v_arrivee'] . '</a><br>';
		}
	}

?>
<hr>
<form method="post" action="">
	<label for="groupSelect">Nouveau groupe :</label>
	<select id="groupSelect" name="new_group">
		<option value="" <?php if(!isset($nain['n_groupe_fk'])) echo 'selected'; ?>>Aucun</option>
		<?php
			foreach ($groupes as $idGroupe)
			{
				echo '<option' . ($idGroupe == $nain['n_groupe_fk'] ? ' selected' : '') . '>' . $idGroupe . '</option>';
			}
		?>
	</select>
	<input type="submit" value="Appliquer" />
</form>

</body>
</html>