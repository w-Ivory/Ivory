<?php
require_once('FW/Controller.php');
class ConversationController extends Controller
{
    
    public function indexAction()
    {
        require_once('App/Model/ConversationModel.php');
        $conversationModel = new ConversationModel();
        $conversations = $conversationModel->getConversations();
        require('App/View/Conversation/index.php');
    }
}
