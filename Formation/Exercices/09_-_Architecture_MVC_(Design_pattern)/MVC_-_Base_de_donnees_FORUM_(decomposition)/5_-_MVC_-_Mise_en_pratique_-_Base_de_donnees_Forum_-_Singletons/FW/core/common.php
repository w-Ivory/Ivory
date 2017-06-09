<?php
/**
 * loadClasses - Checks whether a file exists and includes it
 * @param   string  $className
 * @return  
**/
function loadClasses( $className ) {
    $_file_ = ( defined( 'COREPATH' ) ? COREPATH : '' ) . $className . '.php';
    if( file_exists( $_file_ ) ) require_once( $_file_ );

    $_file_ = ( defined( 'CONTROLLERSPATH' ) ? CONTROLLERSPATH : '' ) . $className . '.php';
    if( file_exists( $_file_ ) ) require_once( $_file_ );

    $_file_ = ( defined( 'MODELSPATH' ) ? MODELSPATH : '' ) . $className . '.php';
    if( file_exists( $_file_ ) ) require_once( $_file_ );
}
spl_autoload_register( 'loadClasses' ); // Register "loadClasses" function as __autoload() implementation