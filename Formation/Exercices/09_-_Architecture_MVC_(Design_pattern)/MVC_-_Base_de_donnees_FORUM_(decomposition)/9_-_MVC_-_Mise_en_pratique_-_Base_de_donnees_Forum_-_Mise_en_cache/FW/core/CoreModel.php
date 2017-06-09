<?php
require_once( COREPATH . 'SPDO.php' ); // Loads the singleton for PDO
/**
 * ------------------------------------------------------------
 * CORE MODEL
 * ------------------------------------------------------------
**/
abstract class CoreModel {
    /**
     * --------------------------------------------------
     * PROPERTIES
     * --------------------------------------------------
    **/
    protected $_db;



    /**
     * --------------------------------------------------
     * MAGIC METHODS
     * --------------------------------------------------
    **/
    /**
     * __construct - Class constructor
     * @param   
     * @return  
    **/
    public function __construct() {
        $this->_db = SPDO::getInstance( DB_HOST, DB_NAME, DB_LOGIN, DB_PWD )->getPDO(); // Defines PDO instance
    }
}