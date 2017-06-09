<?php
require_once('SPDO.php');
class Model{
	private $pdo;

	public function __construct(){
		$this->pdo = SPDO::getInstance()->getPDO();
	}
	public function getData(){
		$stmt = $this->pdo->query("SELECT `u_nom`,`u_id` FROM `user` ORDER BY `u_nom`");
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
	public function getUser($id){
		$stmt = $this->pdo->prepare("SELECT `u_id`,`u_nom`,`u_prenom`,`u_date_naissance` FROM `user` WHERE `u_id` = ?");
		$stmt->execute(array($id));
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}
}