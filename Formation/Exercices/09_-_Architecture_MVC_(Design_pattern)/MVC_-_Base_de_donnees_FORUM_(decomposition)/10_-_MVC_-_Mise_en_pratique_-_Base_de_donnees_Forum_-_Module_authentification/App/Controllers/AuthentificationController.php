<?php
require_once( ( defined( 'COREPATH' ) ? COREPATH : '' ) . 'CoreController.php' ); // Loads the core controller
require_once( ( defined( 'MODULESPATH' ) ? MODULESPATH : '' ) . 'AuthModule.php' ); // Loads the authentification module class
/**
 * ------------------------------------------------------------
 * 
 * ------------------------------------------------------------
**/
class AuthentificationController extends CoreController {
    /**
     * --------------------------------------------------
     * MAGIC METHODS
     * --------------------------------------------------
    **/
    /**
     * __construct - Class constructor
     * @param   object  $request
     *          array   $paths
     * @return  
    **/
    public function __construct( SRequest $request, $paths = array() ) {
        parent::__construct( $request, $paths );
        $this->setModel();
    }



    /**
     * --------------------------------------------------
     * METHODS
     * --------------------------------------------------
    **/
    /**
     * defaultAction - Displays the default view complemented by its data
     * @param   
     * @return  
    **/
    public function defaultAction() {}
    
    /**
     * loginAction - 
     * @param   
     * @return  
    **/
    public function loginAction() {
        $this->setAction( __FUNCTION__ );

        if( $this->getModel()!==null && $this->getModel()->userExists( $this->_request->post( 'login' ) ) ) :
            $this->_mod_auth->login( $this->_request->post( 'login' ) );
            $this->disableCache();
        endif;

        header( 'Location:.' );
    }
    
    /**
     * logoutAction - 
     * @param   
     * @return  
    **/
    public function logoutAction() {
        $this->setAction( __FUNCTION__ );

        $this->_mod_auth->logout();

        header( 'Location:.' );
    }
}