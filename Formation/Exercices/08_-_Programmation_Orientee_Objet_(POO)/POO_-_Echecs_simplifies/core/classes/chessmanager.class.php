<?php
require_once( 'manager.class.php' );
require_once( 'chessexception.class.php' );
/**
 * ------------------------------------------------------------
 * 
 * ------------------------------------------------------------
**/
class ChessManager extends Manager {
    /**
     * --------------------------------------------------
     * CONSTANTS
     * --------------------------------------------------
    **/
    const QUERY_CREATE_TABLE = '
CREATE TABLE IF NOT EXISTS `game` (
  `g_id` int(11) NOT NULL AUTO_INCREMENT,
  `g_dtstart` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `g_dtend` datetime NOT NULL DEFAULT "0000-00-00 00:00:00",
  `g_content` LONGTEXT NULL,
  `g_winner` varchar(255) NULL,
  PRIMARY KEY (`g_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `game` ADD CONSTRAINT `game_ibfk_winner` FOREIGN KEY (`g_winner`) REFERENCES `player`(`p_email`) ON DELETE RESTRICT ON UPDATE CASCADE;

CREATE TABLE IF NOT EXISTS `playing` (
  `_player_one` varchar(255) NULL,
  `_player_two` varchar(255) NULL,
  `_game` int(11) NOT NULL,
  PRIMARY KEY (`_player_one`,`_player_two`,`_game`)
  -- `_dtevent` datetime NOT NULL,
  -- `_event` varchar(255) NOT NULL,
  -- `_piece` varchar(50) NOT NULL DEFAULT "",
  -- `_coordstart` varchar(50) NOT NULL DEFAULT "",
  -- `_coordend` varchar(50) NOT NULL DEFAULT "",
  -- PRIMARY KEY (`_player`,`_game`,`_dtevent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `playing` ADD CONSTRAINT `playing_ibfk_player_one` FOREIGN KEY (`_player_one`) REFERENCES `player`(`p_email`) ON DELETE RESTRICT ON UPDATE CASCADE;
ALTER TABLE `playing` ADD CONSTRAINT `playing_ibfk_player_two` FOREIGN KEY (`_player_two`) REFERENCES `player`(`p_email`) ON DELETE RESTRICT ON UPDATE CASCADE;
ALTER TABLE `playing` ADD CONSTRAINT `playing_ibfk_game` FOREIGN KEY (`_game`) REFERENCES `game`(`g_id`) ON DELETE RESTRICT ON UPDATE CASCADE;';

    const QUERY_DROP_TABLE = '
ALTER TABLE `playing` DROP FOREIGN KEY `playing_ibfk_game`;
ALTER TABLE `playing` DROP FOREIGN KEY `playing_ibfk_player_two`; 
ALTER TABLE `playing` DROP FOREIGN KEY `playing_ibfk_player_one`; 
DROP TABLE IF EXISTS `playing`;
ALTER TABLE `game` DROP FOREIGN KEY `game_ibfk_winner`;
DROP TABLE IF EXISTS `game`;';

    const QUERY_DROP_DATABASE = '
DROP DATABASE IF EXISTS `cours_easychess`;';
    /**
     * --------------------------------------------------
     * PROPERTIES
     * --------------------------------------------------
    **/
    private $_playerManager;



    /**
     * --------------------------------------------------
     * MAGIC METHODS
     * --------------------------------------------------
    **/
    /**
     * __construct - Class constructor
     * @param   string  $host
     *          string  $dbname
     *          string  $login
     *          string  $pass
     * @return  
    **/
    public function __construct() {
        $this->setPlayerManager(); // Defines PlayerManager instance
        $this->executeQuery( self::QUERY_CREATE_TABLE ); // Creates the tables for the game if not exist
    }



    /**
     * --------------------------------------------------
     * SETTERS
     * --------------------------------------------------
    **/
    /**
     * setPlayerManager - Defines a new instance of PlayerManager
     * @param   object  $db
     * @return  
    **/
    private function setPlayerManager() {
        try {
            $this->_playerManager = new PlayerManager();
        } catch( Exception $e ) {
            throw new ChessException( $e->getMessage() );
        }
    }



    /**
     * --------------------------------------------------
     * GETTERS
     * --------------------------------------------------
    **/
    /**
     * getPlayerManager - 
     * @param   
     * @return  
    **/
    public function getPlayerManager() {
        return $this->_playerManager;
    }



    /**
     * --------------------------------------------------
     * METHODS
     * --------------------------------------------------
    **/
    /**
     * create - Performs a query to create a game
     * @param   
     * @return  mixed (int|bool)
    **/
    public function create() {
        try {
            return $this->executeQuery( 'INSERT INTO `game` ( `g_dtstart` ) VALUES ( NOW() )' );
        } catch( ManagerException $e ) {
            throw new ChessException( $e->getMessage() );
        } catch( PDOException $e ) {
            throw new ChessException( $e->getMessage() );
        } catch( Exception $e ) {
            throw new ChessException( $e->getMessage() );
        }
    }

    /**
     * join - Performs a query for a user to join a game
     * @param   int     $game
     *          object  $player_one
     *          object  $player_two
     * @return  mixed (int|bool)
    **/
    public function join( $game, Player $player_one, Player $player_two ) {
        try {
            return $this->executeQuery( 'INSERT INTO `playing` ( `_game`, `_player_one`, `_player_two` ) VALUES ( :game, :player_one, :player_two )', array( 'game' => array( 'VAL' => $game, 'TYPE' => PDO::PARAM_INT ), 'player_one' => array( 'VAL' => $player_one->getEmail(), 'TYPE' => PDO::PARAM_STR ), 'player_two' => array( 'VAL' => $player_two->getEmail(), 'TYPE' => PDO::PARAM_STR ) ) );
        } catch( ManagerException $e ) {
            throw new ChessException( $e->getMessage() );
        } catch( PDOException $e ) {
            throw new ChessException( $e->getMessage() );
        } catch( Exception $e ) {
            throw new ChessException( $e->getMessage() );
        }
    }

    /**
     * backup - Performs a query to backup a game
     * @param   object  $game
     * @return  mixed (int|bool)
    **/
    public function backup( Game $game ) {
        try {
            if( is_numeric( $game->getId() ) )
                return $this->executeQuery( 'UPDATE `game` SET `g_content`=:game WHERE `g_id`=:id', array( 'id' => array( 'VAL' => $game->getId(), 'TYPE' => PDO::PARAM_INT ), 'game' => array( 'VAL' => serialize( $game ), 'TYPE' => PDO::PARAM_STR ) ) );

        } catch( ManagerException $e ) {
            throw new ChessException( $e->getMessage() );
        } catch( PDOException $e ) {
            throw new ChessException( $e->getMessage() );
        } catch( Exception $e ) {
            throw new ChessException( $e->getMessage() );
        }
    }

    /**
     * game_exists - Performs a query to check the existence of a game
     * @param   object  $player_one
     *          object  $player_two
     * @return  object
    **/
    public function game_exists( Player $player_one, Player $player_two ) {
        try {
            if( ( $out = $this->executeQuery( 'SELECT COUNT( DISTINCT( `g_id` ) ) as cpt FROM `game` JOIN `playing` ON `game`.`g_id`=`playing`.`_game` WHERE `game`.`g_dtend`="0000-00-00 00:00:00" AND ( ( `playing`.`_player_one`=:player_one AND `playing`.`_player_two`=:player_two ) OR ( `playing`.`_player_one`=:player_two AND `playing`.`_player_two`=:player_one ) )', array( 'player_one' => array( 'VAL' => $player_one->getEmail(), 'TYPE' => PDO::PARAM_STR ), 'player_two' => array( 'VAL' => $player_two->getEmail(), 'TYPE' => PDO::PARAM_STR ) ) ) )!==false && count( $out )>0 && $out[0]['cpt']>0 )
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
     * recovery - Performs a query to recovery a game
     * @param   object  $player_one
     *          object  $player_two
     * @return  object
    **/
    public function recovery( Player $player_one, Player $player_two ) {
        try {
            return unserialize( $this->executeQuery( 'SELECT `game`.`g_content` FROM `game` JOIN `playing` ON `game`.`g_id`=`playing`.`_game` WHERE `game`.`g_dtend`="0000-00-00 00:00:00" AND ( ( `playing`.`_player_one`=:player_one AND `playing`.`_player_two`=:player_two ) OR ( `playing`.`_player_one`=:player_two AND `playing`.`_player_two`=:player_one ) )', array( 'player_one' => array( 'VAL' => $player_one->getEmail(), 'TYPE' => PDO::PARAM_STR ), 'player_two' => array( 'VAL' => $player_two->getEmail(), 'TYPE' => PDO::PARAM_STR ) ) )[0]['g_content'] );
        } catch( ManagerException $e ) {
            throw new ChessException( $e->getMessage() );
        } catch( PDOException $e ) {
            throw new ChessException( $e->getMessage() );
        } catch( Exception $e ) {
            throw new ChessException( $e->getMessage() );
        }
    }

    /**
     * backup - Performs a query to finish a game
     * @param   object  $game
     *          object  $winner
     * @return  mixed (int|bool)
    **/
    public function finish( Game $game, Player $winner ) {
        try {
            return $this->executeQuery( 'UPDATE `game` SET `g_content`=:game, `g_dtend`=NOW(), `g_winner`=:winner WHERE `g_id`=:id', array( 'id' => array( 'VAL' => $game->getId(), 'TYPE' => PDO::PARAM_INT ), 'game' => array( 'VAL' => serialize( $game ), 'TYPE' => PDO::PARAM_STR ), 'winner' => array( 'VAL' => $winner->getEmail(), 'TYPE' => PDO::PARAM_STR ) ) );
        } catch( ManagerException $e ) {
            throw new ChessException( $e->getMessage() );
        } catch( PDOException $e ) {
            throw new ChessException( $e->getMessage() );
        } catch( Exception $e ) {
            throw new ChessException( $e->getMessage() );
        }
    }

    /**
     * reset - Performs a database drop query
     * @param   
     * @return  bool
    **/
    public function reset() {
        if( $this->executeQuery( self::QUERY_DROP_TABLE )!==false ) return $this->getPlayerManager()->reset();

        return false;
    }
}