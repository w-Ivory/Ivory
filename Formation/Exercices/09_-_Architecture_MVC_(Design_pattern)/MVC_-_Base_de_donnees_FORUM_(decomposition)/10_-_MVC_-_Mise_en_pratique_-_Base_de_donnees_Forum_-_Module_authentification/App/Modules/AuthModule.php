<?php
/**
 * ------------------------------------------------------------
 * AUTHENTIFICATION MODULE
 * ------------------------------------------------------------
**/
class AuthModule {
    /**
     * --------------------------------------------------
     * PROPERTIES
     * --------------------------------------------------
    **/
    private $_tag;
    private $_login;



    /**
     * --------------------------------------------------
     * MAGIC METHODS
     * --------------------------------------------------
    **/
    /**
     * __construct - Class constructor
     * @param   string  $tag
     * @return  
    **/
    public function __construct( $tag ) {
        if( !isset( $_SESSION ) )
            session_start();

        $this->_tag = $tag;
        if( isset( $_SESSION[$this->_tag]['auth'] ) )
            $this->setLogin( $_SESSION[$this->_tag]['auth'] );
    }

    /**
     * __destruct - Class destructor
     * @param   
     * @return  
    **/
    public function __destruct() {
        $_SESSION[$this->_tag]['auth'] = $this->getLogin();
    }



    /**
     * --------------------------------------------------
     * SETTERS
     * --------------------------------------------------
    **/
    /**
     * setLogin - 
     * @param   string  $value
     * @return  
    **/
    public function setLogin( $value ) {
        $this->_login = $value;
    }



    /**
     * --------------------------------------------------
     * GETTERS
     * --------------------------------------------------
    **/
    /**
     * getLogin - 
     * @param   
     * @return  
    **/
    public function getLogin() {
        return $this->_login;
    }



    /**
     * --------------------------------------------------
     * METHODS
     * --------------------------------------------------
    **/
    /**
     * login - 
     * @param   
     * @return  
    **/
    public function login( $login ) {
        $this->setLogin( $login );
        
    }

    /**
     * logout - 
     * @param   
     * @return  
    **/
    public function logout(){
        $this->setLogin( null );
    }

    /**
     * isAuth - 
     * @param   
     * @return  
    **/
    public function isAuth() {
        return !is_null( $this->getLogin() );
    }
}