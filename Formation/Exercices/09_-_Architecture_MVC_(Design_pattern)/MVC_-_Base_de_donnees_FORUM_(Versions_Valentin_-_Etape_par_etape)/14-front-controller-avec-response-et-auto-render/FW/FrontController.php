<?php
//TODO Gestion d'une response
class FrontController
{
    private $_request;
    private $_response;

    public function __construct()
    {
        $this->_request = SRequest::getInstance();
        $this->_response = "";
    }

    public function start()
    {
        //Choix du contrôleur
        $controllerName = str_replace(array('/','.','\\'),'',ucfirst($this->_request->get('controller')));
        if ($controllerName == "") {
            $controllerName = 'Index';
        }
        $controllerClassName = $controllerName.'Controller';


        $appController = new $controllerClassName ($this->_request->getInstance());


        //Choix de l'action
        $actionName = $this->_request->get('action');
        if ($actionName == "") {
            $actionName = 'index';
        }
        $actionMethodName = $actionName.'Action';

        $appController->launchAction($actionName,$actionMethodName);
        $this->_response = $appController->getResponse();




        echo $this->_response;

    }
}