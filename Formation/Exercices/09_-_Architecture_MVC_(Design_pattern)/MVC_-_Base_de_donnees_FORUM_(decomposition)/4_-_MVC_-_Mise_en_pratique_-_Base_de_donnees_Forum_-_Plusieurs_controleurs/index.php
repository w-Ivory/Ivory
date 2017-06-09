<?php
error_reporting( E_ALL & ~E_NOTICE ); // Sets which PHP errors are reported (http://php.net/manual/fr/function.error-reporting.php)
require_once( 'ini.php' );
require_once( COREPATH . 'common.php' );

/**
 * --------------------------------------------------
 * AUTOROUTING
 * --------------------------------------------------
**/
if( isset( $_GET['c'] ) ) $folder = ucfirst( strtolower( $_GET['c'] ) );
else $folder = 'Page';

$className = $folder . 'Controller'; // Defines the default controller's name
if( file_exists( ( defined( 'CONTROLLERSPATH' ) ? CONTROLLERSPATH : '' ) . $className . '.php' ) ) :
    require_once( ( defined( 'CONTROLLERSPATH' ) ? CONTROLLERSPATH : '' ) . $className . '.php' );
    $ctrl = new $className( MODELSPATH, VIEWSPATH . $folder . DS, null, DB_HOST, DB_NAME, DB_LOGIN, DB_PWD );

    if( isset( $_GET['a'] ) ) $methodName = $_GET['a'] . 'Action'; // Defines the action's name depending on passed value
    else $methodName = 'defaultAction'; // Defines the default action's name
    if( method_exists( $ctrl, $methodName ) ) :
        if( isset( $_GET['id'] ) ) : $ctrl->$methodName( $_GET['id'] ); // Calls the method
        elseif( isset( $_POST ) && count( $_POST )>0 ) : $ctrl->$methodName( $_POST ); // Calls the method
        else : $ctrl->$methodName(); // Calls the method
        endif;
    endif;
endif;
/** **/