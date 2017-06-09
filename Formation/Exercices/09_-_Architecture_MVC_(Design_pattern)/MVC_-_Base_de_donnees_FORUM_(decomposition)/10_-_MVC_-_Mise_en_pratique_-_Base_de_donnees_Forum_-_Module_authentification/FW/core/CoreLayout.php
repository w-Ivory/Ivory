<?php
require_once( ( defined( 'COREPATH' ) ? COREPATH : '' ) . 'CoreException.php' ); // Loads the core exception
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
    private $_view;
    private $_path;
    private $_disabled;



    /**
     * --------------------------------------------------
     * MAGIC METHODS
     * --------------------------------------------------
    **/
    /**
     * __construct - Class constructor
     * @param   string  $path
     *          object  $view
     * @return  
    **/
    public function __construct( $path, CoreView $view ) {
        $this->_path = $path;
        $this->_view = $view;
        $this->_disabled = !file_exists( $this->_path );
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
        $this->_layout = ( $layout!==null ? $layout : 'main' );
        if( $layout===false) $this->_disabled = true;
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
        extract( $this->_view->getProperties() );
        
        if( !$this->_disabled ) :
            if( file_exists( $this->_path . $this->_layout . '.php' ) ) :
                ob_start();
                include( $this->_path . $this->_layout . '.php' );
                $html = ob_get_contents();
                ob_end_clean();
            else :
                throw new CoreException( 'Layout <strong>' . $this->_layout . '</strong> not found in <strong>' . $this->_path . '</strong>' );
            endif;
        endif;

        return $html;
    }
}