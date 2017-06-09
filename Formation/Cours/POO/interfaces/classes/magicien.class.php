<?php
require_once( 'perso.class.php' );
require_once( 'interfaces/attaquer.interface.php' );

class Magicien extends Perso implements Attaquer {
    public function test() {
        echo 'test';
    }
    public function jeterSort() {}
}