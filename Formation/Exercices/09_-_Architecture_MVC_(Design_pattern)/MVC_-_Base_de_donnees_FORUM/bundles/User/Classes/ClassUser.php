<?php
/**
 * ------------------------------------------------------------
 * CLASS USER
 * (Requires : TypeTest)
 * ------------------------------------------------------------
**/
class ClassUser {
    use TypeTest;

    /**
     * --------------------------------------------------
     * CONSTANTS
     * --------------------------------------------------
    **/
    const PREFIX = 'u_';
    const DATE_FORMAT = 'Y-m-d';
    const TIME_FORMAT = 'H:i:s';
    const DATETIME_FORMAT = 'Y-m-d H:i:s';
    /**
     * --------------------------------------------------
     * PROPERTIES
     * --------------------------------------------------
    **/
    private $_id;
    private $_login;
    private $_prenom;
    private $_nom;
    private $_date_naissance;
    private $_date_inscription;
    private $_rang_fk;


    /**
     * --------------------------------------------------
     * MAGIC METHODS
     * --------------------------------------------------
    **/
    /**
     * __construct - Class constructor
     * @param   array   $settings   [optional]
     * @return
    **/
    public function __construct( $settings = array() ) {
        $this->hydrate( $settings );
    }



    /**
     * --------------------------------------------------
     * SETTERS
     * --------------------------------------------------
    **/
    /**
     * setId -
     * @param   int     $value
     * @return
    **/
    public function setId( $value ) {
        if( TypeTest::is_valid_int( $value ) )
            $this->_id = $value;
    }

    /**
     * setLogin -
     * @param   string  $value
     * @return
    **/
    public function setLogin( $value ) {
        $this->_login = $value;
    }

    /**
     * setPrenom -
     * @param   string  $value
     * @return
    **/
    public function setPrenom( $value ) {
        $this->_prenom = $value;
    }

    /**
     * setNom -
     * @param   string  $value
     * @return
    **/
    public function setNom( $value ) {
        $this->_nom = $value;
    }

    /**
     * setDateNaissance -
     * @param   datetime    $value
     * @return
    **/
    public function setDateNaissance( $value ) {
        if( TypeTest::is_valid_date( $value, 'Y-m-d' ) )
            $this->_date_naissance = $value;
    }

    /**
     * setDateInscription -
     * @param   datetime    $value
     * @return
    **/
    public function setDateInscription( $value ) {
        if( TypeTest::is_valid_date( $value ) )
            $this->_date_inscription = $value;
    }

    /**
     * setRangFk -
     * @param   int     $value
     * @return
    **/
    public function setRangFk( $value ) {
        if( TypeTest::is_valid_int( $value ) )
            $this->_rang_fk = $value;
    }



    /**
     * --------------------------------------------------
     * GETTERS
     * --------------------------------------------------
    **/
    /**
     * getId -
     * @param
     * @return
    **/
    public function getId() {
        return $this->_id;
    }

    /**
     * getLogin -
     * @param
     * @return
    **/
    public function getLogin() {
        return $this->_login;
    }

    /**
     * getPrenom -
     * @param
     * @return
    **/
    public function getPrenom() {
        return $this->_prenom;
    }

    /**
     * getNom -
     * @param
     * @return
    **/
    public function getNom() {
        return $this->_nom;
    }

    /**
     * getDateNaissance -
     * @param
     * @return
    **/
    public function getDateNaissance() {
        return $this->_date_naissance;
    }

    /**
     * getDateInscription -
     * @param
     * @return
    **/
    public function getDateInscription() {
        return $this->_date_inscription;
    }

    /**
     * getRangFk -
     * @param
     * @return
    **/
    public function getRangFk() {
        return $this->_rang_fk;
    }



    /**
     * --------------------------------------------------
     * METHODS
     * --------------------------------------------------
    **/
    /**
     * hydrate - Sets automatically each properties depending on datas
     * @param   array   $datas
     * @return
    **/
    private function hydrate( $datas ) {
        foreach( $datas as $key=>$value ) :
            $key = preg_replace( '/^' . self::PREFIX . '(.+)$/', '$1', $key );
            $key = str_replace( '_', ' ', $key );
            $key = ucwords( $key );
            $key = str_replace( ' ', '', $key );
            $method = 'set' . $key;

            if( method_exists( $this, $method) )
                $this->$method( $value );
        endforeach;
    }
}