<!doctype html>
<html>
<head>
	<title></title>
	<meta charset="utf-8"/>
</head>
<body>
	<h1>view : voirAction </h1>
	<?php
	if($user){
		echo '<h2> Id: '.$user['u_id'].'</h2>';
		echo '<p>'.$user['u_nom'].' '.$user['u_prenom'].'</p>';
		echo '<p>'.$user['u_date_naissance'].'</p>';
	}else{
		echo '<p style="color:red">Aucun utilisateur trouvé</p>';
	}
	?>
</body>
</html>