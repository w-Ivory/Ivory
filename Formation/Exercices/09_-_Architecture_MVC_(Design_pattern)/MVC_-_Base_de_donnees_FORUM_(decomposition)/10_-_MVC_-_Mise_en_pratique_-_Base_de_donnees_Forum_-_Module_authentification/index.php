<?php
error_reporting( E_ALL & ~E_NOTICE ); // Sets which PHP errors are reported (http://php.net/manual/fr/function.error-reporting.php)
session_start();
try {
    require_once( 'ini.php' );
    require_once( COREPATH . 'common.php' );
    // require_once( COREPATH . 'SRequest.php' ); // Loads the singleton for GET/POST request (Only useful if the automatic loading is not used)

    /**
     * --------------------------------------------------
     * AUTOROUTING
     * --------------------------------------------------
    **/
    if( SRequest::getInstance()->get( 'c' )!==null ) $className = ucfirst( strtolower( SRequest::getInstance()->get( 'c' ) ) ) . 'Controller'; // Defines the controller's name depending on passed value
    else $className = 'PageController'; // Defines the default controller's name

    if( file_exists( ( defined( 'CONTROLLERSPATH' ) ? CONTROLLERSPATH : '' ) . $className . '.php' ) ) :
        // require_once( ( defined( 'CONTROLLERSPATH' ) ? CONTROLLERSPATH : '' ) . $className . '.php' ); // Loads the controller class (Only useful if the automatic loading is not used)
        $ctrl = new $className(
            SRequest::getInstance(), // Passes the GET/POST request
            array(
                'model'     => array( 'path' => ( defined( 'MODELSPATH' ) ? MODELSPATH : '' ) ),
                'view'      => array( 'path' => ( defined( 'VIEWSPATH' ) ? VIEWSPATH : '' ) ),
                'layout'    => array( 'path' => ( defined( 'VIEWSPATH' ) ? VIEWSPATH . 'Layout' . ( defined( 'DS' ) ? DS : '' ) : ''  ) ),
                'cache'     => array( 'path' => ( defined( 'CACHEPATH' ) ? CACHEPATH : '' ), 'delay' => ( defined( 'CACHEDELAY' ) && !isset( $_SESSION[( defined( 'APP_TAG' ) ? APP_TAG : '' )]['auth'] ) ? CACHEDELAY : 0 ) )
            ) // Passes the differents paths for models and views
        ); // Instantiates the controller

        if( SRequest::getInstance()->get( 'a' )!==null ) $methodName = SRequest::getInstance()->get( 'a' ) . 'Action'; // Defines the method's name depending on passed value
        else $methodName = 'defaultAction'; // Defines the default method's name

        if( method_exists( $ctrl, 'launcher' ) ) :
            $ctrl->launcher( $methodName ); // Calls the launcher
        endif;
    endif;
    /** **/
} catch( CoreException $e ) {
    echo $e;
} catch( Exception $e ) {
    die( $e->getMessage() );
}