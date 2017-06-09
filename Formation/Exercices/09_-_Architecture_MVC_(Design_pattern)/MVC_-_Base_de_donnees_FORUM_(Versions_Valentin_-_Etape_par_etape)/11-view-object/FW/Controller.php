<?php
abstract class Controller{

    private $_action;
    private $_controller;
    private $_rendered = false;
    private $_rendering = true;

    public $view;
	public $request;

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

    protected function setRendering($rendering)
    {
        $this->_rendering = $rendering;
    }

    protected function render($view = null)
    {
        if ($this->_rendering) {
            if (!$this->_rendered) {
                $this->view->render($view);
                $this->_rendered = true;
            }
        }
    }

    public function __destruct()
    {
        $this->render();
        
    }
}