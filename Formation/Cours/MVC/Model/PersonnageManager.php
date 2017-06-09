<?php
require_once( 'ClassPersonnage.php' );

class PersonnageManager {
    private $datas;

    public function __construct() {
        $this->datas = array(
            'nom'   => 'Damien',
            'age'   => 340
        );
    }

    public function getDatas() {
        return new ClassPersonnage( $this->datas );
    }
}