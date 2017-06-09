<?php
abstract class Controller
{
	public $request;

    private $_controller;
    private $_action;

    public $view;

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

    public function renderView()
    {
        $this->view->render();
    }
}