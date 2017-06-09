<?php
class ConversationController extends Controller
{
    
    public function indexAction()
    {
        $conversationModel = new ConversationModel();
        $this->view->conversations = $conversationModel->getConversations();
        $this->render();
       
    }
}
