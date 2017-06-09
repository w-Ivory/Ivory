<?php
	//Autoload
	function ClassLoader($className)
	{
		if(file_exists('class' . DIRECTORY_SEPARATOR . strtolower($className) . '.class.php'))
		{
			require('class' . DIRECTORY_SEPARATOR . strtolower($className) . '.class.php');
		}
		else if(file_exists('class' . DIRECTORY_SEPARATOR . 'traits' . DIRECTORY_SEPARATOR . strtolower($className) . '.trait.php'))
		{
			require('class' . DIRECTORY_SEPARATOR . 'traits' . DIRECTORY_SEPARATOR . strtolower($className) . '.trait.php');
		}
		else if(strpos($className, 'Exception') !== false && file_exists('class' . DIRECTORY_SEPARATOR . 'exceptions' . DIRECTORY_SEPARATOR . strtolower($className) . '.class.php'))
		{
			require('class' . DIRECTORY_SEPARATOR . 'exceptions' . DIRECTORY_SEPARATOR . strtolower($className) . '.class.php');
		}
	}
	spl_autoload_register('ClassLoader');


	
	
	//Session
	session_start();
	if(isset($_GET['destroy']))
	{
		session_destroy();
		header('location:.');
		exit;
	}
	
	
	//Game
	$game = NULL;
	if(isset($_SESSION['chess']['game']))
	{
		$game = unserialize($_SESSION['chess']['game']);
	}
	else
	{
		$game = new Game;
	}
	
	if($game->Exec($_GET))
	{
		//TODO : sauvegarder le GET
		//Pour recharger une partie : appeler Exec sur une nouvelle instance en passant tout les GETs sauvegardes dans l'ordre.
		//Basiquement, on rejoue la partie.
		//Optimisation : lorsqu'on detecte une entree qui est juste composee du champ promotion, on peut l'ajouter a l'entree precedente
		//(a condition que son champ promotion soit encore vide, mais dans l'etat actuel des choses c'est garantit)
		//format de la table history : game_fk, input_num, cl, ln, promotion
		//input_num est le numero de l'entree dans cette partie
		//L'id est la combinaison de game_fk et input_num
	}
	
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0" />
        <title>Échecs</title>
        <style type="text/css">
	    <!--
	    .chessBoard {
	        border-collapse:collapse;
	        border:none;
	        color:rgb(21,21,21);
	        font-size:15px;
	        /*height:480px;*/
	        position:relative;
	        table-layout:fixed;
	        margin-top:20px;
	        /*width:480px;*/
	    }
	    .chessBoard::before {
	        border-color:transparent;
	        border-style:solid;
	        border-width:10px;

	        border-top-color:rgb(191,186,175);
	        border-right-color:rgb(96,92,84);
	        border-bottom-color:rgb(66,63,58);
	        border-left-color:rgb(173,169,161);
	        
	        content:'';
	        bottom:-10px;
	        height:496px;
	        position:absolute;
	        right:-10px;
	        width:496px;
	        z-index:-1;
	    }
	            .chessBoard tr > th { padding:10px; }
	            .chessBoard tr > td {
	                background-color:rgb(240,217,181);
	                cursor:default;
	                font-family:'Chess Regular', sans-serif;
	                font-size:36px;
	                height:60px;
	                position:relative;
	                text-align:center;
	                vertical-align:middle;
	                width:60px;
	            }
	            .chessBoard tr:first-child > th { padding-bottom:20px; }
	            .chessBoard tr:not(:first-child) > th { padding-right:20px; }
	            .chessBoard tr:nth-child( 2n ) > td:nth-child( 2n+1 ) {
	                background-color:rgb(181,136,99);
	            }
	            .chessBoard tr:nth-child( 2n+1 ) > td:nth-child( 2n ) {
	                background-color:rgb(181,136,99);
	            }
	                .chessBoard tr > td a {
	                    bottom:0;
	                    display:block;
	                    left:0;
	                    position:absolute;
	                    right:0;
	                    text-decoration:none;
	                    top:0;
	                }
	    -->
	</style>
    </head>
    <body>
            <h1>Échecs</h1>
            <a href=".?destroy=1">destroy</a>
<?php
	$error = $game->ConsumeError();
	if($error != '')
	{
		echo 'Erreur! : ' . $error . '<br>';
	}
	
	$couleur = $game->GetPlayingColor();
	if($game->IsPlaying())
	{
		echo 'Aux ' . ($couleur == Piece::WHITE ? 'blancs' : 'noirs') . ' de jouer! <br>';
	}
	else
	{
		echo 'Victoire des ' . ($couleur == Piece::WHITE ? 'blancs' : 'noirs') . '!';
	}
	$game->DrawBoard();
	echo '<br>';
	
	$logs = $game->GetLogs();
	for($i = 0; $i < count($logs); ++$i)
	{
		$end = '   ';
		if($i % 2 == 0)	//Si i est pair
		{
			echo ($i / 2 + 1) . '. ';
		}
		else
		{
			$end = '<br>';
		}
		echo $logs[$i] . $end;
	}
	
	$_SESSION['chess']['game'] = serialize($game);
?>
            <hr />
            <p><em>Pour cet exercice : nous allons recréer un jeu d'échecs simplifié, via des objets.</em></p>
            <p><em><del>La partie ne peut débuter que lorsque deux joueurs sont connectés.</del><br />Une partie peut être interrompue en cours de jeu. <del>Vous devez donc proposer un moyen de la reprendre lorsque les deux mêmes joueurs sont à nouveau connectés.</del><br />Tout au cours de la partie, nous devons disposer de l'historique des coups.</em></p>
            <p><em>Nous ne nous servirons que de quatre types de pièce différents en simplifiant leurs mouvements :</em></p>
            <ul style="font-style:italic;">
                <li><strong>le Roi</strong> : au nombre d'une pièce par équipe, il peut se déplacer d'1 seule case. Le déplacement peut être soit horizontal soit vertical, en avant ou en arrière. Cette pièce ne peut pas sauter par dessus une autre.</li>
                <li><strong>la Reine</strong> : au nombre d'une pièce par équipe, elle peut se déplacer d'un nombre de case illimité. Le déplacement peut être soit horizontal soit vertical, en avant ou en arrière. Cette pièce peut sauter par dessus une autre de sa propre couleur mais pas par dessus une pièce adverse.</li>
                <li><strong>les Cavaliers</strong> : au nombre de deux pièces par équipe, ils peuvent se déplacer de 3 cases. Le déplacement peut être soit horizontal soit vertical, en avant ou en arrière. Cette pièce peut sauter par dessus une autre.</li>
                <li><strong>les Pions</strong> : au nombre de quatre pièces par équipe, ils peuvent se déplacer de 1 case seulement. Le déplacement ne peut être qu'horizontal vers l'avant. Cette pièce ne peut pas sauter par dessus une autre. Une fois arrivée sur la ligne adverse (en bout de plateau), elle permet de récupérer une pièce "mangées". Elle peut alors repartir en sens inverse selon les mêmes règles de déplacement.</li>
            </ul>
            <p><em>Comme aux échecs classiques, on joue au tour par tour : honneur aux blancs !<br />La partie s'arrête lorsque l'un des Rois est <del>"Mate"; à savoir qu'il ne peut plus se déplacer sans risquer d'être </del>"mangé" par une pièce adverse.</em></p>
    </body>
</html>