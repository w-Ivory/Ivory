<?php
require_once( ( defined( 'COREPATH' ) ? COREPATH : '' ) . 'SRequest.php' ); // Loads the singleton for GET/POST request (Only useful if the automatic loading is not used)
require_once( ( defined( 'COREPATH' ) ? COREPATH : '' ) . 'CoreView.php' ); // Loads the core view
require_once( ( defined( 'COREPATH' ) ? COREPATH : '' ) . 'CoreException.php' ); // Loads the core exception
/**
 * ------------------------------------------------------------
 * CORE CONTROLLER
 * ------------------------------------------------------------
**/
abstract class CoreController {
    /**
     * --------------------------------------------------
     * PROPERTIES
     * --------------------------------------------------
    **/
    protected $_model;
    protected $_view;
    protected $_request;
    protected $_settings;
    protected $_mod_auth;

    private $_controller;
    private $_action;
    private $_caching;


    /**
     * --------------------------------------------------
     * MAGIC METHODS
     * --------------------------------------------------
    **/
    /**
     * __construct - Class constructor
     * @param   object  $request
     *          array   $settings
     * @return  
    **/
    public function __construct( SRequest $request, $settings = array() ) {
        $this->_request = $request;
        $this->_settings = $settings;
        $this->_controller = substr( get_class( $this ), 0, strlen( 'Controller' )*(-1) );
        $this->_caching = ( isset( $settings['cache']['delay'] ) && $settings['cache']['delay']>0 ? true : false );

        if( method_exists( $this, 'preload' ) ) $this->preload();
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
     * @param   
     * @return  
    **/
    protected function setView() {
        try {
            $this->_view = new CoreView( $this->_controller, $this->_action, ( isset( $this->_settings['view']['path'] ) ? $this->_settings['view']['path'] : '' ) );
            $this->_view->setLayout( ( isset( $this->_settings['layout']['path'] ) ? $this->_settings['layout']['path'] : '' ) );
            $this->_view->setCache( ( isset( $this->_settings['cache']['delay'] ) ? $this->_settings['cache']['delay'] : '' ), ( isset( $this->_settings['cache']['path'] ) ? $this->_settings['cache']['path'] : '' ) );
            $this->_view->login = ( $this->_mod_auth!==null ? $this->_mod_auth->getLogin() : null );
        } catch( CoreException $e ) {
            throw new CoreException( $e->getMessage(), $e->getCode(), $e );
        } catch( Exception $e ) {
            throw new CoreException( 'Can not declare a new view object', $e->getCode(), $e );
        }
    }

    /**
     * setModel - 
     * @param   
     * @return  
    **/
    protected function setModel() {
        $modelName = $this->_controller . 'Model'; // Defines the default model's name

        if( file_exists( ( isset( $this->_settings['model']['path'] ) ? $this->_settings['model']['path'] : '' ) . $modelName . '.php' ) ) :
            require_once( ( isset( $this->_settings['model']['path'] ) ? $this->_settings['model']['path'] : '' ) . $modelName . '.php' );
            $this->_model = new $modelName();
        else : throw new CoreException( 'Can not find the specified model' );
        endif;
    }



    /**
     * --------------------------------------------------
     * GETTERS
     * --------------------------------------------------
    **/
    /**
     * getView - 
     * @param   
     * @return  
    **/
    protected function getView() {
        return $this->_view;
    }

    /**
     * getModel - 
     * @param   
     * @return  
    **/
    protected function getModel() {
        return $this->_model;
    }

    /**
     * getCaching - 
     * @param   
     * @return  
    **/
    protected function getCaching() {
        return $this->_caching;
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
        $this->_mod_auth = new AuthModule( ( defined( 'APP_TAG' ) ? APP_TAG : '' ) );
    }

    /**
     * launcher - Launches the action
     * @param   string  $action
     * @return  
    **/
    public function launcher( $action ) {
        try {
            if( method_exists( $this, $action ) ) $this->$action();
            else throw new CoreException( 'Can not find the specified controller\'s method' );
        } catch( Exception $e ) {
            throw new CoreException( 'Can not launch the application controller\'s method', $e->getCode(), $e );
        }
    }

    /**
     * init - Initiates the action
     * @param   string  $action
     * @return  
    **/
    protected function init( $action ) {
        $this->setAction( $action );
        $this->setView();
    }

    /**
     * render - Renders the view
     * @param   string  $view
     * @return  
    **/
    protected function render( $cache = false, $view = null, $layout = null ) {
        try {
            echo $this->_view->render( $cache, $view, $layout );
        } catch( CoreException $e ) {
            throw new CoreException( $e->getMessage(), $e->getCode(), $e );
        } catch( Exception $e ) {
            throw new CoreException( 'Can not render the view', $e->getCode(), $e );
        }
    }

    /**
     * disableCache - Disables the cache
     * @param   
     * @return  
    **/
    protected function disableCache() {
        $this->_caching = false;
    }
}