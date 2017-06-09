<?php
class SPDO {
    protected static $instance;

    public static function getInstance() {
        if( !isset( self::$instance ) ) {
            self::$instance = new PDO( 'mysql:host=localhost;dbname=cours_easychess;charset=utf8', 'root', '', array( PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES utf8 COLLATE utf8_general_ci', PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION ) );
        }

        return self::$instance;
    }
}