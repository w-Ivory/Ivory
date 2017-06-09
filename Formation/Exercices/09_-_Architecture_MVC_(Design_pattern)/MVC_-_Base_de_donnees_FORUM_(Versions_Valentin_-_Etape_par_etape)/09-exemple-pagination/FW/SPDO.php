<?php
/**
* 
*/
class SPDO {
	private static $_instance;
	private $pdo;

	private function __construct() {
		$this->pdo = new PDO(CONFIG_PDO_DSN,CONFIG_PDO_USER,CONFIG_PDO_PASSWORD);
	}

	public static function getInstance(){
		if(!isset(self::$_instance)){
			self::$_instance = new SPDO();
		}
		return self::$_instance;
	}

	public function getPDO(){
		return $this->pdo;
	}
}