<?php
include('data.php');
session_start();

function AfficherChapitre($num, $data)
{
	$texte = nl2br($data[$num]['texte']);
	echo '<article>';
	echo '<p>' . $texte . '</p>';
	echo '<form action="" method="post">';
		if(count($data[$num]['choix']) == 1)
		{
			echo '<input type="hidden" name="choice" value="0">' . $data[$num]['choix'][0]['texte'];
		}
		else
		{
			echo '<select name="choice">';
			foreach ($data[$num]['choix'] as $choiceNum => $choice)
			{
				//On peut choisir d'utiliser differentes donnees pour transmettre le choix :
				// - Le texte du choix($choice['texte']) : Pas pratique a traiter
				// - La cle du chapitre suivant($choice['page']) : Leger et facile a traiter, mais permet d'acceder a n'importe quel chapitre si modifie
				// - La cle du choix($choiceNum) : Leger et facile a traiter, si modifie donne juste un choix inexistant(donc facile a detecter!)
				echo '<option value="' . $choiceNum . '">' . $choice['texte'] . '</option>';
			}
			echo '</select>';
		}
		echo '<input type="submit" value="Valider">';
	echo '</form></article>';
}


//Premier lancement ou donnees corrompues
if((!array_key_exists('txtAdventure', $_SESSION)) || !array_key_exists($_SESSION['txtAdventure'], $story))
{
	$_SESSION['txtAdventure'] = 0;
}

//Traitement du choix
if(isset($_POST) && array_key_exists('choice', $_POST))
{
	//Si le choix designe existe
	if(array_key_exists($_POST['choice'], $story[$_SESSION['txtAdventure']]['choix']))
	{
		//Le definir comme page actuelle
		$_SESSION['txtAdventure'] = $story[$_SESSION['txtAdventure']]['choix'][$_POST['choice']]['page'];
	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Text Adventure</title>
</head>
<body>
	<?php AfficherChapitre($_SESSION['txtAdventure'], $story); ?>
</body>
</html>