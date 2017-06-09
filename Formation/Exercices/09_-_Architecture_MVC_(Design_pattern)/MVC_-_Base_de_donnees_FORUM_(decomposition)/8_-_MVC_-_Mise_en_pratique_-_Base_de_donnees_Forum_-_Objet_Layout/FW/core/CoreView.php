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
    private $_layout;
    private $_title;


    /**
     * --------------------------------------------------
     * MAGIC METHODS
     * --------------------------------------------------
    **/
    /**
     * __construct - Class constructor
     * @param   string  $path
     *          string  $controller
     *          string  $action
     * @return  
    **/
    public function __construct( $path, $controller, $action ) {
        $this->_controller = $controller;
        $this->_action = $action;
        $this->_views_path = $path;
        $this->_layout = new CoreLayout( VIEWSPATH . 'Layout' . DS, $this );
    }



    /**
     * --------------------------------------------------
     * SETTERS
     * --------------------------------------------------
    **/
    /**
     * setTitle - 
     * @param   
     * @return  
    **/
    public function setTitle( $title ) {
        $this->_title = $title;
    }



    /**
     * --------------------------------------------------
     * GETTERS
     * --------------------------------------------------
    **/
    /**
     * getTitle - 
     * @param   
     * @return  
    **/
    public function getTitle() {
        return $this->_title;
    }



    /**
     * --------------------------------------------------
     * METHODS
     * --------------------------------------------------
    **/
    /**
     * render - Renders the view wrapped into the layout
     * @param   string  $view
     *          string  $layout
     * @return  
    **/
    public function render( $view = null, $layout = null ) {
        // if( isset( $view ) ) include( $this->_views_path . $view );
        // else include( $this->_views_path . $this->_controller . $this->_ds . $this->_action . '.php' );
        if( !isset( $view ) ) $view = $this->_action;
        $this->rendered = true;

        ob_start();
        include( $this->_views_path . $this->_controller . DS . $view . '.php' );
        $html = ob_get_contents();
        ob_end_clean();

        $this->_layout->setLayout( $layout );
        $html = $this->_layout->wrap( $html );
        
        return $html;
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