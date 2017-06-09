<?php
class Layout
{
    public function __construct()
    {

    }

    public function wrap($html_to_wrap = ""){

        ob_start();
        require(APP_PATH.DS.'Layout'.DS.'main.php');
        $layout_html = ob_get_contents();
        ob_end_clean();

        return $layout_html;
    }
}