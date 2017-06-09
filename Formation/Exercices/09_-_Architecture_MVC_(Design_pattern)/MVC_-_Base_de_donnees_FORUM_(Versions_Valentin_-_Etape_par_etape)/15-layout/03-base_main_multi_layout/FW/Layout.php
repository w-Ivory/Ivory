<?php
class Layout
{
    private $_layout;
    private $_disabled;
    private $_path;

    public function __construct()
    {
        $this->_path = APP_PATH.DS.'Layout';
        $this->_disabled = !file_exists($this->_path);
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

    public function wrap($html = "")
    {
        if (!$this->_disabled) {
            $layout_path = $this->_path.DS.$this->_layout.'.php';
            if (file_exists($layout_path)) {
                ob_start();
                require($layout_path);
                $html = ob_get_contents();
                ob_end_clean();
            }else{
                throw new Exception("Layout ".$this->_layout." not found in ".$layout_path);
            }
        }
        return $html;
    }
}
