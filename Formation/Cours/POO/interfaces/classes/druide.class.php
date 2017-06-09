<?php
require_once( 'perso.class.php' );
require_once( 'interfaces/attaquer.interface.php' );

class Druide extends Perso implements Attaquer {
    public function test() {
        echo 'test';
    }
    public function jeterSort() {}
}