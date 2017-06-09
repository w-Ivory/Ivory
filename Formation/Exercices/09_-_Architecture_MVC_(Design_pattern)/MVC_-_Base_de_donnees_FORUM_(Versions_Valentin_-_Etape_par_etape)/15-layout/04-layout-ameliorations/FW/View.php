<?php
class View
{
    private $_controller;
    private $_action;
    private $_layout;
    private $_page_title;

    public $rendered = false;

    public function __construct($controller,$action)
    {
        $this->_controller = $controller;
        $this->_action = $action;
        $this->_layout = new Layout($this);
    }

    public function render($view = null,$layout = null)
    {   
        if (!isset($view)) {
            $view = $this->_action;
        }
        $this->rendered = true;

        ob_start();
        require(ROOT.DS.'App'.DS.'View'.DS.$this->_controller.DS.$view.'.php');
        $html = ob_get_contents();
        ob_end_clean();

        $this->_layout->setLayout($layout);
        $html = $this->_layout->wrap($html);
        
        return $html;
    }

    public function disableRender()
    {
        $this->view->rendered=false;
    }

    public function setTitle($title)
    {
        $this->_page_title = $title;
    }
    public function getTitle()
    {
        return $this->_page_title;
    }
}