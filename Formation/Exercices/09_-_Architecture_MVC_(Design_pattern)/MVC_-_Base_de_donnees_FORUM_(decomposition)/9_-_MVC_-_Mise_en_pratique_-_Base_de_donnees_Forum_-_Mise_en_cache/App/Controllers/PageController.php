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
        $this->setAction( __FUNCTION__ );
        $this->render();
    }

    /**
     * contactAction - Displays the contact view
     * @param   
     * @return  
    **/
    public function contactAction() {
        $this->setAction( __FUNCTION__ );
        $this->render();
    }

    /**
     * sendingAction - Proceeds to send the contact form
     * @param   
     * @return  
    **/
    public function sendingAction() {
        $this->setAction( __FUNCTION__ );
        $this->render();
    }
}