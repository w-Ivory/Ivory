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

    public function render($path = null)
    {

        // $conversations = $this->conversations;
        //var_dump(get_object_vars($this));
        /*foreach (get_object_vars($this) as $key => $value) {
            $$key = $value;
        }*/
        if(isset($path)){
            include ROOT.DS.'App'.DS.'View'.DS.$path;
        }else{
            include ROOT.DS.'App'.DS.'View'.DS.$this->_controller.DS.$this->_action.'.php';
        }
       
    }
}