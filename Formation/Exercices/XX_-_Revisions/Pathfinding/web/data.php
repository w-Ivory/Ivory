<?php
function GetRawData()
{
	//$nodes=array(array(2,9), array(3,9), array(1, 8), array(3, 8), array(4, 8), array(2, 7), array(5, 7), array(0, 6), array(2, 6), array(3, 6), array(6, 6), array(1, 5), array(4, 5), array(7, 5), array(6, 4), array(7, 4), array(1, 3), array(3, 3), array(5, 3), array(4, 2), array(6, 2), array(1, 1), array(4, 1), array(5, 1), array(3, 0));

	//$edges=array(array(2, 6), array(1, 4, 5), array(6, 8), array(2, 5, 6), array(2, 4, 7), array(1, 3, 4, 9), array(5, 11), array(3, 12), array(6, 10, 12), array(9, 13), array(7, 14), array(8, 9, 17, 18), array(10, 18, 19), array(11, 16), array(19, 16), array(14, 15), array(12, 18, 22), array(12, 13, 17, 20), array(13, 15, 20), array(18, 19, 21, 23, 24), array(20, 24), array(17, 25), array(20, 25), array(20, 21), array(22, 23));

	static $data=array(array(array(2,9), array(3,9), array(1, 8), array(3, 8), array(4, 8), array(2, 7), array(5, 7), array(0, 6), array(2, 6), array(3, 6), array(6, 6), array(1, 5), array(4, 5), array(7, 5), array(6, 4), array(7, 4), array(1, 3), array(3, 3), array(5, 3), array(4, 2), array(6, 2), array(1, 1), array(4, 1), array(5, 1), array(3, 0)), array(array(1, 5), array(0, 3, 4), array(5, 7), array(1, 4, 5), array(1, 3, 6), array(0, 2, 3, 8), array(4, 10), array(2, 11), array(5, 9, 11), array(8, 12), array(6, 13), array(7, 8, 16, 17), array(9, 17, 18), array(10, 15), array(18, 15), array(13, 14), array(11, 17, 21), array(11, 12, 16, 19), array(12, 14, 19), array(17, 18, 20, 22, 23), array(19, 23), array(16, 24), array(19, 24), array(19, 20), array(21, 22)));

	return $data;
}

function square($x)
{
	return $x * $x;
}

function Intern_NodeCoord($node)
{
	return GetRawData()[0][$node];
}

function Intern_Distance($node1, $node2)
{
	$coord1 = Intern_NodeCoord($node1);
	$coord2 = Intern_NodeCoord($node2);

	return sqrt(square($coord1[0] - $coord2[0]) + square($coord1[1] - $coord2[1]));
}

function Intern_GetNeighbors($node)
{
	return GetRawData()[1][$node];
}

function Intern_GetAllNodes()
{
	return range(0, count(GetRawData()[0]) - 1);
}