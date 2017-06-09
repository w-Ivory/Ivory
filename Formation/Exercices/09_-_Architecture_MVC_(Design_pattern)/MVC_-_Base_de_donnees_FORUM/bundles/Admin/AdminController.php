<?php
/**
 * ------------------------------------------------------------
 * ADMIN CONTROLLER
 * (Requires : TypeTest | NavigationManagement | SRequest | KernelException | KernelController)
 * ------------------------------------------------------------
**/
class AdminController extends KernelController {
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
        $sitename = 'Administration';

        $this->render();
    }

    /**
     * Dashboard - Displays the dashboard view
     * @param
     * @return
    **/
    public function dashboardAction() {
        $this->init( __FUNCTION__ );
        $sitename = 'Tableau de bord';

        $this->render();
    }

    /**
     * render - Renders the view
     * @param   [string     $view]
     * @return
    **/
    protected function render( $view = null ) {
        try {
            $login = ( $this->getModAuth()!==null && $this->getModAuth()->getUser()!==null ? $this->getModAuth()->getUser()->getPrenom() : NULL );
            $error = $this->getRequest()->get( '_err' );

            if( $login!==NULL ) :
                include_once( WEBPATH . 'header.php' );
                include( ( isset( $this->getSettings()['view']['path'] ) ? $this->getSettings()['view']['path'] : '' ) . $this->getView() . '.php' );
                include_once( WEBPATH . 'footer.php' );
            else :
                NavigationManagement::redirect( DOMAIN . 'error/403' );
            endif;
        } catch( Exception $e ) {
            throw new KernelException( 'Can not render the <strong>' . $this->_controller . '</strong> view', $e->getCode(), $e );
        }
    }
}