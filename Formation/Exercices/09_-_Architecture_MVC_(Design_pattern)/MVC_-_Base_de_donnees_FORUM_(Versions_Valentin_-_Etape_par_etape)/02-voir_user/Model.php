<?php
class Model{
	public function getData(){
		$pdo = new PDO('mysql:dbname=chat;host=localhost','root','');
		$stmt = $pdo->query("SELECT `u_nom`,`u_id` FROM `user` ORDER BY `u_nom`");
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
	public function getUser($id){
		$pdo = new PDO('mysql:dbname=chat;host=localhost','root','');
		$stmt = $pdo->prepare("SELECT `u_id`,`u_nom`,`u_prenom`,`u_date_naissance` FROM `user` WHERE `u_id` = ?");
		$stmt->execute(array($id));
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}
}