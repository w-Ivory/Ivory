<?php
/**
 * ------------------------------------------------------------
 * 
 * ------------------------------------------------------------
**/
class UserModel extends Model {
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
            if( ( $q = $this->_db->query( 'SELECT `u_id` AS "ID", `u_login` AS "Login", `u_prenom` AS "Prénom", `u_nom` AS "Nom" FROM `user` ORDER BY `u_prenom` ASC, `u_nom` ASC' ) )!==false ) :
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
     * getRoles - Performs a database select query
     * @param   
     * @return  
     * @return  mixed (array|bool)
    **/
    public function getRoles() {
        try {
            if( ( $q = $this->_db->query( 'SELECT `r_id` AS "ID", `r_libelle` AS "Label" FROM `rang` ORDER BY `r_libelle` ASC' ) )!==false ) :
                return $q->fetchAll( PDO::FETCH_ASSOC );
            endif;

            return false;
        } catch( PDOException $e ) {
            die( $e->getMessage() );
        }
    }

    /**
     * add - Performs a database add query
     * @param   array   $datas
     * @return  mixed (int|bool)
    **/
    public function add( $datas ) {
        try {
            $fields = array();
            $values = array();
            foreach( $datas as $key => $value ) :
                $fields[] = 'u_' . $key;
                $values[] = $value;
            endforeach;

            if( ( $q = $this->_db->prepare( 'INSERT INTO `user`( `u_date_inscription`, `' . implode( '`, `', $fields ) . '`) VALUES( "' . date( 'Y-m-d H:i:s' ) . '", :' . implode( ', :', $fields ) . ')' ) )!==false ) :
                foreach( $datas as $key => $value ) :
                    if( !$q->bindValue( 'u_' . $key, $value, ( is_numeric( $value ) ? PDO::PARAM_INT : PDO::PARAM_STR ) ) ) return false;
                endforeach;

                if( $q->execute() ) return $this->_db->lastInsertId();
            endif;

            return false;
        } catch( PDOException $e ) {
            die( $e->getMessage() );
        }
    }
}