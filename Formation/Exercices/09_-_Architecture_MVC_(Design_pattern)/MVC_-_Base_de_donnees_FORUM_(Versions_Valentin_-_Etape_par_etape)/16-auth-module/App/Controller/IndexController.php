<?php
class IndexController extends Controller
{    
    private $_authModule;

    public function __preload(){
        $this->_authModule = new AuthModule();
        
    }
    public function indexAction()
    {
        $this->view->login = $this->_authModule->getLogin();
    }

}
