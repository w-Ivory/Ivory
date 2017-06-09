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
    protected $_request;
    protected $_paths = [];



    /**
     * --------------------------------------------------
     * MAGIC METHODS
     * --------------------------------------------------
    **/
    /**
     * __construct - Class constructor
     * @param   string  $model_path
     *          string  $view_path
     *          array   $request
     * @return  
    **/
    public function __construct( $model_path, $view_path, $request ) {
        $this->_request = $request;
        $this->_paths[ 'model' ] = $model_path;
        $this->_paths[ 'view' ] = $view_path;
    }
}