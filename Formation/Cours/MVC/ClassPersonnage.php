<?php
class ClassPersonnage {
    private $nom;
    private $age;

    public function __construct( Array $datas ) {
        $this->hydrate( $datas );
    }

    public function setNom( $value ) {
        $this->nom = $value;
    }
    public function setAge( $value ) {
        if( is_numeric( $value ) )
            $this->age = $value;
    }

    public function getNom() {
        return $this->nom;
    }
    public function getAge() {
        return $this->age;
    }

    public function hydrate( Array $datas ) {
        foreach( $datas as $key=>$value ) {
            $method = 'set' . ucwords( $key );
            if( method_exists( $this, $method ) )
                $this->$method( $value );
        }
    }
}