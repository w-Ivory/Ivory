<?php
/**
 * loadClasses - Checks whether a file exists and includes it
 * @param   string  $className
 * @return  
**/
function loadClasses( $className ) {
    $_file_ = ( defined( 'COREPATH' ) ? COREPATH : '' ) . 'classes' . ( defined( 'DS' ) ? DS : DIRECTORY_SEPARATOR ) . strtolower( $className ) . '.class.php';
    if( file_exists( $_file_ ) )
        require_once( $_file_ );

    $_file_ = ( defined( 'COREPATH' ) ? COREPATH : '' ) . 'interface' . ( defined( 'DS' ) ? DS : DIRECTORY_SEPARATOR ) . strtolower( $className ) . '.class.php';
    if( file_exists( $_file_ ) )
        require_once( $_file_ );
}
spl_autoload_register( 'loadClasses' ); // Registers "loadCalsses" function as __autoload() implementation