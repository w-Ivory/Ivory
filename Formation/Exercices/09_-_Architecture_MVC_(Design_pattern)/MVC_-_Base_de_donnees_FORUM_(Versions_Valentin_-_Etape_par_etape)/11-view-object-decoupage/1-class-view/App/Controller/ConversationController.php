<?php
class ConversationController extends Controller
{
    
    public function indexAction()
    {
        $conversationModel = new ConversationModel();
        $conversations = $conversationModel->getConversations();
        
        $this->renderView(array('conversations'=>$conversations));
    }
}
