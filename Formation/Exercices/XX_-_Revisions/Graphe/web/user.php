<?php
require('data.php');

//Returns an array containing the 2D coordiates of $node
//Format : array(x, y) (so [0] for x and [1] for y)
function NodeCoord($node)
{
	return Intern_NodeCoord($node);
}

//Returns the distance between 2 nodes. This is the direct line distance : if the nodes are not neighbors, it will not account for any detour
function Distance($node1, $node2)
{
	return Intern_Distance($node1, $node2);
}

//Returns an array of all nodes neighbors to $node.
//Nodes are simply integers >= 0
function GetNeighbors($node)
{
	return Intern_GetNeighbors($node);
}

//Returns an array of all nodes
//Nodes are simply integers >= 0
function GetAllNodes()
{
	return Intern_GetAllNodes();
}

//$from and $to are nodes
//returns an array, its first element is $from, its last is $to, and the elements in between make the shortest path
function FindPath($from, $to)
{
	//TODO
	return array();	//Pendant l'écriture, tant que vous ne retournez rien, laissez cette ligne pour que l'index reçoive quand même un retour
}