<?php
class FileExplorer {
    /**
     * generateDS - 
     * @param   string  $path
     * @return  
    **/
    public static function generateDS( $path ) {
        return ( substr( $path, -1 )!=DS ? DS : '' );
    }

    /**
     * exploreToInclude - 
     * @param   string  $path
     *          string  $file
     * @return  
    **/
    public static function exploreToInclude( $path, $file ) {
        if( file_exists( $path ) && is_dir( $path . static::generateDS( $path ) ) )
            if( ( $resource = opendir( $path ) )!==false ) :
                while( ( $entry = readdir( $resource ) )!==false ) :
                    if( $entry!='.' && $entry!='..' ) :
                        if( is_file( $path . static::generateDS( $path ) . $entry ) ) :
                            if( $entry==$file ) :
                                require_once( $path . static::generateDS( $path ) . $file );
                            endif;
                        elseif( is_dir( $path . static::generateDS( $path ) . $entry . static::generateDS( $entry ) ) ) :
                            static::exploreToInclude( $path . static::generateDS( $path ) . $entry . static::generateDS( $entry ), $file );
                        endif;
                    endif;
                endwhile;

                closedir( $resource );
            endif;
    }
}