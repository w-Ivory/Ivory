<?php
require_once('user.php');

class Node
{
	private $id;
	private $cost;
	private $parent;

	public function __construct($id, Node $parent=NULL)
	{
		$this->id = $id;
		$this->SetParent($parent);
	}

	public function GetId()
	{
		return $this->id;
	}

	public function SetParent(Node $parent=NULL)	//Needed to allow NULL
	{
		$this->parent = $parent;
		if(is_null($this->parent))
		{
			$this->cost = 0;	//No parent means first node
		}
		else
		{
			$this->cost = $this->parent->cost + self::CalcCost($this->id, $this->parent->id);
		}
	}

	public function GetNeighbors()
	{
		$neighbors = array();
		foreach(GetNeighbors($this->id) as $neighbourId)
		{
			$neighbors[] = new Node($neighbourId, $this);
		}

		return $neighbors;
	}

	public function GetCoord()
	{
		return GetCoord($this->id);
	}

	public function GetParent()
	{
		return $this->parent;
	}

	public function GetCost()
	{
		return $this->cost;
	}

	public function GetCostWithHeuristics($targetId)
	{
		return $this->cost + self::Heuristic($this->id, $targetId);
	}

	private static function Heuristic($startId, $targetId)
	{
		/*
		return Distance($startId, $targetId);
		/*/
		return 0;
		//*/
	}

	private static function CalcCost($fromId, $toId)
	{
		return 0;
	}
}