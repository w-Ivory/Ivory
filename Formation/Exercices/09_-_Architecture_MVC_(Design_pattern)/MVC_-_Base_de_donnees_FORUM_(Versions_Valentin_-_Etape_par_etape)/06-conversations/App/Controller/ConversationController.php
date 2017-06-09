<?php
require_once('FW/Controller.php');
class ConversationController extends Controller{
	
	public function indexAction(){
		require_once('App/Model.php');
		$model = new Model();
		$conversations = $model->getConversations();
		require('App/View/Conversation/index.php');
	}
}