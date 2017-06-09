<?php
require_once( 'ini.php' );
require_once( COREPATH . 'common.php' );

if( file_exists( ( defined( 'CONTROLLERSPATH' ) ? CONTROLLERSPATH : '' ) . 'UserController.php' ) ) :
    $ctrl = new UserController( MODELSPATH, VIEWSPATH . 'User' . DS, null, DB_HOST, DB_NAME, DB_LOGIN, DB_PWD );
    if( method_exists( $ctrl, 'indexAction' ) ) $ctrl->indexAction();
endif;