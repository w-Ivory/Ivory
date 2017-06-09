<?php
/**
 * ------------------------------------------------------------
 * SINGLETON REQUEST
 * ------------------------------------------------------------
**/
class SRequest {
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
    private $_get;
    private $_post;



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
    protected function __construct() {
        $this->_get = $_GET;
        $this->_post = $_POST;
        $_GET = $_POST = null;
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
    public static function getInstance() {
        if( !isset( self::$_instance ) ) self::$_instance = new SRequest;

        return self::$_instance;
    }



    /**
     * --------------------------------------------------
     * METHODS
     * --------------------------------------------------
    **/
    /**
     * getVar - Gets a value contained at the key in the request table, or null if the key is not set, or the request itself if no key is requested
     * @param   array   $request
     *          string  $key
     * @return  
    **/
    private function getVar( $request, $key = null ) {
        // if( isset( $key ) ) :
        //     if( isset( $request[$key] ) ) : return $request[$key];
        //     endif;
        // else : return $request;
        // endif;

        // return null;
        return ( isset( $key ) ? ( isset( $request[$key] ) ? $request[$key] : null ) : $request );
    }

    /**
     * get - Gets a value contained in the GET request table
     * @param   string  $key
     * @return  
    **/
    public function get( $key = null ) {
        return $this->getVar( $this->_get, $key );
    }

    /**
     * post - Gets a value contained in the POST request table
     * @param   string  $key
     * @return  
    **/
    public function post( $key = NULL ) {
        return $this->getVar( $this->_post, $key );
    }
}