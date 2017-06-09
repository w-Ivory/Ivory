<!doctype html>
<html>
<head>
	<title></title>
	<meta charset="utf-8"/>
</head>
<body>
	<h1>The View</h1>
	<?php 
	// var_dump($data);
	$liste = '';
	foreach ($data as $user) {
		$liste .= '
		<li>
			<a href="index.php?action=voir&id='.$user['u_id'].'">
				'.$user['u_id'].':'.$user['u_nom'].'
			</a>
		</li>';
	}
	echo $liste;
	 ?>
</body>
</html>