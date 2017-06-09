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
     * increaseGroupConcatMaxLen - Performs a query on database for the session
     * @param   [int    $number]
     * @return  bool
    **/
    protected function increaseGroupConcatMaxLen( $number = 1024 ) {
        return $this->executeQuery( 'SET SESSION group_concat_max_len = :increase', array( 'increase' => array( 'VAL' => $number, 'TYPE' => PDO::PARAM_INT ) ) ); // CAUTION: GROUP_CONCAT() truncates the number of results based on the value of a MySQL constant (group_concat_max_len, which is set to 1024 bits by default). This value should be increased (globally with GLOBAL or only for the session with SESSION) thanks to this query
    }

    /**
     * executeQuery - Performs a query on database
     * @param   string  $query
     *          [array  $options]
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