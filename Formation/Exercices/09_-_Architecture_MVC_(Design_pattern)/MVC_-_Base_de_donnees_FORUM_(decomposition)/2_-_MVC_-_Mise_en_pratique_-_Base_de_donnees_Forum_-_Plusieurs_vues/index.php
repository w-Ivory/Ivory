<?php
require_once( 'ini.php' );
require_once( COREPATH . 'common.php' );

if( file_exists( ( defined( 'CONTROLLERSPATH' ) ? CONTROLLERSPATH : '' ) . 'UserController.php' ) ) :
    $ctrl = new UserController( MODELSPATH, VIEWSPATH . 'User' . DS, null, DB_HOST, DB_NAME, DB_LOGIN, DB_PWD );

    if( isset( $_GET['a'] ) ) $methodName = $_GET['a'] . 'Action'; // Defines the action's name depending on passed value
    else $methodName = 'indexAction'; // Defines the default action's name
    // if( method_exists( $ctrl, $methodName ) ) $ctrl->$methodName( ( isset( $_GET['id'] ) ? $_GET['id'] : '' ) ); // Calls the method
    if( method_exists( $ctrl, $methodName ) ) :
        if( isset( $_GET['id'] ) ) :
            $ctrl->$methodName( $_GET['id'] ); // Calls the method
        else :
            $ctrl->$methodName(); // Calls the method
        endif;
    endif;
endif;