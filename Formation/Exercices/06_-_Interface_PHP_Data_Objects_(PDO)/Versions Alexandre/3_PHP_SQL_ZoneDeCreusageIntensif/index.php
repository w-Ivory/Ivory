<?php
	include('common.php');

	try
	{
		/*$statement = $pdo->query('UPDATE `nain` SET `n_groupe_fk`=42 WHERE `n_id`=9');
		var_dump($statement);*/
		$nains = MakeSelect($pdo, 'SELECT `n_id`,`n_nom` FROM `nain` ORDER BY `n_nom` ASC');
		$villes = MakeSelect($pdo, 'SELECT `v_id`,`v_nom` FROM `ville` ORDER BY `v_nom` ASC');
		$tavernes = MakeSelect($pdo, 'SELECT `t_id`,`t_nom` FROM `taverne` ORDER BY `t_nom` ASC');
		$groupes = MakeSelect($pdo, 'SELECT `g_id` FROM `groupe` ORDER BY `g_id` ASC', array(), PDO::FETCH_COLUMN, 0);
	}
	catch(PDOException $e)
	{
		die($e->getMessage());
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Toujours plus de nains</title>
</head>
<body>
	<form method="get" action="nain.php">
		<select name="id">
			<?php
				foreach ($nains as $nain)
				{
					echo '<option value=' . $nain['n_id'] . '>' . $nain['n_nom'] . '</option>';
				}
			?>
		</select>
		<input type="submit" value="Trouver nain"/>
	</form>
	<form method="get" action="ville.php">
		<select name="id">
			<?php
				foreach ($villes as $ville)
				{
					echo '<option value=' . $ville['v_id'] . '>' . $ville['v_nom'] . '</option>';
				}
			?>
		</select>
		<input type="submit" value="Trouver ville"/>
	</form>
	<form method="get" action="taverne.php">
		<select name="id">
			<?php
				foreach ($tavernes as $taverne)
				{
					echo '<option value=' . $taverne['t_id'] . '>' . $taverne['t_nom'] . '</option>';
				}
			?>
		</select>
		<input type="submit" value="Trouver taverne"/>
	</form>
	<form method="get" action="groupe.php">
		<select name="id">
			<?php
				foreach ($groupes as $groupe)
				{
					echo '<option>' . $groupe . '</option>';	//Used PDO::FETCH_COLUMN, not associative
				}
			?>
		</select>
		<input type="submit" value="Trouver groupe"/>
	</form>
</body>
</html>