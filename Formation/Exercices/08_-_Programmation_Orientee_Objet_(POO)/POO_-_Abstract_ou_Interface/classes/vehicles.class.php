<?php
/**
 * --------------------------------------------------
 * CLASSES
 * --------------------------------------------------
**/

/**
 * Définir un véhicule.
 * Description :
 *     Classe abstraite implémentant l'interface iTransport.
 * Méthodes :
 *     - sit : impose l'écriture du placement dans/sur le véhicule.
**/
abstract class Vehicles implements iTransport {
    public function __construct() {
        echo '<ol>';
    }
    public function __destruct() {
        echo '</ol>';
    }

    abstract public function sit();
}