<?php
class ConversationController extends Controller
{
    
    public function indexAction()
    {
        $conversationModel = new ConversationModel();
        $conversations = $conversationModel->getConversations();
        
        $this->render(array('conversations'=>$conversations));
    }
}
