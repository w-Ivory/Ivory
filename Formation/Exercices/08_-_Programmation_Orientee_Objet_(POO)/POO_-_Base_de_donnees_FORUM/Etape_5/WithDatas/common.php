<?php
require_once( 'core/FileExplorer.php' );

/**
 * loadClasses - Checks whether a file exists and includes it
 * @param   string  $className
 * @return  
**/
function loadClasses( $className ) {
    $file = $className . '.php';

    $paths = array();
    if( defined( 'COREPATH' ) )
        $paths[] = COREPATH;
    if( defined( 'APPPATH' ) )
        $paths[] = APPPATH;

    foreach( $paths as $path )
        if( file_exists( $path . $file ) )
            require_once( $path . $file );
        else
            FileExplorer::exploreToInclude( $path, $file );
}

spl_autoload_register( 'loadClasses' ); // Register "loadClasses" function as __autoload() implementation