<?php
// METTRE AU PROPRE : Params / Setters / Getters / Returns / Visibilité
/**
 * ------------------------------------------------------------
 * AUTHENTIFICATION MODULE
 * (Requires : ClassUser)
 * ------------------------------------------------------------
**/
class AuthModule {
    /**
     * --------------------------------------------------
     * PROPERTIES
     * --------------------------------------------------
    **/
    private $_tag;
    private $_user;



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
            $this->setUser( unserialize( $_SESSION[$this->_tag]['auth'] ) );
    }

    /**
     * __destruct - Class destructor
     * @param
     * @return
    **/
    public function __destruct() {
        $_SESSION[$this->_tag]['auth'] = serialize( $this->getUser() );
    }



    /**
     * --------------------------------------------------
     * SETTERS
     * --------------------------------------------------
    **/
    /**
     * setUser -
     * @param   ClassUser   $user
     * @return
    **/
    public function setUser( $user ) {
        $this->_user = $user;
    }



    /**
     * --------------------------------------------------
     * GETTERS
     * --------------------------------------------------
    **/
    /**
     * getUser -
     * @param
     * @return
    **/
    public function getUser() {
        return $this->_user;
    }



    /**
     * --------------------------------------------------
     * METHODS
     * --------------------------------------------------
    **/
    /**
     * login -
     * @param   ClassUser   $user
     * @return
    **/
    public function login( ClassUser $user ) {
        $this->setUser( $user );

    }

    /**
     * logout -
     * @param
     * @return
    **/
    public function logout(){
        $this->setUser( NULL );
    }

    /**
     * isAuth -
     * @param
     * @return
    **/
    public function isAuth() {
        return !is_null( $this->getUser() );
    }
}