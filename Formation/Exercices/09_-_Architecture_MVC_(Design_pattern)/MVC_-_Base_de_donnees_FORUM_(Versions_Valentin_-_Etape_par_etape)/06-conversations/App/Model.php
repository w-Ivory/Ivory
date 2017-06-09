<?php
require_once('FW/SPDO.php');
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
	public function getConversations(){
		$stmt = $this->pdo->query(
			"SELECT `c_id`,`c_termine`,`c_date`,COUNT(`m_id`) AS 'm_total'
			 FROM `conversation` 
			 LEFT JOIN `message` ON `m_conversation_fk` = `c_id`
			 GROUP BY `c_id`
			 ORDER BY `c_date`");
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
}