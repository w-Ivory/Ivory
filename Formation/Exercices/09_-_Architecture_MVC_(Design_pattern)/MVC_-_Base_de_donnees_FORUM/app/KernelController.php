<?php
/**
 * ------------------------------------------------------------
 * KERNEL CONTROLLER
 * (Requires : TypeTest | NavigationManagement | SRequest | KernelException)
 * ------------------------------------------------------------
**/
abstract class KernelController {
    use TypeTest;
    use NavigationManagement;

    /**
     * --------------------------------------------------
     * PROPERTIES
     * --------------------------------------------------
    **/
    private $_controller;
    private $_action;
    private $_model;
    private $_view;
    private $_request;
    private $_settings;
    private $_mod_auth;



    /**
     * --------------------------------------------------
     * MAGIC METHODS
     * --------------------------------------------------
    **/
    /**
     * __construct - Class constructor
     * @param   SRequest    $request
     * @return
    **/
    public function __construct( SRequest &$request ) {
        $this->_request = &$request;
        $this->_controller = substr( get_class( $this ), 0, strlen( 'Controller' )*(-1) );

        $this->_settings = array(
            'model'     => array( 'path'  => BUNDLESPATH . $this->_controller . DS ),
            'view'      => array( 'path'  => BUNDLESPATH . $this->_controller . DS . 'Views' . DS ),
        );

        KernelException::$_debug_mode = ( defined( 'DEBUG_MODE' ) && is_bool( DEBUG_MODE ) ? DEBUG_MODE : KernelException::DEBUG_MODE );

        if( method_exists( $this, 'preload' ) )
            $this->preload();
    }



    /**
     * --------------------------------------------------
     * SETTERS
     * --------------------------------------------------
    **/
    /**
     * setAction -
     * @param   string  $action
     * @return
    **/
    protected function setAction( $action ) {
        $this->_action = substr( $action, 0, strlen( 'Action' )*(-1) );
    }

    /**
     * setView -
     * @param   string  $view
     * @return
    **/
    protected function setView( $view ) {
        $this->_view = $view;
    }

    /**
     * setModel -
     * @param
     * @return
    **/
    protected function setModel() {
        try {
            $model = $this->_controller . 'Model'; // Defines the default model's name

            if( file_exists( ( isset( $this->_settings['model']['path'] ) ? $this->_settings['model']['path'] : '' ) . $model . '.php' ) )
                $this->_model = new $model;
            else
                throw new KernelException( 'Can not find the specified model', 120 );
        } catch( Exception $e ) {
            throw new KernelException( 'Can not find the specified model', $e->getCode(), $e );
        }
    }



    /**
     * --------------------------------------------------
     * GETTERS
     * --------------------------------------------------
    **/
    /**
     * getController -
     * @param
     * @return string
    **/
    protected function getController() {
        return $this->_controller;
    }

    /**
     * getAction -
     * @param
     * @return string
    **/
    protected function getAction() {
        return $this->_action;
    }

    /**
     * getModel -
     * @param
     * @return KernelModel
    **/
    protected function getModel() {
        return $this->_model;
    }

    /**
     * getView -
     * @param
     * @return string
    **/
    protected function getView() {
        return $this->_view;
    }

    /**
     * getRequest -
     * @param
     * @return SRequest
    **/
    protected function getRequest() {
        return $this->_request;
    }

    /**
     * getSettings -
     * @param
     * @return Array
    **/
    protected function getSettings() {
        return $this->_settings;
    }

    /**
     * getModAuth -
     * @param
     * @return AuthModule
    **/
    protected function getModAuth() {
        return $this->_mod_auth;
    }



    /**
     * --------------------------------------------------
     * METHODS
     * --------------------------------------------------
    **/
    /**
     * defaultAction - Defines the default action
     * @param
     * @return
    **/
    abstract public function defaultAction();

    /**
     * preload - Calls before any other action
     * @param
     * @return
    **/
    public function preload() {
        $this->_mod_auth = new AuthModule( APP_TAG );
    }

    /**
     * launcher - Launches the action
     * @param   string  $action
     * @return
    **/
    public function launcher( $action ) {
        try {
            if( method_exists( $this, $action ) )
                $this->$action();
            else
                throw new KernelException( 'Can not find the <strong>' . $this->_action . '</strong> specified controller\'s method', 100 );

        } catch( Exception $e ) {
            throw new KernelException( 'Can not launch the <strong>' . $this->_action . '</strong> application controller\'s method', $e->getCode(), $e );
        }
    }

    /**
     * init - Initiates the action
     * @param   string  $action
     * @return
    **/
    protected function init( $action ) {
        $this->setAction( $action );
        $this->setView( $this->_action );
    }

    /**
     * render - Renders the view
     * @param   [string     $view]
     * @return
    **/
    protected function render( $view = NULL ) {
        try {
            $login = ( $this->_mod_auth!==NULL && $this->_mod_auth->getUser()!==NULL ? $this->_mod_auth->getUser()->getPrenom() : NULL );
            $error = SRequest::getInstance()->get( '_err' );

            include_once( WEBPATH . 'header.php' );
            include( ( isset( $this->_settings['view']['path'] ) ? $this->_settings['view']['path'] : '' ) . ( !is_null( $view ) ? $view . '.php' : $this->_view . '.php' ) );
            include_once( WEBPATH . 'footer.php' );
        } catch( Exception $e ) {
            throw new KernelException( 'Can not render the <strong>' . $this->_controller . '</strong> view', $e->getCode(), $e );
        }
    }
}