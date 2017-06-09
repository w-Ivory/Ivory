<?php
/**
 * ------------------------------------------------------------
 * 
 * ------------------------------------------------------------
**/
class PageController extends CoreController {
    /**
     * --------------------------------------------------
     * METHODS
     * --------------------------------------------------
    **/
    /**
     * defaultAction - Displays the default view
     * @param   
     * @return  
    **/
    public function defaultAction() {
        include( $this->_paths[ 'view' ] . 'default.php' );
    }

    /**
     * contactAction - Displays the contact view
     * @param   
     * @return  
    **/
    public function contactAction() {
        include( $this->_paths[ 'view' ] . 'contact.php' );
    }

    /**
     * sendingAction - Proceeds to send the contact form
     * @param   
     * @return  
    **/
    public function sendingAction() {
        include( $this->_paths[ 'view' ] . 'sent.php' );
    }
}