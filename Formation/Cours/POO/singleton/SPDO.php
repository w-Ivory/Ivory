<?php
class SPDO {
    protected static $instance;

    public static function getInstance() {
        if( !isset( self::$instance ) ) {
            self::$instance = new PDO( 'mysql:host=localhost;dbname=cours_forum;charset=utf8', 'root', '' );
            echo 'Bonjour !<br >'; // /!\/!\/!\ Uniquement pour la démo mais n'a aucun intérêt sinon !!!!! /!\/!\/!\
        }

        return self::$instance;
    }
}


SPDO::getInstance();
SPDO::getInstance();
SPDO::getInstance();
SPDO::getInstance();
SPDO::getInstance();
SPDO::getInstance();
SPDO::getInstance();
SPDO::getInstance();
SPDO::getInstance();