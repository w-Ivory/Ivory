<?php
/**
 * ------------------------------------------------------------
 * FORUM MODEL
 * (Requires : KernelException | KernelModel | ClassUser)
 * ------------------------------------------------------------
**/
class UserModel extends KernelModel {
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
     * @param
     * @return
    **/
    public function __construct() {
        try {
            parent::__construct();
            $this->query( self::QUERY_CREATE_TABLE ); // Creates the tables for the users if not exist
        } catch( PDOException $e ) {
            throw new KernelException( 'Can not get the <strong>' . $this->getModel() . '</strong> datas', $e->getCode(), $e );
        } catch( Exception $e ) {
            throw new KernelException( 'Can not get the <strong>' . $this->getModel() . '</strong> datas', $e->getCode(), $e );
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
            if( ( $out = $this->query( 'SELECT COUNT( DISTINCT( `u_id` ) ) as cpt FROM `' . self::TABLE . '` WHERE `u_login`=:login', array( 'login' => array( 'VAL' => $login, 'TYPE' => PDO::PARAM_STR ) ) ) )!==false && count( $out )>0 && $out[0]['cpt']>0 )
                return true;

            return false;
        } catch( PDOException $e ) {
            throw new KernelException( 'Can not get the <strong>' . $this->getModel() . '</strong> datas', $e->getCode(), $e );
        } catch( Exception $e ) {
            throw new KernelException( 'Can not get the <strong>' . $this->getModel() . '</strong> datas', $e->getCode(), $e );
        }
    }

    /**
     * add - Performs a query to add a user
     * @param   ClassUser    $user
     * @return  mixed (int|bool)
    **/
    public function add( ClassUser $user ) {
        try {
            return $this->query( 'INSERT INTO `' . self::TABLE . '` ( `u_login`, `u_prenom`, `u_nom`, `u_date_naissance`, `u_date_inscription`, `u_rang_fk` ) VALUES ( :login, :lastname, :firstname, :birth_date, :registration_date, :role )', array( 'login' => array( 'VAL' => $user->getLogin(), 'TYPE' => PDO::PARAM_STR ), 'lastname' => array( 'VAL' => $user->getLastname(), 'TYPE' => PDO::PARAM_STR ), 'firstname' => array( 'VAL' => $user->getFirstname(), 'TYPE' => PDO::PARAM_STR ), 'birth_date' => array( 'VAL' => $user->getBirthDate(), 'TYPE' => PDO::PARAM_STR ), 'registration_date' => array( 'VAL' => $user->getRegistrationDate(), 'TYPE' => PDO::PARAM_STR ), 'role' => array( 'VAL' => $user->getRole(), 'TYPE' => PDO::PARAM_INT ) ) );
        } catch( PDOException $e ) {
            throw new KernelException( 'Can not get the <strong>' . $this->getModel() . '</strong> datas', $e->getCode(), $e );
        } catch( Exception $e ) {
            throw new KernelException( 'Can not get the <strong>' . $this->getModel() . '</strong> datas', $e->getCode(), $e );
        }
    }

    /**
     * getById - Performs a query to select a user by id
     * @param   int     $id
     * @return  mixed (ClassUser|bool)
    **/
    public function getById( $id ) {
        try {
            if( ( $out = $this->query( 'SELECT * FROM `' . self::TABLE . '` WHERE `u_id`=:id', array( 'id' => array( 'VAL' => $id, 'TYPE' => PDO::PARAM_INT ) ) ) )!==false && count( $out )>0 )
                return new ClassUser( $out[0] );

            return false;
        } catch( PDOException $e ) {
            throw new KernelException( 'Can not get the <strong>' . $this->getModel() . '</strong> datas', $e->getCode(), $e );
        } catch( Exception $e ) {
            throw new KernelException( 'Can not get the <strong>' . $this->getModel() . '</strong> datas', $e->getCode(), $e );
        }
    }

    /**
     * getByLogin - Performs a query to select a user by login
     * @param   string  $login
     * @return  mixed (ClassUser|bool)
    **/
    public function getByLogin( $login ) {
        try {
            if( ( $out = $this->query( 'SELECT * FROM `' . self::TABLE . '` WHERE `u_login`=:login', array( 'login' => array( 'VAL' => $login, 'TYPE' => PDO::PARAM_STR ) ) ) )!==false && count( $out )>0 )
                return new ClassUser( $out[0] );

            return false;
        } catch( PDOException $e ) {
            throw new KernelException( 'Can not get the <strong>' . $this->getModel() . '</strong> datas', $e->getCode(), $e );
        } catch( Exception $e ) {
            throw new KernelException( 'Can not get the <strong>' . $this->getModel() . '</strong> datas', $e->getCode(), $e );
        }
    }
}