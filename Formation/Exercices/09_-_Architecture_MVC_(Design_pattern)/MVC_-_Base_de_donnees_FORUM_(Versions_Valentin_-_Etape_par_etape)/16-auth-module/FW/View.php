<?php
class View
{
    private $_controller;
    private $_action;
    private $_layout;
    private $_page_title;

    private $_content;
    private $_scripts;

    public $rendered = false;



    public function __construct($controller,$action)
    {
        $this->_controller = $controller;
        $this->_action = $action;
        $this->_layout = new Layout($this);
        $this->_scripts = array();
    }

    public function render($view = null,$layout = null)
    {   
        if (!isset($view)) {
            $view = $this->_action;
        }
        $this->rendered = true;

        ob_start();
        require(ROOT.DS.'App'.DS.'View'.DS.$this->_controller.DS.$view.'.php');
        $this->_content = ob_get_contents();
        ob_end_clean();

        $this->_layout->setLayout($layout);
        $this->_content  = $this->_layout->wrap();

        
        return $this->_content;
    }

    public function disableRender()
    {
        $this->rendered=true;
    }

    public function setTitle($title)
    {
        $this->_page_title = $title;
    }
    public function getTitle()
    {
        return $this->_page_title;
    }
    public function getContent()
    {
        return $this->_content;
    }

    public function url($params)
    {
        return 'index.php?'.http_build_query($params);
    }

    public function addScript($script)
    {        
        $this->_scripts[] = $script;
    }
    public function getScripts()
    {   
        return $this->_scripts;
    }
}