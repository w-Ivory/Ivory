<?php
require_once( 'interfaces/movable.interface.php' );

abstract class Perso implements Movable {
    public function seDeplacerEnAvant() {}
    public function seDeplacerEnArriere() {}
}