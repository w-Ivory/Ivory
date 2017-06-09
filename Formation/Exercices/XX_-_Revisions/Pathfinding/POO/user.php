<?php
require_once('data2.php');
require_once('Node.class.php');

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
	//initial state
	$toVisit = array();
	$visited = array();
	$node = new Node($from);

	while($node->GetId() != $to)
	{
		foreach ($node->GetNeighbors() as $neighbour)
		{
			//If the neighbour is not already visited
			if(($key = SearchContainsNode($neighbour, $visited)) !== false)
			{
				/*
				if($neighbour->GetCost() < $visited[$key]->GetCost())
				{
					unset($visited[$key]);
					$toVisit[] = $neighbour;
				}
				//*/
			}
			else
			{
				if(($key = SearchContainsNode($neighbour, $toVisit)) !== false)	//If the neigbour is already in the toVisit list
				{
					if($neighbour->GetCost() < $toVisit[$key]->GetCost())
					{
						$toVisit[$key] = $neighbour;
					}
				}
				else
				{
					$toVisit[] = $neighbour;
				}
			}
		}

		$visited[] = $node;

		//get the nearest node
		usort($toVisit,
			function ($node1, $node2) use ($to)
			{
				$cost1 = $node1->GetCostWithHeuristics($to);
				$cost2 = $node2->GetCostWithHeuristics($to);

				return $cost1 == $cost2 ? 0 : ($cost1 < $cost2 ? 1 : -1);
			}
		);
		$node = array_pop($toVisit);
	}

	$result = array();

	do
	{
		$result[] = $node->GetId();
		$node = $node->GetParent();
	} while($node != NULL);

	return array_reverse($result);
}

function SearchContainsNode(Node $node, $nodeArray)
{
	foreach ($nodeArray as $key => $item)
	{
		if($item->GetId() == $node->GetId())
		{
			return $key;
		}
	}

	return false;
}