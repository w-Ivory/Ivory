<?php
/**
 * ------------------------------------------------------------
 * 
 * ------------------------------------------------------------
**/
class ForumManager extends CoreManager {
    /**
     * --------------------------------------------------
     * CONSTANTS
     * --------------------------------------------------
    **/
    const QUERY_CREATE_TABLE = '
CREATE TABLE IF NOT EXISTS `conversation` (
  `c_id` int(11) NOT NULL AUTO_INCREMENT,
  `c_date` datetime NOT NULL,
  `c_termine` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT="Liste des conversations du site";

CREATE TABLE IF NOT EXISTS `message` (
  `m_id` int(11) NOT NULL AUTO_INCREMENT,
  `m_contenu` varchar(2040) NOT NULL,
  `m_date` datetime NOT NULL,
  `m_auteur_fk` int(11) NOT NULL,
  `m_conversation_fk` int(11) NOT NULL,
  PRIMARY KEY (`m_id`),
  KEY `m_auteur_fk` (`m_auteur_fk`),
  KEY `m_conversation_fk` (`m_conversation_fk`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT="Liste des messages du site";

ALTER TABLE `message`
  ADD CONSTRAINT `message_ibfk_conversation` FOREIGN KEY (`m_conversation_fk`) REFERENCES `conversation` (`c_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `message_ibfk_auteur` FOREIGN KEY (`m_auteur_fk`) REFERENCES `user` (`u_id`) ON DELETE RESTRICT ON UPDATE CASCADE;';

    const QUERY_DROP_TABLE = '
ALTER TABLE `message`
    DROP FOREIGN KEY `message_ibfk_conversation`,
    DROP FOREIGN KEY `message_ibfk_auteur`;

DROP TABLE IF EXISTS `message`;
DROP TABLE IF EXISTS `conversation`;';
    /**
     * --------------------------------------------------
     * PROPERTIES
     * --------------------------------------------------
    **/
    private $_userManager;



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
        try {
            parent::__construct( $instance );
            $this->setUserManager(); // Defines UserManager instance
            $this->executeQuery( self::QUERY_CREATE_TABLE ); // Creates the tables for the forum if not exist
        } catch( CoreException $e ) {
            throw $e;
        } catch( PDOException $e ) {
            throw new CoreException( $e->getMessage() );
        } catch( Exception $e ) {
            throw new CoreException( $e->getMessage() );
        }
    }



    /**
     * --------------------------------------------------
     * SETTERS
     * --------------------------------------------------
    **/
    /**
     * setUserManager - Defines a new instance of UserManager
     * @param   
     * @return  
    **/
    private function setUserManager() {
        try {
            $this->_playerManager = new UserManager( $this->getDb() );
        } catch( CoreException $e ) {
            throw $e;
        } catch( PDOException $e ) {
            throw new CoreException( $e->getMessage() );
        } catch( Exception $e ) {
            throw new CoreException( $e->getMessage() );
        }
    }



    /**
     * --------------------------------------------------
     * GETTERS
     * --------------------------------------------------
    **/
    /**
     * getUserManager - 
     * @param   
     * @return  UserManager
    **/
    public function getUserManager() {
        return $this->_userManager;
    }



    /**
     * --------------------------------------------------
     * METHODS
     * --------------------------------------------------
    **/
    /**
     * getConversation - Performs a query to select a conversation
     * @param   [int    $id]
     *          [int    $order]
     * @return  mixed (array|bool)
    **/
    public function getConversation( $id = NULL, $order = NULL ) {
        try {
            $options = array();
            if( $this->is_valid_int( $id ) ) :
                $this->increaseGroupConcatMaxLen( 1000000 ); // CAUTION: GROUP_CONCAT() truncates the number of results based on the value of a MySQL constant (group_concat_max_len, which is set to 1024 bits by default). This value should be increased (globally with GLOBAL or only for the session with SESSION) thanks to this query
                $options['id'] = array( 'VAL' => $id, 'TYPE' => PDO::PARAM_INT );
            endif;

            return $this->executeQuery( 'SELECT `c_id` AS "ID", DATE_FORMAT( `c_date`, "%d/%m/%Y" ) AS "Date", DATE_FORMAT( `c_date`, "%H:%i:%s" ) AS "Heure", COUNT( `m_id` ) AS "Total Message(s)", `c_termine` AS "Status"' . ( $this->is_valid_int( $id ) ? ', GROUP_CONCAT( DISTINCT CONCAT( "ID", "_:_", `m_id`, "_,_", "Date", "_:_", DATE_FORMAT( `m_date`, "%d/%m/%Y" ), "_,_", "Heure", "_:_", DATE_FORMAT( `m_date`, "%H:%i:%s" ), "_,_", "Auteur", "_:_", `u_prenom`, " ", `u_nom`, "_,_", "Message", "_:_", `m_contenu` ) ' . ( !is_null( $order ) ? $order : ' ORDER BY `m_date` DESC' ) . ' SEPARATOR "_;_") AS "Message"' : '' ) . ' FROM `conversation` LEFT JOIN `message` ON `c_id`=`m_conversation_fk`' . ( $this->is_valid_int( $id ) ? ' LEFT JOIN `user` ON `m_auteur_fk`=`u_id` WHERE `c_id`=:id' : '' ) . ' GROUP BY `c_id` ORDER BY `c_id`', $options );
            // return $this->executeQuery( 'SELECT `c_id` AS "ID", DATE_FORMAT( `c_date`, "%d/%m/%Y" ) AS "Date", DATE_FORMAT( `c_date`, "%H:%i:%s" ) AS "Heure", COUNT( `m_id` ) AS "Total Message(s)", `c_termine` AS "Status" FROM `conversation` LEFT JOIN `message` ON `c_id`=`m_conversation_fk`' . ( $this->is_valid_int( $id ) ? ' LEFT JOIN `user` ON `m_auteur_fk`=`u_id` WHERE `c_id`=:id' : '' ) . ' GROUP BY `c_id` ORDER BY `c_id`', $options );
        } catch( CoreException $e ) {
            throw $e;
        } catch( PDOException $e ) {
            throw new CoreException( $e->getMessage() );
        } catch( Exception $e ) {
            throw new CoreException( $e->getMessage() );
        }
    }

    /**
     * getMessage - Performs a query to select a message
     * @param   [int    $conversation]
     *          [int    $order]
     *          [int    $limit]
     *          [int    $offset]
     * @return  mixed (array|bool)
    **/
    public function getMessage( $conversation = NULL, $order = NULL, $limit = NULL, $offset = NULL ) {
        try {
            $options = array();
            if( $this->is_valid_int( $conversation ) )
                $options['id'] = array( 'VAL' => $conversation, 'TYPE' => PDO::PARAM_INT );

            if( $this->is_valid_int( $limit ) )
                $options['limit'] = array( 'VAL' => $limit, 'TYPE' => PDO::PARAM_INT );

            if( $this->is_valid_int( $offset ) )
                $options['offset'] = array( 'VAL' => $offset, 'TYPE' => PDO::PARAM_INT );

            return $this->executeQuery( 'SELECT `c_id` AS "Conversation", `m_id` AS "ID", DATE_FORMAT( `m_date`, "%d/%m/%Y" ) AS "Date", DATE_FORMAT( `m_date`, "%H:%i:%s" ) AS "Heure", CONCAT( `u_prenom`, " ", `u_nom` ) AS "Auteur", `m_contenu` AS "Message" FROM `conversation` LEFT JOIN `message` ON `c_id`=`m_conversation_fk` LEFT JOIN `user` ON `m_auteur_fk`=`u_id` ' . ( $this->is_valid_int( $conversation ) ? ' WHERE `c_id`=:id' : '' ) . ( !is_null( $order ) ? $order : ' ORDER BY `m_date` DESC' ) . ( $this->is_valid_int( $limit ) ? ' LIMIT :limit' . ( $this->is_valid_int( $offset ) ? ' , :offset' : '' ) : '' ), $options );
        } catch( CoreException $e ) {
            throw $e;
        } catch( PDOException $e ) {
            throw new CoreException( $e->getMessage() );
        } catch( Exception $e ) {
            throw new CoreException( $e->getMessage() );
        }
    }
}