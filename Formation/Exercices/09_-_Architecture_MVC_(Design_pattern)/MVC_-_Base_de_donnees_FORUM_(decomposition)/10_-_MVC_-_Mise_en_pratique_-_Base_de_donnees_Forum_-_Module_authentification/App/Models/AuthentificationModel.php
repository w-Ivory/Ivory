<?php
require_once( ( defined( 'COREPATH' ) ? COREPATH : '' ) . 'CoreModel.php' ); // Loads the core model
/**
 * ------------------------------------------------------------
 * 
 * ------------------------------------------------------------
**/
class AuthentificationModel extends CoreModel {
    /**
     * --------------------------------------------------
     * METHODS
     * --------------------------------------------------
    **/
    /**
     * getUniq - Performs a database select query
     * @param   int     $id
     * @return  
     * @return  mixed (array|bool)
    **/
    public function getUniq( $id ) {
        try {
            if( ( $q = $this->_db->prepare( 'SELECT `u_id` AS "ID", `u_login` AS "Login", `u_prenom` AS "Prénom", `u_nom` AS "Nom", `u_date_naissance` AS "Date de naissance", `u_date_inscription` AS "Date d\'inscription", `r_libelle` AS "Rang" FROM `user` JOIN `rang` ON `user`.`u_rang_fk`=`rang`.`r_id` WHERE `u_id`=:id' ) )!==false ) :
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
     * userExists - Performs a database select query
     * @param   string  $login
     * @return  
     * @return  mixed (array|bool)
    **/
    public function userExists( $login ) {
        try {
            if( ( $q = $this->_db->prepare( 'SELECT `u_login` AS "Login" FROM `user` WHERE `u_login`=:login' ) )!==false ) :
                if( $q->bindParam( ':login', $login ) && $q->execute() ) :
                    return ( count( $q->fetch( PDO::FETCH_ASSOC ) ) > 0 );
                endif;
            endif;

            return false;
        } catch( PDOException $e ) {
            die( $e->getMessage() );
        }
    }
}