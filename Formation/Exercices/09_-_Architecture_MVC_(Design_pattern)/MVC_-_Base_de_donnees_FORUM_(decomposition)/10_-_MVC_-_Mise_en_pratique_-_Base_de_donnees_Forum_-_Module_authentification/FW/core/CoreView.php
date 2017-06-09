<?php
require_once( ( defined( 'COREPATH' ) ? COREPATH : '' ) . 'SRequest.php' ); // Loads the singleton for GET/POST request (Only useful if the automatic loading is not used)
require_once( ( defined( 'COREPATH' ) ? COREPATH : '' ) . 'CoreLayout.php' ); // Loads the core layout
require_once( ( defined( 'COREPATH' ) ? COREPATH : '' ) . 'CoreException.php' ); // Loads the core exception
/**
 * ------------------------------------------------------------
 * CORE VIEW
 * ------------------------------------------------------------
**/
class CoreView {
    /**
     * --------------------------------------------------
     * PROPERTIES
     * --------------------------------------------------
    **/
    private $_controller;
    private $_action;
    private $_path;
    private $_layout;
    private $_cache;

    private $_properties = [];


    /**
     * --------------------------------------------------
     * MAGIC METHODS
     * --------------------------------------------------
    **/
    /**
     * __construct - Class constructor
     * @param   string  $controller
     *          string  $action
     *          string  $path
     * @return  
    **/
    public function __construct( $controller, $action, $path ) {
        /**
         * --------------------------------------------------
         * CORE PREDEFINED CONSTANTS
         * http://php.net/manual/fr/reserved.constants.php
         * --------------------------------------------------
        **/
        if( strtoupper( substr( PHP_OS, 0, 3 ) ) == 'WIN' ) : // If the version of the operating system (provided by the pre-defined constants PHP_OS) corresponds to a Windows kernel,
            if( !defined( 'PHP_EOL') ) : define( 'PHP_EOL', "\r\n" ); endif;
            if( !defined( 'DIRECTORY_SEPARATOR') ) : define( 'DIRECTORY_SEPARATOR', "\\" ); endif;
        else :
            if( !defined( 'PHP_EOL') ) : define( 'PHP_EOL', "\n" ); endif;
            if( !defined( 'DIRECTORY_SEPARATOR') ) : define( 'DIRECTORY_SEPARATOR', "/" ); endif;
        endif;
        if( !defined( 'DS' ) ) define( 'DS', DIRECTORY_SEPARATOR ); // Defines the folder separator connected to the system

        $this->_controller = $controller;
        $this->_action = $action;
        $this->_path = $path;
    }
    
    /**
     * __set - Setter
     * @param   string  $property
     *          mixed   $value
     * @return  
    **/
    public function __set( $property, $value ) {
        $this->_properties[$property] = $value;
    }
    
    /**
     * __get - Getter
     * @param   string  $property
     * @return  mixed
    **/
    public function __get( $property ) {
        return ( isset( $this->_properties ) && array_key_exists( $property, $this->_properties ) ? $this->_properties[$property] : false );
    }



    /**
     * --------------------------------------------------
     * SETTERS
     * --------------------------------------------------
    **/
    /**
     * setLayout - 
     * @param   string  $layout
     * @return  
    **/
    public function setLayout( $layout ) {
        try {
            $this->_layout = new CoreLayout( $layout, $this );
        } catch( CoreException $e ) {
            throw new CoreException( $e->getMessage(), $e->getCode(), $e );
        } catch( Exception $e ) {
            throw new CoreException( 'Can not declare a new layout object', $e->getCode(), $e );
        }
    }

    /**
     * setCache - 
     * @param   int     $delay
     *          string  $path
     * @return  
    **/
    public function setCache( $delay = 0, $path = '' ) {
        $this->_cache = array(
            'delay' => $delay,
            'path'  => $path
        );
    }



    /**
     * --------------------------------------------------
     * GETTERS
     * --------------------------------------------------
    **/
    /**
     * getProperties - 
     * @param   
     * @return  
    **/
    public function getProperties() {
        return ( isset( $this->_properties ) ? $this->_properties : array() );
    }



    /**
     * --------------------------------------------------
     * METHODS
     * --------------------------------------------------
    **/
    /**
     * render - Renders the view wrapped into the layout
     * @param   bool    $cache
     *          string  $path
     *          string  $view
     *          string  $layout
     * @return  
    **/
    public function render( $cache, $view, $layout ) {
        if( !isset( $view ) ) $view = $this->_action;
        if( !isset( $this->_cache['path'] ) || ( isset( $this->_cache['delay'] ) && $this->_cache['delay']==0 ) ) $cache = false;

        if( $cache ) :
            if( file_exists( $this->_cache['path'] . $this->_controller ) || mkdir( $this->_cache['path'] . $this->_controller, 0777, true ) )
                $file = $this->_cache['path'] . $this->_controller . DS . $view . ( SRequest::getInstance()->get( 'id' )!==null ? '-' . SRequest::getInstance()->get( 'id' ) : '' ) . '.html';
            else
                $file = $this->_cache['path'] . $this->_controller . ucfirst( $view ) . ( SRequest::getInstance()->get( 'id' )!==null ? '-' . SRequest::getInstance()->get( 'id' ) : '' ) . '.html';

            $expire = time() - $this->_cache['delay'];
        endif;

        extract( $this->getProperties() );

        if( $cache && file_exists( $file ) && filemtime( $file ) > $expire ) :
            $html = file_get_contents( $file );
        else :
            ob_start();
            include( $this->_path . $this->_controller . DS . $view . '.php' );
            $html = ob_get_contents();
            ob_end_clean();

            $this->_layout->setLayout( $layout );
            $html = $this->_layout->wrap( $html );

            if( $cache ) file_put_contents( $file, $html );
        endif;
        
        return $html;
    }
}