<?php
/**
 * ------------------------------------------------------------
 * CORE CONTROLLER
 * ------------------------------------------------------------
**/
abstract class CoreController {
    /**
     * --------------------------------------------------
     * PROPERTIES
     * --------------------------------------------------
    **/
    private $_controller;
    private $_action;
    private $_response;

    protected $_paths = [];
    protected $_request;
    protected $_view;


    /**
     * --------------------------------------------------
     * MAGIC METHODS
     * --------------------------------------------------
    **/
    /**
     * __construct - Class constructor
     * @param   string  $model_path
     *          array   $request
     * @return  
    **/
    public function __construct( $model_path, $view_path, $request ) {
        $this->_request = $request;
        $this->_controller = substr( get_class( $this ), 0, strlen( 'Controller' )*(-1) );
        $this->_paths = array(
            'model' => $model_path,
            'view'  => $view_path
        );
    }



    /**
     * --------------------------------------------------
     * SETTERS
     * --------------------------------------------------
    **/
    /**
     * setAction - 
     * @param   string  $action
     * @return  
    **/
    public function setAction( $action ) {
        $this->_action = substr( $action, 0, strlen( 'Action' )*(-1) );
        $this->_view = new CoreView( $this->_paths[ 'view' ], $this->_controller, $this->_action );
    }

    /**
     * setRendering - 
     * @param   bool    $rendering
     * @return  
    **/
    protected function setRendering( $rendering ) {
        $this->_rendering = $rendering;
    }



    /**
     * --------------------------------------------------
     * METHODS
     * --------------------------------------------------
    **/
    /**
     * render - Renders the view
     * @param   string  $view
     * @return  
    **/
    protected function render( $view = null, $layout = null ) {
        if( !$this->_rendered ) echo $this->_view->render( $view, $layout );
    }

    abstract public function defaultAction();
}