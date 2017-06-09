<?php
class Model{
	public function getData(){
		$pdo = new PDO('mysql:dbname=chat;host=localhost','root','');
		$stmt = $pdo->query("SELECT `u_nom`,`u_id` FROM `user` ORDER BY `u_nom`");
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
}