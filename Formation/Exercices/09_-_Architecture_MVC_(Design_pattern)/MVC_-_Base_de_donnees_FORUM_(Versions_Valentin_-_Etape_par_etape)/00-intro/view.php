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
	 ?>
	 <p>
	 	Bonjour <?= $data['nom'];/* Syntaxe <?= à éviter ! */?>
	 </p>
	 <p>Âge : <?php echo $data['age'];?></p>
</body>
</html>