<?php
class Layout
{
    private $_layout;
    private $_disabled;
    private $_path;
    private $_view;
    
    private $_metas;
    private $_stylesheets;
    private $_scripts;

    private $_content;

    public function __construct($view)
    {
        $this->_path = APP_PATH.DS.'Layout';
        $this->_disabled = !file_exists($this->_path);
        $this->_view = $view;
        $this->_metas = array();
        $this->_stylesheets = array();
        $this->_scripts = array();
    }

    public function setLayout($layout = null)
    {
        if (!isset($layout)) {
            $layout = "main";
        }elseif( $layout === false){
            $this->_disabled = true;
        }
        $this->_layout = $layout;
    }

    public function wrap()
    {

        if (!$this->_disabled) {
            $layout_path = $this->_path.DS.$this->_layout.'.php';
            if (file_exists($layout_path)) {
                ob_start();
                require($layout_path);
                $this->_content = ob_get_contents();
                ob_end_clean();
            }else{
                throw new Exception("Layout ".$this->_layout." not found in ".$layout_path);
            }
        }
        return $this->_content;
    }


    public function insert_title($format)
    {
        echo '<title>'.str_replace("%title%", $this->_view->getTitle(),$format).'</title>';
    }

    public function insert_meta($attribute,$value)
    {
        echo '<meta '.$attribute.'="'.$value.'"/>';
    }
    public function insert_metas()
    {
        foreach ($this->_metas as $meta){
            $this->insert_meta($meta['attribute'],$meta['value']);
        }
    }
    public function addMeta($attribute,$value)
    {
        $this->_metas[]=array('attribute'=>$attribute,'value'=>$value);
    }
    public function insert_stylesheets()
    {
        $html = "";
        foreach ($this->_stylesheets as $stylesheet){
            $html .= '<link rel="stylesheet" type="text/css" href="'.APP_DIR.'/Assets/css/'.$stylesheet.'.css" />';
        }
        echo $html;
    }
    public function addStylesheet($stylesheet)
    {  
        $this->_stylesheets[] = $stylesheet;
    }

    public function insert_scripts(){
        echo $this->getScriptsHtml($this->_scripts);
        echo $this->getScriptsHtml($this->_view->getScripts());
    }

    private function getScriptsHtml($array){
        $html = "";
        foreach ($array as $script){

            //if(strpos($script, 'http')===0))
            if(substr($script, 0,4)!=='http'){
                $script = APP_DIR.'/Assets/js/'.$script.'.js';
            }
            $html .= '<script href="'.$script.'" ></script>';
        }
        return $html;
    }

    public function addScript($script){
        $this->_scripts[] = $script;
    }
}
