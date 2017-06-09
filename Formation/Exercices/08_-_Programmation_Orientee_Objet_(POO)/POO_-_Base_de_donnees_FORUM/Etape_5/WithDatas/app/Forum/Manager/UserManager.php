<?php
/**
 * ------------------------------------------------------------
 * 
 * ------------------------------------------------------------
**/
class UserManager extends CoreManager {
    /**
     * --------------------------------------------------
     * CONSTANTS
     * --------------------------------------------------
    **/
    const TABLE = 'user';

    const QUERY_CREATE_TABLE = '
CREATE TABLE IF NOT EXISTS `rang` (
  `r_id` int(11) NOT NULL AUTO_INCREMENT,
  `r_libelle` varchar(255) NOT NULL,
  PRIMARY KEY (`r_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT="Liste des rôles du site";

CREATE TABLE IF NOT EXISTS `user` (
  `u_id` int(11) NOT NULL AUTO_INCREMENT,
  `u_login` varchar(30) NOT NULL,
  `u_prenom` varchar(255) DEFAULT NULL,
  `u_nom` varchar(255) DEFAULT NULL,
  `u_date_naissance` date DEFAULT NULL,
  `u_date_inscription` datetime NOT NULL,
  `u_rang_fk` int(11) NOT NULL,
  PRIMARY KEY (`u_id`),
  KEY `u_rang_fk` (`u_rang_fk`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT="Liste des utilisateurs du site";

ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_rang` FOREIGN KEY (`u_rang_fk`) REFERENCES `rang` (`r_id`) ON DELETE RESTRICT ON UPDATE CASCADE;';

    const QUERY_DROP_TABLE = '
ALTER TABLE `user`
    DROP FOREIGN KEY `user_ibfk_rang`;

DROP TABLE IF EXISTS `user`;
DROP TABLE IF EXISTS `rang`;';



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
            $this->executeQuery( self::QUERY_CREATE_TABLE ); // Creates the tables for the users if not exist
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
     * METHODS
     * --------------------------------------------------
    **/
    /**
     * record_exists - Performs a query to check the existence of a user
     * @param   string  $login
     * @return  bool
    **/
    public function record_exists( $login ) {
        try {
            if( ( $out = $this->executeQuery( 'SELECT COUNT( DISTINCT( `u_id` ) ) as cpt FROM `' . self::TABLE . '` WHERE `u_login`=:login', array( 'login' => array( 'VAL' => $login, 'TYPE' => PDO::PARAM_STR ) ) ) )!==false && count( $out )>0 && $out[0]['cpt']>0 )
                return true;

            return false;
        } catch( CoreException $e ) {
            throw $e;
        } catch( PDOException $e ) {
            throw new CoreException( $e->getMessage() );
        } catch( Exception $e ) {
            throw new CoreException( $e->getMessage() );
        }
    }

    /**
     * add - Performs a query to add a user
     * @param   User    $user
     * @return  mixed (int|bool)
    **/
    public function add( User $user ) {
        try {
            return $this->executeQuery( 'INSERT INTO `' . self::TABLE . '` ( `u_login`, `u_prenom`, `u_nom`, `u_date_naissance`, `u_date_inscription`, `u_rang_fk` ) VALUES ( :login, :lastname, :firstname, :birth_date, :registration_date, :role )', array( 'login' => array( 'VAL' => $user->getLogin(), 'TYPE' => PDO::PARAM_STR ), 'lastname' => array( 'VAL' => $user->getLastname(), 'TYPE' => PDO::PARAM_STR ), 'firstname' => array( 'VAL' => $user->getFirstname(), 'TYPE' => PDO::PARAM_STR ), 'birth_date' => array( 'VAL' => $user->getBirthDate(), 'TYPE' => PDO::PARAM_STR ), 'registration_date' => array( 'VAL' => $user->getRegistrationDate(), 'TYPE' => PDO::PARAM_STR ), 'role' => array( 'VAL' => $user->getRole(), 'TYPE' => PDO::PARAM_INT ) ) );
        } catch( CoreException $e ) {
            throw $e;
        } catch( PDOException $e ) {
            throw new CoreException( $e->getMessage() );
        } catch( Exception $e ) {
            throw new CoreException( $e->getMessage() );
        }
    }

    /**
     * getById - Performs a query to select a user by id
     * @param   int     $id
     * @return  mixed (User|bool)
    **/
    public function getById( $id ) {
        try {
            if( ( $out = $this->executeQuery( 'SELECT * FROM `' . self::TABLE . '` WHERE `u_id`=:id', array( 'id' => array( 'VAL' => $id, 'TYPE' => PDO::PARAM_INT ) ) ) )!==false && count( $out )>0 )
                return new User( $out[0] );

            return false;
        } catch( CoreException $e ) {
            throw $e;
        } catch( PDOException $e ) {
            throw new CoreException( $e->getMessage() );
        } catch( Exception $e ) {
            throw new CoreException( $e->getMessage() );
        }
    }

    /**
     * getByLogin - Performs a query to select a user by login
     * @param   string  $login
     * @return  mixed (User|bool)
    **/
    public function getByLogin( $login ) {
        try {
            if( ( $out = $this->executeQuery( 'SELECT * FROM `' . self::TABLE . '` WHERE `u_login`=:login', array( 'login' => array( 'VAL' => $login, 'TYPE' => PDO::PARAM_STR ) ) ) )!==false && count( $out )>0 )
                return new User( $out[0] );

            return false;
        } catch( CoreException $e ) {
            throw $e;
        } catch( PDOException $e ) {
            throw new CoreException( $e->getMessage() );
        } catch( Exception $e ) {
            throw new CoreException( $e->getMessage() );
        }
    }
}