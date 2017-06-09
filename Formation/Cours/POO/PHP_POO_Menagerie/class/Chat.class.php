<?php
class Chat extends Animal
{
	private $robe;

	public function __construct($nom, $age, $robe)
	{
		parent::__construct($nom, $age);
		$this->robe = $robe;
	}

	public function GetRobe()
	{
		return $this->robe;
	}

	public function Manger()
	{
		echo 'Le chat mange le poisson dans ton assiète';
	}

	public function Crier()
	{
		echo 'Le chat miaule. Vous lui pardonnez tout';
	}
}