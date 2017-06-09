<?php
/**
 * ------------------------------------------------------------
 * SINGLETON PDO
 * ------------------------------------------------------------
**/
class SPDO {
    /**
     * --------------------------------------------------
     * STATICS
     * --------------------------------------------------
    **/
    protected static $_instance;
    /**
     * --------------------------------------------------
     * PROPERTIES
     * --------------------------------------------------
    **/
    private $_db;



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
    protected function __construct( $host, $dbname, $login, $pass, $set_names, $collate ) {
        $this->_db = new PDO( 'mysql:host=' . $host . ';dbname=' . $dbname . ';charset=utf8', $login, $pass, array( PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES ' . $set_names . ' COLLATE ' . $collate, PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION ) );
    }



    /**
     * --------------------------------------------------
     * STATIC METHODS
     * --------------------------------------------------
    **/
    /**
     * getInstance - 
     * @param   
     * @return  
    **/
    public static function getInstance( $host = null, $dbname = null, $login = null, $pass = null, $set_names = 'utf8', $collate = 'utf8_general_ci' ) {
        if( !isset( self::$_instance ) ) self::$_instance = new SPDO( $host, $dbname, $login, $pass, $set_names, $collate );

        return self::$_instance;
    }



    /**
     * --------------------------------------------------
     * GETTERS
     * --------------------------------------------------
    **/
    /**
     * getPDO - 
     * @param   
     * @return  
    **/
    public function getPDO() {
        return $this->_db;
    }
}