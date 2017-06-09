<?php
require_once( 'libs/montrait.php' );
require_once( 'libs/tError.php' );

class MaClasse {
    use MonTrait, tError {
        MonTrait::error insteadof tError;
        tError::error as errorM;
        MonTrait::Error as protected;
    }

    private $attr;

    public function __construct() {
        $this->attr2 = 'fdxgdljfdgf';
        $this->errorM( $this->attr2 );
    }
}