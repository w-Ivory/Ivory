<?php
require_once( VENDORPATH . 'FileExplorer.php' );

/**
 * loadClasses - Checks whether a file exists and includes it
 * @param   string  $class
 * @return
**/
function loadClasses( $class ) {
    $loaded = FALSE;
    $file = $class . '.php';

    foreach( explode( PATH_SEPARATOR, REQUIRED_PATH ) as $path ) :
        if( file_exists( $path . $file ) ) :
            require_once( $path . $file );
            $loaded = TRUE;
        else :
            $loaded = FileExplorer::exploreToInclude( $path, $file );
        endif;

        if( $loaded )
            break;
    endforeach;

    if( !$loaded )
        throw new KernelException( '[Loader Exception] Class "' . $file . '" not found' );
}

spl_autoload_register( 'loadClasses' ); // Register "loadClasses" function as __autoload() implementation