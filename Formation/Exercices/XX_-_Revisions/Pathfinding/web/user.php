<?php
require('data.php');

//Returns an array containing the 2D coordiates of $node
//Format : array(x, y)
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
	return Dijkstra($from, $to);
}

function Dijkstra($from, $to)
{
	//initial state
	$toVisit = array();
	$visited = array();
	$searchNode = array('node' => $from, 'parent' => -1, 'cost' => 0);

	while($searchNode['node'] != $to)
	{
		$node = $searchNode['node'];
		//If we already visited that node, no need to visit again
		
		foreach (GetNeighbors($node) as $neighbour)
		{
			//If the neighbour is not already visited
			if(SearchContainsNode($neighbour, $visited) === false)
			{
				//Prepare data to add to toVisit
				$nSearchNode=array('node' => $neighbour, 'parent' => $node, 'cost' => $searchNode['cost'] + Distance($node, $neighbour));
				if(($key = SearchContainsNode($neighbour, $toVisit)) !== false)	//If the neigbour is already in the toVisit list
				{
					if($nSearchNode['cost'] < $toVisit[$key]['cost'])	//And costs less
					{
						$toVisit[$key] = $nSearchNode;	//Replace it
					}
				}
				else
				{
					$toVisit[] = $nSearchNode;	//Not present yet, add it
				}
			}
		}

		$visited[] = $searchNode;

		//get the nearest node
		usort($toVisit, 'CompareSearchNodes');
		$searchNode = array_pop($toVisit);
	}

	$result = array();

	while($searchNode['parent'] != -1)
	{
		$result[] = $searchNode['node'];
		$searchNode = $visited[array_search($searchNode['parent'], array_column($visited, 'node'))];
	}
	$result[] = $from;

	return array_reverse($result);
}

function AStar($from, $to)
{
	//initial state
	$toVisit = array();
	$visited = array();
	$searchNode = array('node' => $from, 'parent' => -1, 'selfCost' => 0, 'cost' => Distance($from, $to));

	while($searchNode['node'] != $to)
	{
		$node = $searchNode['node'];
		//If we already visited that node, no need to visit again
		
		foreach (GetNeighbors($node) as $neighbour)
		{
			//If the neighbour is not already visited
			if(SearchContainsNode($neighbour, $visited) === false)
			{
				$cost = $searchNode['selfCost'] + Distance($node, $neighbour);
				$nSearchNode=array('node' => $neighbour, 'parent' => $node, 'selfCost' => $cost, 'cost' => $cost + Distance($neighbour, $to));
				if(($key = SearchContainsNode($neighbour, $toVisit)) !== false)	//If the neigbour is already in the toVisit list
				{
					if($cost < $toVisit[$key]['selfCost'])
					{
						$toVisit[$key] = $nSearchNode;
					}
				}
				else
				{
					$toVisit[] = $nSearchNode;
				}
			}
		}

		$visited[] = $searchNode;

		//get the nearest node
		usort($toVisit, 'CompareSearchNodes');
		$searchNode = array_pop($toVisit);
	}

	$result = array();

	while($searchNode['parent'] != -1)
	{
		$result[] = $searchNode['node'];
		$searchNode = $visited[array_search($searchNode['parent'], array_column($visited, 'node'))];
	}
	$result[] = $from;

	return array_reverse($result);
}

function CompareSearchNodes($searchNode1, $searchNode2)
{
	//return -($searchNode1['cost'] <=> $searchNode2['cost']);	//PHP 7
	$cost1 = $searchNode1['cost'];
	$cost2 = $searchNode2['cost'];

	return $cost1 == $cost2 ? 0 : ($cost1 < $cost2 ? 1 : -1);
}

function SearchContainsNode($node, $searchNodeArray)
{
	return array_search($node, array_column($searchNodeArray, 'node'));
}