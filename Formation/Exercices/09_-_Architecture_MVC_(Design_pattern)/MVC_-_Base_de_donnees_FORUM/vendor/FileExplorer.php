<?php
class FileExplorer {
    /**
     * generateDS - 
     * @param   string  $path
     * @return  
    **/
    static public function generateDS( $path ) {
        return ( substr( $path, -1 )!=DS ? DS : '' );
    }

    /**
     * exploreToInclude - 
     * @param   string  $path
     *          string  $file
     * @return  
    **/
    static public function exploreToInclude( $path, $file ) {
        $out = FALSE;
        if( file_exists( $path ) && is_dir( $path . static::generateDS( $path ) ) )
            if( ( $resource = opendir( $path ) )!==FALSE ) :
                while( ( $entry = readdir( $resource ) )!==FALSE )
                    if( $entry!='.' && $entry!='..' )
                        if( is_file( $path . static::generateDS( $path ) . $entry ) )
                            if( $entry==$file ) :
                                require_once( $path . static::generateDS( $path ) . $file );
                                return TRUE;
                            endif;
                        elseif( is_dir( $path . static::generateDS( $path ) . $entry . static::generateDS( $entry ) ) )
                            if( ( $out = static::exploreToInclude( $path . static::generateDS( $path ) . $entry . static::generateDS( $entry ), $file ) )===TRUE )
                                return TRUE;

                closedir( $resource );
            endif;

        if( !isset( $out ) || !$out )
            return FALSE;
    }
}