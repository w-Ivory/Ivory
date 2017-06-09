<?php
require_once('FW/Model.php');
class ConversationModel extends Model{
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