<?php
abstract class Controller
{

    public $request;
    public $view;

    private $_action;
    private $_controller;

    private $_response;

    public function __construct($request)
    {
        $this->request = $request;
        $this->_controller = substr(get_class($this),0,-10);
    }

    public function setAction($action)
    {
        $this->_action = $action;
        $this->view = new View($this->_controller,$this->_action);
    }

    public function renderView($view = null)
    {
        if (!$this->view->rendered) {
            $this->_response = $this->view->render($view);
        }
    }

    public function getResponse(){
        return $this->_response;
    }

}