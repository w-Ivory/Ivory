<?php
require('user.php');

$allNodes = GetAllNodes();

$lenght = '?';
$path = array();
if(isset($_GET['from']) && in_array($_GET['from'], $allNodes) && isset($_GET['to']) && in_array($_GET['to'], $allNodes))
{
	$from = (int)$_GET['from'];
	$to = (int)$_GET['to'];

	$path = FindPath($from, $to);
	$lenght = 0;
	if(($size = count($path)) > 1)
	{
		for ($i = 1; $i < $size; ++$i)
		{
			$lenght += Distance($path[$i-1], $path[$i]);
		}
	}
}

define('HFACTOR', 50);
define('WFACTOR', 50);
$image = imagecreatetruecolor(500, 500);
$white = imagecolorallocate($image, 255, 255, 255);
$black = imagecolorallocate($image, 0, 0, 0);
$startColor = imagecolorallocate($image, 0, 255, 0);
$endColor = imagecolorallocate($image, 255, 75, 0);
$pathColor = imagecolorallocate($image, 30, 175, 245);

imagefill($image, 0, 0, $white);	//Draw background

foreach ($allNodes as $node)
{
	$posInPath = array_search($node, $path);
	//select the color
	$nodeColor = $black;
	if($posInPath !== false)
	{
		if(isset($from) && $node == $from)
		{
			$nodeColor = $startColor;
		}
		elseif(isset($to) && $node == $to)
		{
			$nodeColor = $endColor;
		}
		else
		{
			$nodeColor = $pathColor;
		}
	}
	$coord = NodeCoord($node);

	//Draw the node
	imagefilledellipse($image, $coord[0] * WFACTOR, $coord[1] * HFACTOR, 10, 10, $nodeColor);
	imagestring($image, 1, $coord[0] * WFACTOR + 10, $coord[1] * HFACTOR + 10, $node, $nodeColor);

	//Draw edges
	foreach (GetNeighbors($node) as $neighbour)
	{
		if($neighbour > $node)	//Only draw nodes after this one, so we don't draw lines twice
		{
			$edgeColor = $black;

			if($nodeColor != $black)	//Means the current node is in path
			{
				$nPos = array_search($neighbour, $path);
				if($nPos !== false && ($posInPath - $nPos) ** 2 == 1)	//If neighbour is next to this node
				{
					$edgeColor = $pathColor;
				}
			}
			$nCoord = NodeCoord($neighbour);
			imageline($image, $coord[0] * WFACTOR, $coord[1] * HFACTOR, $nCoord[0] * WFACTOR, $nCoord[1] * HFACTOR, $edgeColor);
		}
	}
}

imagepng($image, "graph.png");
imagedestroy($image);

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Graphe</title>
</head>
<body>
	<img src="graph.png">
	Path lenght : <?php echo $lenght; ?>
	<hr>
	<form action="" method="get">
		<label for="from-select">From : </label>
		<select id="from-select" name="from">
		<?php
			foreach ($allNodes as $node)
			{
				echo '<option' . ((isset($from) && $node == $from) ? ' selected' : '') . '>' . $node . '</option>';
			}
		?>
		</select>
		<label for="to-select">To : </label>
		<select id="to-select" name="to">
		<?php
			foreach ($allNodes as $node)
			{
				echo '<option' . ((isset($to) && $node == $to) ? ' selected' : '') . '>' . $node . '</option>';
			}
		?>
		</select>
		<input type="submit">
	</form>
</body>
</html>
