<?php
/**
 * Dans ce MVC :
 *  - Pages : Accueil / Contact / 404
 *  - Authentification donne accès aux pages de gestion des utilisateurs
**/
session_start();
require_once( 'ini.php' );
require_once( 'FW/libs/SPDO.php' );
require_once( 'FW/libs/SRequest.php' );

if( SRequest::getInstance()->get( 'c' )!==NULL ) {
    $bundle = ucwords( SRequest::getInstance()->get( 'c' ) );
} else {
    $bundle = 'Page';
}

if( file_exists( 'App/' . $bundle . '/' . $bundle . 'Controller.php' ) ) {
    require_once( 'App/' . $bundle . '/' . $bundle . 'Controller.php' );
    $controller = $bundle . 'Controller';

    $request = SRequest::getInstance();

    $class = new $controller( 'App/', $request, SPDO::getInstance( 'localhost', 'mvc_o3w', 'root', '' )->getPDO() );

    if( SRequest::getInstance()->get( 'a' )!==NULL ) {
        $method = SRequest::getInstance()->get( 'a' );
    } else {
        $method = 'default';
    }
    $method .= 'Action';

    if( method_exists( $class, $method ) ) {
        if( SRequest::getInstance()->post()!==NULL )
            $class->$method( SRequest::getInstance()->post() );
        else
            $class->$method();

        exit;
    }
}

header( 'Location:404.php' );