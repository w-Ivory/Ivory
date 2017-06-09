<?php
/**
 * ------------------------------------------------------------
 * 
 * ------------------------------------------------------------
**/
class UserModel {
    
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
     * record_exists - Performs a query to check the existence of a user
     * @param   string  $login
     *          string  $password
     * @return  bool
    **/
    public function record_exists( $login, $password ) {
        try {
            if( ( $out = $this->executeQuery( 'SELECT COUNT( DISTINCT( `id` ) ) as cpt FROM `users` WHERE `login`=:login AND `password`=:password', array( 'login' => array( 'VAL' => $login, 'TYPE' => PDO::PARAM_STR ), 'password' => array( 'VAL' => $password, 'TYPE' => PDO::PARAM_STR ) ) ) )!==false && count( $out )>0 && $out[0]['cpt']>0 )
                return true;

            return false;
        } catch( Exception $e ) {
            die( $e->getMessage() );
        }
    }

    /**
     * add - Performs a query to add a user
     * @param   User    $user
     * @return  mixed (int|bool)
    **/
    public function add( User $user ) {
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
            die( $e->getMessage() );
        }
    }
}