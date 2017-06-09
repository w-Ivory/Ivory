<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Calculatrice</title>
</head>
<body>
<form action="" method="post">
	<input type="number" name="a" step="0.001">
	<select name="op">
		<option>+</option>
		<option>-</option>
		<option>*</option>
		<option>/</option>
	</select>
	<input type="number" name="b" step="0.001">
	<input type="submit" value="=">
	<?php
	if(isset($_POST) && array_key_exists('a', $_POST) && array_key_exists('b', $_POST) && array_key_exists('op', $_POST))
	{
		$a = $_POST['a'];
		$b = $_POST['b'];
		$op = $_POST['op'];
		if(!(is_numeric($a) && is_numeric($b)))
		{
			echo 'Entrées non valides!';
		}
		else
		{
			switch ($op)
			{
			case '+':
				echo $a + $b;
				break;

			case '-':
				echo $a - $b;
				break;

			case '*':
				echo $a * $b;
				break;

			case '/':
				if($b == 0)
				{
					echo '<img src=divide-by-zero.jpg>';
				}
				else
				{
					echo $a / $b;
				}
				break;
				
			default:
				echo 'Opération invalide!';
			}
		}
	}
	?>
</form>
</body>
</html>