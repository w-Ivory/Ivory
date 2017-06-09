<?php
abstract class Controller
{
	public $request;

    private $_controller;
    private $_action;

	public function __construct($request)
    {
		$this->request = $request;
        $this->_controller = substr(get_class($this),0,-10);
	}

    public function setAction($action)
    {
        $this->_action = $action;
    }

    public function render($data = array())
    {
        require('App/View/'.$this->_controller.'/'.$this->_action.'.php');
    }
}