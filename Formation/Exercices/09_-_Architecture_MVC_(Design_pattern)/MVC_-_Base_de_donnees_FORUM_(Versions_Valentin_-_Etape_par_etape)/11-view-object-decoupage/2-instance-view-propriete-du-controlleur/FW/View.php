<?php
class View
{
    private $_controller;
    private $_action;

    public function __construct($controller,$action)
    {
        $this->_controller = $controller;
        $this->_action = $action;
    }

    public function render()
    {
        require('App/View/'.$this->_controller.'/'.$this->_action.'.php');
    }
}