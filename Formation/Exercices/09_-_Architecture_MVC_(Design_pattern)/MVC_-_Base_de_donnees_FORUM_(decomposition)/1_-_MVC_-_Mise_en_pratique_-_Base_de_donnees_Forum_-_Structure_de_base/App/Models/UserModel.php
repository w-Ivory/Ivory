<?php
/**
 * ------------------------------------------------------------
 * 
 * ------------------------------------------------------------
**/
class UserModel {
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
     * @param   object  $db
     *          string  $host
     *          string  $dbname
     *          string  $login
     *          string  $pass
     * @return  
    **/
    public function __construct( $db = null, $host = null, $dbname = null, $login = null, $pass = null ) {
        $this->setDb( $host, $dbname, $login, $pass, $db ); // Defines PDO instance
    }



    /**
     * --------------------------------------------------
     * SETTERS
     * --------------------------------------------------
    **/
    /**
     * setDb - Defines a new instance of PDO
     * @param   string  $host
     *          string  $dbname
     *          string  $login
     *          string  $pass
     *          object  $db
     * @return  
    **/
    private function setDb( $host, $dbname, $login, $pass, $db ) {
        try {
            $this->_db = ( empty( $db ) ? new PDO( 'mysql:host=' . $host . ';dbname=' . $dbname . ';charset=utf8', $login, $pass, array( PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES utf8 COLLATE utf8_general_ci', PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION ) ) : $db );
        } catch( PDOException $e ) {
            throw new Exception( $e->getMessage() );
        }
    }



    /**
     * --------------------------------------------------
     * METHODS
     * --------------------------------------------------
    **/
    /**
     * getList - Performs a database select query
     * @param   
     * @return  
     * @return  mixed (array|bool)
    **/
    public function getList() {
        try {
            if( ( $q = $this->_db->query( 'SELECT * FROM `user` ORDER BY `u_prenom` ASC, `u_nom` ASC' ) )!==false ) :
                return $q->fetchAll( PDO::FETCH_ASSOC );
            endif;

            return false;
        } catch( PDOException $e ) {
            die( $e->getMessage() );
        }
    }
}