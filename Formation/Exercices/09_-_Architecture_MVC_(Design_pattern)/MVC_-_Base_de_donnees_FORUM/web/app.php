<?php
error_reporting( E_ALL & ~E_NOTICE ); // Sets which PHP errors are reported (http://php.net/manual/fr/function.error-reporting.php)
try {
    require_once( '..\app\config\ini.php' );
    require_once( APPPATH . 'autoloader.php' );

    /**
     * --------------------------------------------------
     * AUTOROUTING
     * --------------------------------------------------
    **/
    if( SRequest::getInstance()->get( 'c' )!==null )
        $class = ucwords( strtolower( SRequest::getInstance()->get( 'c' ) ) ) . 'Controller'; // Defines the controller's name depending on passed value
    else
        $class = 'PageController'; // Defines the default controller's name

    $ctrl = new $class( SRequest::getInstance() ); // Instantiates the controller

    if( SRequest::getInstance()->get( 'a' )!==null )
        $method = SRequest::getInstance()->get( 'a' ) . 'Action'; // Defines the method's name depending on passed value
    else
        $method = 'defaultAction'; // Defines the default method's name

    if( method_exists( $ctrl, 'launcher' ) ) :
        $ctrl->launcher( $method ); // Calls the launcher
        exit;
    endif;

    header( 'Location:' . DOMAIN . 'error/404');
    /** **/
} catch( KernelException $e ) {
    if( DEBUG_MODE )
        die( $e );
    else
        header( 'Location:' . DOMAIN . 'error/404');

} catch( Exception $e ) {
    if( DEBUG_MODE )
        die( $e->getMessage() );
    else
        header( 'Location:' . DOMAIN . 'error/404');
}