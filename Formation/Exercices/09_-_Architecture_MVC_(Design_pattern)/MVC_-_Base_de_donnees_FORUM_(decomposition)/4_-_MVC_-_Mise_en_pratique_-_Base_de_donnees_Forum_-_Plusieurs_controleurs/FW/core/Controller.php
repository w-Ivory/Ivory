<?php
/**
 * ------------------------------------------------------------
 * CORE CONTROLLER
 * ------------------------------------------------------------
**/
abstract class Controller {
    /**
     * --------------------------------------------------
     * PROPERTIES
     * --------------------------------------------------
    **/
    protected $_paths = [];
    protected $_db_settings;



    /**
     * --------------------------------------------------
     * MAGIC METHODS
     * --------------------------------------------------
    **/
    /**
     * __construct - Class constructor
     * @param   string  $model_path
     *          string  $view_path
     * @return  
    **/
    public function __construct( $model_path, $view_path, $db = null, $host = null, $dbname = null, $login = null, $pass = null ) {
        $this->_paths[ 'model' ] = $model_path;
        $this->_paths[ 'view' ] = $view_path;

        $this->_db_settings = array(
            'db'        => $db,
            'host'      => $host,
            'dbname'    => $dbname,
            'login'     => $login,
            'pass'      => $pass,
        );
    }
}