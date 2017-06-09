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
    static private $_instance;
    /**
     * --------------------------------------------------
     * PROPERTIES
     * --------------------------------------------------
    **/
    private $_get;
    private $_post;
    private $_session;



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
    private function __construct() {
        if( is_null( session_id() ) )
            session_start();

        $this->_get = $_GET;
        $this->_post = $_POST;
        $this->_session = &$_SESSION;

        $_GET = $_POST = NULL;
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
    static public function getInstance() {
        if( !isset( self::$_instance ) )
            self::$_instance = new SRequest;

        return self::$_instance;
    }



    /**
     * --------------------------------------------------
     * METHODS
     * --------------------------------------------------
    **/
    /**
     * getVar - Gets a value contained at the key in the request table, or NULL if the key is not set, or the request itself if no key is requested
     * @param   string  $request
     *          [string     $key]
     * @return
    **/
    protected function getVar( $request, $key = NULL ) {
        return ( isset( $key ) ? ( isset( $request[$key] ) ? $request[$key] : NULL ) : $request );
    }

    /**
     * unset -
     * @param   string  $request
     *          [string     $key]
     * @return
    **/
    public function unset( $request, $key = NULL ) {
        $request = '_' . $request;
        if( isset( $key ) )
            if( isset( $this->$request[$key] ) )
                unset( $this->$request[$key] );
        else
            unset( $this->$request );
    }

    /**
     * get - Gets a value contained in the GET request table
     * @param   [string     $key]
     * @return
    **/
    public function get( $key = NULL ) {
        return $this->getVar( $this->_get, $key );
    }

    /**
     * post - Gets a value contained in the POST request table
     * @param   [string     $key]
     * @return
    **/
    public function post( $key = NULL ) {
        return $this->getVar( $this->_post, $key );
    }

    /**
     * session - Gets a value contained in the SESSION request table or sets if a value is indicated
     * @param   [string     $key]
     *          [string     $value]
     * @return
    **/
    public function session( $key = NULL, $value = NULL ) {
        if( isset( $key ) && isset( $value ) )
            $this->_session[$key] = $value;
        else
            return $this->getVar( $this->_session, $key );
    }
}