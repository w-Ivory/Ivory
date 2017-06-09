<?php
/**
 * ------------------------------------------------------------
 * PLAYER
 * ------------------------------------------------------------
**/
class Player {
    /**
     * --------------------------------------------------
     * PROPERTIES
     * --------------------------------------------------
    **/
    private $_email;
    private $_password;
    private $_nickname;
    private $_date_account_creation;



    /**
     * --------------------------------------------------
     * MAGIC METHODS
     * --------------------------------------------------
    **/
    /**
     * __construct - Class constructor
     * @param   array   $settings
     * @return  
    **/
    public function __construct( $settings ) {
        $this->hydrate( $settings );

        $date = date_parse( $this->getDateAccountCreation() );
        if( $date===false || $date['error_count']>0 || !checkdate( $date['month'], $date['day'], $date['year'] ) )
            $this->setDateAccountCreation( date( 'Y-m-d H:i:s' ) );
    }



    /**
     * --------------------------------------------------
     * SETTERS
     * --------------------------------------------------
    **/
    /**
     * setEmail - 
     * @param   string  $value
     * @return  
    **/
    public function setEmail( $value ) {
        $this->_email = $value;
    }

    /**
     * setPassword - 
     * @param   string  $value
     * @return  
    **/
    public function setPassword( $value ) {
        $this->_password = $value;
    }

    /**
     * resetPassword - 
     * @param   
     * @return  
    **/
    public function resetPassword() {
        $this->_password = null;
    }

    /**
     * setNickname - 
     * @param   string  $value
     * @return  
    **/
    public function setNickname( $value ) {
        $this->_nickname = $value;
    }

    /**
     * setDateAccountCreation - 
     * @param   string  $value
     * @return  
    **/
    public function setDateAccountCreation( $value ) {
        $date = date_parse( $value );
        if( $date!==false && $date['error_count']==0 && checkdate( $date['month'], $date['day'], $date['year'] ) )
            $this->_date_account_creation = $value;
    }



    /**
     * --------------------------------------------------
     * GETTERS
     * --------------------------------------------------
    **/
    /**
     * getEmail - 
     * @param   
     * @return  string
    **/
    public function getEmail() {
        return $this->_email;
    }

    /**
     * getPassword - 
     * @param   
     * @return  string
    **/
    public function getPassword() {
        return $this->_password;
    }

    /**
     * getNickname - 
     * @param   
     * @return  string
    **/
    public function getNickname() {
        return $this->_nickname;
    }

    /**
     * getDateAccountCreation - 
     * @param   string  $locale
     * @return  string
    **/
    public function getDateAccountCreation( $locale = '' ) {
        return $this->_date_account_creation;
    }



    /**
     * --------------------------------------------------
     * METHODS
     * --------------------------------------------------
    **/
    /**
     * hydrate - Hydrate the object properties
     * @param   array   $datas
     * @return  
    **/
    private function hydrate( $datas ) {
        foreach( $datas as $key=>$value ) :
            // $key = substr( $key, ( strlen( $key )-2 )*(-1) );
            $key = str_replace( 'p_', ' ', $key );
            $key = str_replace( '_', ' ', $key );
            $key = ucwords( $key );
            $key = str_replace( ' ', '', $key );
            $method = 'set' . $key;

            if( method_exists( $this, $method) )
                $this->$method( $value );
        endforeach;
    }

    /**
     * show - Formats and displays the data
     * @param   string  $locale
     * @return  
    **/
    public function show( $locale = '' ) {
        echo '
<div class="user">
    <h3>' . ( !is_null( $this->getNickname() ) ? $this->getNickname() : $this->getEmail() ) . '</h3>
    <p><strong>Date d\'inscription</strong><br />' . $this->getDateAccountCreation( $locale ) . '</p>
</div>';
    }
}