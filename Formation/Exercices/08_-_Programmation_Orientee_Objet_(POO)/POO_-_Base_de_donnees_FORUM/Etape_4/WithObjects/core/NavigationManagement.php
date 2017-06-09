<?php
trait NavigationManagement {
    /**
     * redirect - 
     * @param   
     * @return  
    **/
    private function redirect() {
        header( 'Location:404.php' );
        exit;
    }
}