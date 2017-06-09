<?php
/**
 * ------------------------------------------------------------
 * CORE LAYOUT
 * ------------------------------------------------------------
**/
class CoreLayout {
    /**
     * --------------------------------------------------
     * PROPERTIES
     * --------------------------------------------------
    **/
    private $_layout;
    private $_path;
    private $_disabled;
    private $_view;
    private $_metas;
    private $_stylesheets;



    /**
     * --------------------------------------------------
     * MAGIC METHODS
     * --------------------------------------------------
    **/
    /**
     * __construct - Class constructor
     * @param   string  $path
     *          string  $view
     * @return  
    **/
    public function __construct( $path, $view ) {
        $this->_path = $path;
        $this->_disabled = !file_exists( $this->_path );
        $this->_view = $view;
        $this->_metas = array();
        $this->_stylesheets = array();
    }



    /**
     * --------------------------------------------------
     * SETTERS
     * --------------------------------------------------
    **/
    /**
     * setLayout - 
     * @param   string  $layout
     * @return  
    **/
    public function setLayout( $layout = null ) {
        if( $layout===false) $this->_disabled = true;
        $this->_layout = isset( $layout ) ? $layout : 'main';
    }
    
    /**
     * setMeta - 
     * @param   
     * @return  
    **/
    public function setMeta( $attribute, $value ) {
        $this->_metas[] = array(
            'attribute' => $attribute,
            'value'     => $value
        );
    }
    
    /**
     * setStylesheet - 
     * @param   
     * @return  
    **/
    public function setStylesheet( $stylesheet ) {  
        $this->_stylesheets[] = $stylesheet;
    }



    /**
     * --------------------------------------------------
     * METHODS
     * --------------------------------------------------
    **/
    /**
     * wrap - 
     * @param   
     * @return  
    **/
    public function wrap( $html = '' ) {
        if( !$this->_disabled ) :
            $layout_path = $this->_path . $this->_layout . '.php';
            if( file_exists( $layout_path ) ) :
                ob_start();
                include( $layout_path );
                $html = ob_get_contents();
                ob_end_clean();
            else :
                throw new Exception( 'Layout ' . $this->_layout . ' not found in ' . $layout_path );
            endif;
        endif;

        return $html;
    }

    /**
     * printTitle - 
     * @param   
     * @return  
    **/
    public function printTitle( $value ) {
        echo str_replace( '%title%', $this->_view->getTitle(), $value );
    }
    
    /**
     * printMeta - 
     * @param   
     * @return  
    **/
    public function printMeta( $attribute, $value ) {
        echo '<meta ' . $attribute . '="' . $value . '" />';
    }
    
    /**
     * insertMetas - 
     * @param   
     * @return  
    **/
    public function insertMetas() {
        foreach( $this->_metas as $meta ) :
            $this->printMeta( $meta['attribute'], $meta['value'] );
        endforeach;
    }
    
    /**
     * printStylesheets - 
     * @param   
     * @return  
    **/
    public function printStylesheets() {
        foreach( $this->_stylesheets as $stylesheet ) :
            echo '<link rel="stylesheet" type="text/css" href="' . ASSETSPATH . 'css/' . $stylesheet . '.css" />';
        endforeach;
    }
}