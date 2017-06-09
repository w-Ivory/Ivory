<?php
class User {
    const TABLE = 'user';
    
    private $u_id;
    private $u_login;
    private $u_prenom;
    private $u_nom;
    private $u_date_naissance;
    private $u_date_inscription;
    private $u_rang_fk;

    public function __construct( $user ) {
        $this->hydrate( $user );
    }

    public function setId( $value ) {
        if( is_numeric( $value ) )
            $this->u_id = $value;
    }
    public function setLogin( $value ) {
        if( !is_null( $value ) )
            $this->u_login = $value;
    }
    public function setPrenom( $value ) {
        if( !is_null( $value ) )
            $this->u_prenom = $value;
    }
    public function setNom( $value ) {
        if( !is_null( $value ) )
            $this->u_nom = $value;
    }
    public function setDateNaissance( $value ) {
        if( $this->validateDate( $value, 'Y-m-d' ) )
            $this->u_date_naissance = $value;
    }
    public function setDateInscription( $value ) {
        if( $this->validateDate( $value ) )
            $this->u_date_inscription = $value;
    }
    public function setRangFk( $value ) {
        if( is_numeric( $value ) )
            $this->u_rang_fk = $value;
    }


    public function getId() {
        return $this->u_id;
    }
    public function getLogin() {
        return $this->u_login;
    }
    public function getPrenom() {
        return $this->u_prenom;
    }
    public function getNom() {
        return $this->u_nom;
    }
    public function getDateNaissance() {
        return $this->u_date_naissance;
    }
    public function getDateInscription() {
        return $this->u_date_inscription;
    }
    public function getRangFk() {
        return $this->u_rang_fk;
    }


    public function __toString() {
        return 'ID : ' . $this->getId() . '<br />
Login : ' . $this->getLogin() . '<br />
Prénom : ' . $this->getPrenom() . '<br />
Nom : ' . $this->getNom() . '<br />
Date de naissance : ' . $this->getDateNaissance() . ' (' . $this->calculAge( 'y' ) . ')<br />
Date d\'inscription : ' . $this->getDateInscription() . '<br />
Rang : ' . $this->getRangFk() . '<br />';
    }


    public function hydrate( $user ) {
        foreach( $user as $key=>$value ) {
            $key = substr( $key, 2 );
            $key = str_replace( '_', ' ', $key );
            $key = ucwords( $key );
            $key = str_replace( ' ', '', $key );
            $key = 'set' . $key;

            if( method_exists( $this, $key ) )
                $this->$key( $value );
        }
    }


    private function validateDate( $date, $format = 'Y-m-d H:i:s' ) {
        $d = DateTime::createFromFormat( $format, $date );
        return $d && $d->format( $format ) == $date;
    }

    public function calculAge( $format ) {
        switch( $format ) {
            case 'y':
                return date_diff( date_create( date( 'Y-m-d' ) ), date_create( $this->getDateNaissance() ) )->format( '%y' ) . ' ans';
                break;
        }
    }
}