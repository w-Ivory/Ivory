<?php
require_once( 'manager.class.php' );
require_once( 'chessexception.class.php' );
require_once( 'player.class.php' );
/**
 * ------------------------------------------------------------
 * 
 * ------------------------------------------------------------
**/
class PlayerManager extends Manager {
    /**
     * --------------------------------------------------
     * CONSTANTS
     * --------------------------------------------------
    **/
    const TABLE = 'player';

    const QUERY_CREATE_TABLE = '
CREATE TABLE IF NOT EXISTS `player` (
    `p_email` varchar(255) NOT NULL,
    `p_password` varchar(100) NOT NULL,
    `p_nickname` varchar(100) NOT NULL DEFAULT "Invité",
    `p_date_account_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`p_email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;';

    const QUERY_DROP_TABLE = '
DROP TABLE IF EXISTS `player`;';



    /**
     * --------------------------------------------------
     * MAGIC METHODS
     * --------------------------------------------------
    **/
    /**
     * __construct - Class constructor
     * @param   object  $db
     *          string  $host
     *          string  $dbname
     *          string  $login
     *          string  $pass
     * @return  
    **/
    public function __construct() {
        $this->executeQuery( self::QUERY_CREATE_TABLE ); // Creates the tables for the players if not exist
    }



    /**
     * --------------------------------------------------
     * METHODS
     * --------------------------------------------------
    **/
    /**
     * add - Performs a query to add a player
     * @param   object  $player
     * @return  mixed (int|bool)
    **/
    public function add( Player $player ) {
        try {
            return $this->executeQuery( 'INSERT INTO `' . self::TABLE . '` ( `p_email`, `p_password`, `p_nickname`, `p_date_account_creation` ) VALUES ( :email, :password, :nickname, :date_account_creation )', array( 'email' => array( 'VAL' => $player->getEmail(), 'TYPE' => PDO::PARAM_STR ), 'password' => array( 'VAL' => $player->getPassword(), 'TYPE' => PDO::PARAM_STR ), 'nickname' => array( 'VAL' => $player->getNickname(), 'TYPE' => PDO::PARAM_STR ), 'date_account_creation' => array( 'VAL' => $player->getDateAccountCreation(), 'TYPE' => PDO::PARAM_STR ) ) );
        } catch( ManagerException $e ) {
            throw new ChessException( $e->getMessage() );
        } catch( PDOException $e ) {
            throw new ChessException( $e->getMessage() );
        } catch( Exception $e ) {
            throw new ChessException( $e->getMessage() );
        }
    }

    /**
     * record_exists - Performs a query to check the existence of a player
     * @param   string  $id
     * @return  bool
    **/
    public function record_exists( $id ) {
        try {
            if( ( $out = $this->executeQuery( 'SELECT COUNT( DISTINCT( `p_email` ) ) as cpt FROM `' . self::TABLE . '` WHERE `p_email`=:id', array( 'id' => array( 'VAL' => $id, 'TYPE' => PDO::PARAM_STR ) ) ) )!==false && count( $out )>0 && $out[0]['cpt']>0 )
                return true;

            return false;
        } catch( ManagerException $e ) {
            throw new ChessException( $e->getMessage() );
        } catch( PDOException $e ) {
            throw new ChessException( $e->getMessage() );
        } catch( Exception $e ) {
            throw new ChessException( $e->getMessage() );
        }
    }

    /**
     * get - Performs a query to select a player
     * @param   string  $id
     * @return  mixed (object|bool)
    **/
    public function get( $id ) {
        try {
            if( ( $out = $this->executeQuery( 'SELECT * FROM `' . self::TABLE . '` WHERE `p_email`=:id', array( 'id' => array( 'VAL' => $id, 'TYPE' => PDO::PARAM_STR ) ) ) )!==false && count( $out )>0 )
                return new Player( $out[0] );

            return false;
        } catch( ManagerException $e ) {
            throw new ChessException( $e->getMessage() );
        } catch( PDOException $e ) {
            throw new ChessException( $e->getMessage() );
        } catch( Exception $e ) {
            throw new ChessException( $e->getMessage() );
        }
    }

    /**
     * reset - Performs a query to drop
     * @param   
     * @return  bool
    **/
    public function reset() {
        return $this->executeQuery( self::QUERY_DROP_TABLE );
    }
}