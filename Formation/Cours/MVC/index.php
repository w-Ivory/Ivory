<?php
if( isset( $_GET['controller'] ) ) {
    $class = ucwords( $_GET['controller'] ) . 'Controller'; // $class = 'ContactController'
} else {
    $class = 'AccueilController';
}

if( isset( $_GET['action'] ) ) {
    $method = $_GET['action'];
} else {
    $method = 'show';
}


if( file_exists( 'Controller/' . $class . '.php' ) ) {
    require_once( 'Controller/' . $class . '.php' );
    $page = new $class;

    if( method_exists( $page, $method ) ) {
        $page->$method();
        exit;
    }
}

header( 'Location: 404.php' );