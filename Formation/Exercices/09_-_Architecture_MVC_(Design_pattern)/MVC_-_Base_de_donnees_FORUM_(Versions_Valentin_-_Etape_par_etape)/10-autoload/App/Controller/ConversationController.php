<?php
class ConversationController extends Controller
{
    
    public function indexAction()
    {
        $conversationModel = new ConversationModel();
        $conversations = $conversationModel->getConversations();
        require('App/View/Conversation/index.php');
    }
}
