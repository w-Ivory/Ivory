<?php
/**
 * ------------------------------------------------------------
 * AUTHENTIFICATION CONTROLLER
 * (Requires : TypeTest | NavigationManagement | SRequest | KernelException | KernelController | ClassForum | ClassConversation | ClassMessage)
 * ------------------------------------------------------------
**/
class AuthentificationController extends KernelController {
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
    public function defaultAction() {
        $this->init( __FUNCTION__ );

        $this->render();
    }

    /**
     * loginAction -
     * @param
     * @return
    **/
    public function loginAction() {
        $this->init( __FUNCTION__ );

        try {
            $this->setModel();

            if( $this->getRequest()->post( 'login' )!==NULL && ( $token = $this->getModel()->isAuthMatch( $this->getRequest()->post() ) )!==FALSE ) :
                if( !empty( $token ) ) :
                    $this->getModAuth()->login( $this->getModel()->getUserByToken( $token ) );
                    NavigationManagement::redirect( DOMAIN . '?c=admin&a=dashboard' );
                endif;
            endif;

            NavigationManagement::redirect( DOMAIN . '?c=authentification&_err=login' );
        } catch( Exception $e ) {
            throw new KernelException( 'Can not render the <strong>' . $this->getController() . '</strong> view', $e->getCode(), $e );
        }
    }

    /**
     * logoutAction -
     * @param
     * @return
    **/
    public function logoutAction() {
        $this->init( __FUNCTION__ );

        try {
            $this->setModel();

            $this->getModAuth()->logout();

            NavigationManagement::redirect( DOMAIN );
        } catch( Exception $e ) {
            throw new KernelException( 'Can not render the <strong>' . $this->getController() . '</strong> view', $e->getCode(), $e );
        }
    }
}