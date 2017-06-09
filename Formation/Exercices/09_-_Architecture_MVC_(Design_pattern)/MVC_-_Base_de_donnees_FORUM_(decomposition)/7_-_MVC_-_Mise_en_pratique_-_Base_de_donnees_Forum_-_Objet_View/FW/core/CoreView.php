<?php
/**
 * ------------------------------------------------------------
 * CORE VIEW
 * ------------------------------------------------------------
**/
class CoreView {
    /**
     * --------------------------------------------------
     * PROPERTIES
     * --------------------------------------------------
    **/
    private $_controller;
    private $_action;
    private $_views_path;
    private $_ds;



    /**
     * --------------------------------------------------
     * MAGIC METHODS
     * --------------------------------------------------
    **/
    /**
     * __construct - Class constructor
     * @param   string  $controller
     *          string  $action
     * @return  
    **/
    public function __construct( $path, $ds, $controller, $action ) {
        $this->_views_path = $path;
        $this->_ds = $ds;
        $this->_controller = $controller;
        $this->_action = $action;
    }



    /**
     * --------------------------------------------------
     * METHODS
     * --------------------------------------------------
    **/
    /**
     * render - Renders the view
     * @param   
     * @return  
    **/
    public function render( $path = null ) {
        if( isset( $path ) ) include( $this->_views_path . $path );
        else include( $this->_views_path . $this->_controller . $this->_ds . $this->_action . '.php' );
    }

    /**
     * enableRendering - Enables rendering
     * @param   
     * @return  
    **/
    public function enableRendering() {
        $this->view->rendered = true;
    }

    /**
     * disableRendering - Disables rendering
     * @param   
     * @return  
    **/
    public function disableRendering() {
        $this->view->rendered = false;
    }
}