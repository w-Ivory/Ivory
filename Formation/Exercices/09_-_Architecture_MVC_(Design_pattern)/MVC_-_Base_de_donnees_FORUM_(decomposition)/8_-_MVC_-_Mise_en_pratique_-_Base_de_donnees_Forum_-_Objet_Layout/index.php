<?php
error_reporting( E_ALL & ~E_NOTICE ); // Sets which PHP errors are reported (http://php.net/manual/fr/function.error-reporting.php)
require_once( 'ini.php' );
require_once( COREPATH . 'common.php' );
require_once( COREPATH . 'SRequest.php' ); // Loads the singleton for GET/POST request

/**
 * --------------------------------------------------
 * AUTOROUTING
 * --------------------------------------------------
**/
if( SRequest::getInstance()->get( 'c' )!==null ) $folder = ucfirst( strtolower( SRequest::getInstance()->get( 'c' ) ) );
else $folder = 'Page';

$className = $folder . 'Controller'; // Defines the default controller's name
if( file_exists( ( defined( 'CONTROLLERSPATH' ) ? CONTROLLERSPATH : '' ) . $className . '.php' ) ) :
    require_once( ( defined( 'CONTROLLERSPATH' ) ? CONTROLLERSPATH : '' ) . $className . '.php' );
    $ctrl = new $className( MODELSPATH, VIEWSPATH, SRequest::getInstance() );



    if( SRequest::getInstance()->get( 'a' )!==null ) $actionName = SRequest::getInstance()->get( 'a' ); // Defines the action's name depending on passed value
    else $actionName = 'default'; // Defines the default action's name

    $methodName = $actionName . 'Action'; // Defines the default method's name
    if( method_exists( $ctrl, $methodName ) ) :
        $ctrl->$methodName(); // Calls the method
    endif;
endif;
/** **/