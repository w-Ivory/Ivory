<?php
trait TypeTest {
    /**
     * is_valid_int - Tests whether a value is an integer, or is at least interpretable as an integer
     * @param   mixed       $value
     * @return  bool
    **/
    static function is_valid_int( $value ) {
        return ctype_digit( strval( $value ) );
    }

    /**
     * is_valid_date - Tests whether a value is a date, or is at least interpretable as an date
     * @param   string      $value
     *          [string     $format]
     * @return  bool
    **/
    static function is_valid_date( $value, $format = 'Y-m-d H:i:s' ) {
        $d = DateTime::createFromFormat( $format, $value );
        return ( $d && ( $d->format( $format ) == $value ) );
    }

    /**
     * is_valid_bool - Tests whether a value is a date, or is at least interpretable as an date
     * @param   string      $value
     * @return  bool
    **/
    static function is_valid_bool( $value ) {
        switch( strtolower( $value ) ) :
            case true:
            case false:
            case 1:
            case 0:
            case 'on':
            case 'off':
            case 'yes':
            case 'no':
            case 'y':
            case 'n':
                return TRUE;
                break;
            default:
                return FALSE;
        endswitch;
    }
}