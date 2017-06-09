<?php
class AuthentificationController extends Controller
{
    private $_authModule;

    public function __preload(){
        $this->_authModule = new AuthModule();

    }

    public function indexAction()
    {
    }

    public function connexionAction()
    {
        $this->view->disableRender();

        if ($this->request->post('login')=='Val' && $this->request->post('password')=='123') {
            $this->_authModule->connect('Val');
        }else{

        }
        $this->_redirect(array());
    }
    public function deconnexionAction()
    {
        $this->view->disableRender();
        $this->_authModule->disconnect();
        $this->_redirect(array());
    }

}
