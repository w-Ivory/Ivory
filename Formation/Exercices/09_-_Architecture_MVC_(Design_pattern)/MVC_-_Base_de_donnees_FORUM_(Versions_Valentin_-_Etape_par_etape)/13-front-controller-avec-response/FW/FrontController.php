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

        if (method_exists($appController, $actionMethodName)) {
            $appController->setAction($actionName);
            //Déclenchement de l'action
            $appController->$actionMethodName();
            $this->_response = $appController->getResponse();
        } else {
            throw new Exception("Error: No action => ".$controllerClassName."::".$actionMethodName."()", 1);
        }


        echo $this->_response;

    }
}