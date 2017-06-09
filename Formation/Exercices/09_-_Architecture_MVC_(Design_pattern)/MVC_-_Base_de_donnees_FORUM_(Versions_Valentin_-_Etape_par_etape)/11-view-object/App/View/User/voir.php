<!doctype html>
<html>
<head>
	<title></title>
	<meta charset="utf-8"/>
</head>
<body>
	<h1>voirAction from UserController</h1>
	<?php
	if ($this->user) {
		echo '<h2> Id: '.$this->user['u_id'].'</h2>';
		echo '<p>'.$this->user['u_nom'].' '.$this->user['u_prenom'].'</p>';
		echo '<p>'.$this->user['u_date_naissance'].'</p>';
	} else {
		echo '<p style="color:red">Aucun utilisateur trouvé</p>';
	}
	?>
</body>
</html>