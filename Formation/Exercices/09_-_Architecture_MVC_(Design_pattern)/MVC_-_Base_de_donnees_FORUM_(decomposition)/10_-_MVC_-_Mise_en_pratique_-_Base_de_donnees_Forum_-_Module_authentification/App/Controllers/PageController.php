<?php
require_once( ( defined( 'COREPATH' ) ? COREPATH : '' ) . 'CoreController.php' ); // Loads the core controller
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
        $this->init( __FUNCTION__ );

        $this->render( $this->getCaching() );
    }

    /**
     * contactAction - Displays the contact view
     * @param   
     * @return  
    **/
    public function contactAction() {
        $this->init( __FUNCTION__ );
        
        $this->render( $this->getCaching() );
    }

    /**
     * sendingAction - Proceeds to send the contact form
     * @param   
     * @return  
    **/
    public function sendingAction() {
        $this->init( __FUNCTION__ );
        
        $this->render();
    }
}