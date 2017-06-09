<?php
trait NavigationManagement {
    /**
     * redirect -
     * @param   [string     $uri]
     * @return
    **/
    static public function redirect( $uri = '404.php' ) {
        header( 'Location:' . $uri );
        exit;
    }
}