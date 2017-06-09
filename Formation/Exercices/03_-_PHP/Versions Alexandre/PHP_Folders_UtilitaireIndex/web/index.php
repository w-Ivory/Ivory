<?php

define('ASSETS_DIR', 'assets');
define('DS', DIRECTORY_SEPARATOR);

function FormatName($path)
{
	return '<img src="' . ASSETS_DIR . DS . 'icons' . DS . (is_dir($path) ? 'folder' : 'text') . '.gif">' . basename($path);
}

function HasIndex($dirPath)
{
	$elements = scandir($dirPath);

	foreach ($elements as $element)
	{
		$filename = $dirPath . DS . $element;
		if(is_file($filename) && pathinfo($filename, PATHINFO_FILENAME) == 'index')
		{
			return true;
		}
	}
	return false;
}

function WriteElement($path)
{
	if(is_dir($path) && !HasIndex($path))
	{
		return FormatName($path) . DirContent($path);
	}
	else
	{
		return '<a href="' . $path . '">' . FormatName($path) . '</a>';
	}
}

//Retourne le contenu du dossier et des sous-dossiers formate dans une <ul>
function DirContent($dirPath)
{
	$content = scandir($dirPath);

	$resultat = '<ul>';
	foreach ($content as $element)
	{
		$filename = $dirPath . DS . $element;
		if($element != '.' && $element != '..')
		{
			$resultat .= '<li>' . WriteElement($filename) . '</li>';
		}
	}
	return $resultat . '</ul>';
}

?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Index</title>
</head>
<body>
<h1>Contenu des dossiers</h1>
<hr>
<?php
echo DirContent('.');
?>
</body>
</html>