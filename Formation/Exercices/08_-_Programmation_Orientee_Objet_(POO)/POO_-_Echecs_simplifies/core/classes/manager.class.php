<?php
require_once( 'managerexception.class.php' );
/**
 * ------------------------------------------------------------
 * 
 * ------------------------------------------------------------
**/
abstract class Manager {
    /**
     * --------------------------------------------------
     * PROPERTIES
     * --------------------------------------------------
    **/



    /**
     * --------------------------------------------------
     * MAGIC METHODS
     * --------------------------------------------------
    **/



    /**
     * --------------------------------------------------
     * SETTERS
     * --------------------------------------------------
    **/



    /**
     * --------------------------------------------------
     * GETTERS
     * --------------------------------------------------
    **/



    /**
     * --------------------------------------------------
     * METHODS
     * --------------------------------------------------
    **/
    /**
     * executeQuery - Performs a query on database
     * @param   string  $query
     *          array   $options    [optional]
     * @return  mixed (array|bool)
    **/
    protected function executeQuery( $query, $options = array() ) {
        try {
            if( count( $options )>0 )
                if( ( $stmt = SPDO::getInstance()->prepare( $query ) )!==false ) :
                    $bind = true;
                    foreach( $options as $key => $value ) :
                        if( ( $bind = $stmt->bindValue( $key, $value['VAL'], ( isset( $value['TYPE'] ) ? $value['TYPE'] : PDO::PARAM_STR ) ) )===false )
                            break;

                    endforeach;

                    if( $bind && ( $out = $stmt->execute() )===true ) :
                        switch( strtoupper( substr( $query, 0, 6 ) ) ) :
                            case 'SELECT':
                                return $stmt->fetchAll( PDO::FETCH_ASSOC );
                                break;
                            case 'INSERT':
                                return SPDO::getInstance()->lastInsertId();
                                break;
                        endswitch;

                        $stmt->closeCursor();
                        return $out;
                    endif;

                endif;
            else
                switch( strtoupper( substr( $query, 0, 6 ) ) ) :
                    case 'SELECT':
                        if( ( $stmt = SPDO::getInstance()->query( $query ) )!==false )
                            return $stmt->fetchAll( PDO::FETCH_ASSOC );

                        break;
                    case 'INSERT':
                        if( ( $stmt = SPDO::getInstance()->query( $query ) )!==false )
                            return SPDO::getInstance()->lastInsertId();

                        break;
                    default:
                        return SPDO::getInstance()->exec( $query );
                endswitch;

            return false;
        } catch( PDOException $e ) {
            throw new ManagerException( $e->getMessage() );
        }
    }
}