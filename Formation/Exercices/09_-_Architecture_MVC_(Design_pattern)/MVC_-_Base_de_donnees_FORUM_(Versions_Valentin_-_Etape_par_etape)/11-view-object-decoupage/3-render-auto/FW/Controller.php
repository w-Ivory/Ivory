<?php
abstract class Controller
{

    public $request;
    public $view;

    private $_action;
    private $_controller;

    public function __construct($request)
    {
        $this->request = $request;
        $this->_controller = substr(get_class($this),0,-10);
    }

    public function __destruct()
    {
        $this->renderView();
    }

    public function setAction($action)
    {
        $this->_action = $action;
        $this->view = new View($this->_controller,$this->_action);
    }

    public function renderView()
    {
        if (!$this->view->rendered) {
            $this->view->render();
        }
    }

}