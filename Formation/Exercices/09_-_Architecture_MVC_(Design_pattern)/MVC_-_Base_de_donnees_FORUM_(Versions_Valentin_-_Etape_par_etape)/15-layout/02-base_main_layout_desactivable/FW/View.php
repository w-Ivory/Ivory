<?php
class View
{
    private $_controller;
    private $_action;
    private $_layout;


    public $rendered = false;

    public function __construct($controller,$action)
    {
        $this->_controller = $controller;
        $this->_action = $action;
        $this->_layout = new Layout();
    }

    public function render($view = null,$layout = null)
    {   
        if (!isset($view)) {
            $view = $this->_action;
        }
        if (!isset($layout)){
            $layout  = "main";
        }
        $this->rendered = true;

        ob_start();
        require(ROOT.DS.'App'.DS.'View'.DS.$this->_controller.DS.$view.'.php');
        $html = ob_get_contents();
        ob_end_clean();

        if ($layout !== false) {
            $html = $this->_layout->wrap($html);
        }
        
        return $html;
    }

    public function disableRender()
    {
        $this->view->rendered=false;
    }
}