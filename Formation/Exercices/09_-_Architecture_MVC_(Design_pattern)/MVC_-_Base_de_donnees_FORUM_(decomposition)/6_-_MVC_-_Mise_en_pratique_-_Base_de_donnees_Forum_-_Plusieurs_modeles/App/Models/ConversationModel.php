<?php
/**
 * ------------------------------------------------------------
 * 
 * ------------------------------------------------------------
**/
class ConversationModel extends CoreModel {
    /**
     * --------------------------------------------------
     * METHODS
     * --------------------------------------------------
    **/
    /**
     * getList - Performs a database select query
     * @param   
     * @return  
     * @return  mixed (array|bool)
    **/
    public function getList() {
        try {
            if( ( $q = $this->_db->query( 'SELECT `c_id` AS "ID", `c_date` AS "Date", `c_termine` AS "Status" FROM `conversation` ORDER BY `c_id` ASC, `c_date` ASC, `c_termine` DESC' ) )!==false ) :
                return $q->fetchAll( PDO::FETCH_ASSOC );
            endif;

            return false;
        } catch( PDOException $e ) {
            die( $e->getMessage() );
        }
    }

    /**
     * getUniq - Performs a database select query
     * @param   int     $id
     * @return  
     * @return  mixed (array|bool)
    **/
    public function getUniq( $id ) {
        try {
            if( ( $q = $this->_db->prepare( 'SELECT `c_id` AS "ID", DATE_FORMAT( `c_date`, "%d %b %Y" ) AS "Date", DATE_FORMAT( `c_date`, "%H:%i:%s" ) AS "Heure", `c_termine` AS "Status", COUNT( `m_id` ) AS "Nombre de message(s)" FROM `conversation` INNER JOIN `message` ON `c_id`=`m_conversation_fk` WHERE `c_id`=:id' ) )!==false ) :
                if( $q->bindParam( ':id', $id ) && $q->execute() ) :
                    return $q->fetch( PDO::FETCH_ASSOC );
                endif;
            endif;

            return false;
        } catch( PDOException $e ) {
            die( $e->getMessage() );
        }
    }

    /**
     * add - Performs a database add query
     * @param   
     * @return  mixed (int|bool)
    **/
    public function add() {
        try {
            if( ( $q = $this->_db->query( 'INSERT INTO `conversation`( `c_date`, `c_termine` ) VALUES( "' . date( 'Y-m-d H:i:s' ) . '", 0 )' ) )!==false ) return $this->_db->lastInsertId();

            return false;
        } catch( PDOException $e ) {
            die( $e->getMessage() );
        }
    }
}