<?php 
require_once('FW/SPDO.php');

class Model{
	protected $pdo;

	public function __construct(){
		$this->pdo = SPDO::getInstance()->getPDO();
	}
}