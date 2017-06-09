<?php
/**
 * ------------------------------------------------------------
 * 
 * ------------------------------------------------------------
**/
abstract class CoreManager {
    use TypeTest;
    
    /**
     * --------------------------------------------------
     * PROPERTIES
     * --------------------------------------------------
    **/
    protected $_db;



    /**
     * --------------------------------------------------
     * MAGIC METHODS
     * --------------------------------------------------
    **/
    /**
     * __construct - Class constructor
     * @param   PDO     $instance
     * @return  
    **/
    public function __construct( $instance ) {
        $this->_db = $instance; // Defines PDO instance
    }



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
     * getDb - 
     * @param   
     * @return  
    **/
    protected function getDb() {
        return $this->_db;
    }



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
                if( ( $stmt = $this->getDb()->prepare( $query ) )!==false ) :
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
                                return $this->getDb()->lastInsertId();
                                break;
                        endswitch;

                        $stmt->closeCursor();
                        return $out;
                    endif;

                endif;
            else
                switch( strtoupper( substr( $query, 0, 6 ) ) ) :
                    case 'SELECT':
                        if( ( $stmt = $this->getDb()->query( $query ) )!==false )
                            return $stmt->fetchAll( PDO::FETCH_ASSOC );

                        break;
                    case 'INSERT':
                        if( ( $stmt = $this->getDb()->query( $query ) )!==false )
                            return $this->getDb()->lastInsertId();

                        break;
                    default:
                        return $this->getDb()->exec( $query );
                endswitch;

            return false;
        } catch( PDOException $e ) {
            throw new CoreException( $e->getMessage() );
        }
    }
}