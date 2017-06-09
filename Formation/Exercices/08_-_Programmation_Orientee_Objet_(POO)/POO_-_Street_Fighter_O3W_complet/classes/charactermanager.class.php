<?php
require_once( 'character.class.php' );
/**
 * ------------------------------------------------------------
 * CLASSE GÉRANT LA BASE DE DONNÉES POUR L'ENTITÉ "PERSONNAGE"
 * ------------------------------------------------------------
**/
class CharacterManager {
    /**
     * --------------------------------------------------
     * PROPRIÉTÉ(S)
     * --------------------------------------------------
    **/
    private $_db;
    /**
     * --------------------------------------------------
     * CONSTANTE(S) DE CLASSE
     * --------------------------------------------------
    **/
    const QUERY_CREATE_TABLE = 'CREATE TABLE IF NOT EXISTS `character` (
  `name` varchar(255) DEFAULT NULL,
  `damages` int(11) NOT NULL DEFAULT "0",
  `css` longtext NULL DEFAULT ""
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT="Liste des personnages";
ALTER TABLE `character` ADD PRIMARY KEY (`name`);';
    const QUERY_DROP_TABLE = 'DROP TABLE IF EXISTS `character`;';



    /**
     * --------------------------------------------------
     * MÉTHODES MAGIQUES
     * --------------------------------------------------
    **/
    /**
     * __construct - Constructeur de classe
     * @param   string  $host
     *          string  $dbname
     *          string  $login
     *          string  $pass
     * @return
    **/
    public function __construct( $host, $dbname, $login, $pass ) {
        $this->setDb( $host, $dbname, $login, $pass ); // On définit l'instance PDO
        $this->executeQuery( self::QUERY_CREATE_TABLE ); // On crée la table correspondante aux personnages si elle n'existe pas
    }



    /**
     * --------------------------------------------------
     * MUTATEUR(S)
     * --------------------------------------------------
    **/
    public function setDb( $host, $dbname, $login, $pass ) {
        try {
            $this->_db = new PDO( 'mysql:host=' . $host . ';dbname=' . $dbname . ';charset=utf8', $login, $pass, array( PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES utf8 COLLATE utf8_general_ci', PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION ) ); // On crée une instance de la classe PDO qui par défaut nous connecte à la base de données.
        } catch( PDOException $e ) { // Dans le cas d'un échec, on récupère l'exception
            throw new CharacterException( $e->getMessage() ); // On tue le processus et affiche le message d'erreur
        }
    }



    /**
     * --------------------------------------------------
     * MÉTHODE(S)
     * --------------------------------------------------
    **/
    /**
     * getList - Exécute une requête de sélection d'un jeu d'enregistrements en bdd
     * @param   
     * @return  mixed (array|bool)
    **/
    public function getList() {
        try {
            $datas = array();

            // if( ( $q = $this->_db->query( 'SELECT * FROM `character` ORDER BY `name` ASC' ) )!==false ) : // Si l'exécution de la requête nous retourne un résultat,
            //     while( ( $arr_row = $q->fetch( PDO::FETCH_ASSOC ) ) && $arr_row!==false ) : // Pour chaque ligne du jeu de résultats,
            //         $datas[] = new Character( $arr_row ); // On stocke une nouvellle instance de Character
            //     endwhile;
            //     $q->closeCursor(); // On termine le traitement de la requête

            //     return $datas;
            // endif;
            if( ( $out = $this->executeQuery( 'SELECT * FROM `character` ORDER BY `name` ASC' ) )!==false && count( $out )>0 ) :
                foreach( $out as $row ) :
                    $datas[] = new Character( $row ); // On stocke une nouvellle instance de Character
                endforeach;

                return $datas;
            endif;

            return false;
        } catch( PDOException $e ) { // Dans le cas d'un échec, on récupère l'exception
            throw new CharacterException( $e->getMessage() ); // On tue le processus et affiche le message d'erreur
        }
    }

    /**
     * get - Exécute une requête de sélection d'un enregistrement en bdd depuis un identifiant
     * @param   string  $name
     * @return  mixed (object|bool)
    **/
    public function get( $name ) {
        try {
            // if( ( $q = $this->_db->prepare( 'SELECT * FROM `character` WHERE `name`=:id' ) )!==false ) : // Si l'exécution de la requête nous retourne un résultat,
            //     if( $q->bindParam( ':id', $name ) && $q->execute() ) : // Si l'exécution de la requête nous retourne un résultat,
            //         if( ( $arr_row = $q->fetch( PDO::FETCH_ASSOC ) )!==false ) : // On stocke la première ligne de resultat
            //             $q->closeCursor(); // On termine le traitement de la requête
                        
            //             return new Character( $arr_row );
            //         endif;
            //     endif;
            // endif;
            if( ( $out = $this->executeQuery( 'SELECT * FROM `character` WHERE `name`=:id', array( 'id' => array( 'VAL' => $name, 'TYPE' => PDO::PARAM_STR ) ) ) )!==false && count( $out )>0 )
                return new Character( $out[0] );

            return false;
        } catch( PDOException $e ) { // Dans le cas d'un échec, on récupère l'exception
            throw new CharacterException( $e->getMessage() ); // On tue le processus et affiche le message d'erreur
        }
    }

    /**
     * record_exists - Vérifie l'existance d'un enregistrement en bdd
     * @param   string  $name
     * @return  bool
    **/
    public function record_exists( $name ) {
        try {
            // if( ( $q = $this->_db->prepare( 'SELECT COUNT( DISTINCT( `name` ) ) as cpt FROM `character` WHERE `name`=:id' ) )!==false ) : // Si l'exécution de la requête nous retourne un résultat,
            //     if( $q->bindParam( ':id', $name ) && $q->execute() ) : // Si l'exécution de la requête nous retourne un résultat,
            //         if( ( $arr_row = $q->fetch( PDO::FETCH_ASSOC ) )!==false && $arr_row['cpt']>0 ) : // On stocke la première ligne de resultat
            //             $q->closeCursor(); // On termine le traitement de la requête
                        
            //             return true;
            //         endif;
            //     endif;
            // endif;
            if( ( $out = $this->executeQuery( 'SELECT COUNT( DISTINCT( `name` ) ) as cpt FROM `character` WHERE `name`=:id', array( 'id' => array( 'VAL' => $name, 'TYPE' => PDO::PARAM_STR ) ) ) )!==false && count( $out )>0 && $out[0]['cpt']>0 )
                return true;

            return false;
        } catch( PDOException $e ) { // Dans le cas d'un échec, on récupère l'exception
            throw new CharacterException( $e->getMessage() ); // On tue le processus et affiche le message d'erreur
        }
    }

    /**
     * add - Exécute une requête d'ajout d'un enregistrement en bdd depuis un objet
     * @param   object  $character
     * @return  mixed (int|bool)
    **/
    public function add( Character $character ) {
        try {
            // if( ( $q = $this->_db->prepare( 'INSERT INTO `character` (`name`, `damages`, `css`) VALUES (:id, :damage, :css)' ) )!==false ) // Si l'exécution de la requête nous retourne un résultat,
            //     if( ( $tmp = $character->getName() ) && $q->bindValue( ':id', $tmp )
            //      && ( $tmp = $character->getDamages() )!==false && $q->bindValue( ':damage', $tmp, PDO::PARAM_INT )
            //      && ( $tmp = $character->getCss() )!==false && $q->bindValue( ':css', $tmp ) )
            //             return $q->execute();

            // return false; // On retroune si l'exécution s'est bien déroulée ou non
            return $this->executeQuery( 'INSERT INTO `character` (`name`, `damages`, `css`) VALUES (:id, :damage, :css)', array( 'id' => array( 'VAL' => $character->getName(), 'TYPE' => PDO::PARAM_STR ), 'damage' => array( 'VAL' => $character->getDamages(), 'TYPE' => PDO::PARAM_INT ), 'css' => array( 'VAL' => $character->getCss(), 'TYPE' => PDO::PARAM_STR ) ) );
        } catch( PDOException $e ) { // Dans le cas d'un échec, on récupère l'exception
            throw new CharacterException( $e->getMessage() ); // On tue le processus et affiche le message d'erreur
        }
    }

    /**
     * update - Exécute une requête de modification d'un enregistrement en bdd depuis un objet
     * @param   object  $character
     * @return  mixed (int|bool)
    **/
    public function update( Character $character ) {
        try {
            // if( ( $q = $this->_db->prepare( 'UPDATE `character` SET `damages`=:damage WHERE `name`=:id' ) )!==false ) // Si l'exécution de la requête nous retourne un résultat,
            //     if( ( $tmp = $character->getDamages() )!==false && $q->bindValue( ':damage', $tmp, PDO::PARAM_INT )
            //      && ( $tmp = $character->getName() ) && $q->bindValue( ':id', $tmp ) )
            //         return $q->execute(); // On retroune si l'exécution s'est bien déroulée ou non

            // return false;
            return $this->executeQuery( 'UPDATE `character` SET `damages`=:damage WHERE `name`=:id', array( 'damage' => array( 'VAL' => $character->getDamages(), 'TYPE' => PDO::PARAM_INT ), 'id' => array( 'VAL' => $character->getName(), 'TYPE' => PDO::PARAM_STR ) ) );
        } catch( PDOException $e ) { // Dans le cas d'un échec, on récupère l'exception
            throw new CharacterException( $e->getMessage() ); // On tue le processus et affiche le message d'erreur
        }
    }

    /**
     * delete - Exécute une requête de suppression d'un enregistrement en bdd depuis un objet
     * @param   string  $name
     * @return  mixed (int|bool)
    **/
    public function delete( $name ) {
        try {
            // if( ( $q = $this->_db->prepare( 'DELETE FROM `character` WHERE `name`=:id' ) )!==false ) // Si l'exécution de la requête nous retourne un résultat,
            //     if( $q->bindParam( ':id', $name ) )
            //         return $q->execute(); // On retroune si l'exécution s'est bien déroulée ou non.

            // return false;
            return $this->executeQuery( 'DELETE FROM `character` WHERE `name`=:id', array( 'id' => array( 'VAL' => $name, 'TYPE' => PDO::PARAM_STR ) ) );
        } catch( PDOException $e ) { // Dans le cas d'un échec, on récupère l'exception
            throw new CharacterException( $e->getMessage() ); // On tue le processus et affiche le message d'erreur
        }
    }
    
    /**
     * executeQuery - Execute une requête SQL
     * @param   string  $query
     *          array   $options    [optional]
     * @return  mixed (array|bool)
    **/
    private function executeQuery( $query, $options = array() ) {
        try { // On essaie de faire
            if( count( $options )>0 ) : // Si on passe des paramètres à notre requête,
                if( ( $stmt = $this->_db->prepare( $query ) )!==false ) : // Si la préparation de la requête SQL via PDO nous retourne un résultat,
                    $bind = true;
                    foreach( $options as $key => $value ) :
                        // $bindFunction = $value['TYPE']==PDO::PARAM_NULL ? 'bindValue' : 'bindParam';
                        // if( ( $bind = $stmt->$bindFunction( $key, $val, ( isset( $value['TYPE'] ) ? $value['TYPE'] : PDO::PARAM_STR ) ) )===false ) :
                        if( ( $bind = $stmt->bindValue( $key, $value['VAL'], ( isset( $value['TYPE'] ) ? $value['TYPE'] : PDO::PARAM_STR ) ) )===false ) :
                            break;
                        endif;
                    endforeach;

                    if( $bind && ( $out = $stmt->execute() )===true ) : //Si tous les "bindParam" et l'exécution de la reuqête se sont bien déroulés, (on stocke le résultat de l'exécution dans la variable "_arr_datas" au passage)
                        if( strtoupper( substr( $query, 0, 6 ) )=='SELECT' ) : // Si la requête est une requête de sélection,
                            $out = $stmt->fetchAll( PDO::FETCH_ASSOC ); // On stocke le jeu de resultats au format tableau associatif.
                        endif;
                        $stmt->closeCursor(); // On termine le traitement de la requête.
                        
                        return $out;
                    endif;

                endif;
            else :
                if( strtoupper( substr( $query, 0, 6 ) )=='SELECT' ) : // Si la requête est une requête de sélection,
                    if( ( $stmt = $this->_db->query( $query ) )!==false ) : // Si l'exécution de la requête SQL via PDO nous retourne un résultat,
                        $out = $stmt->fetchAll( PDO::FETCH_ASSOC ); // On stocke le jeu de resultats au format tableau associatif.
                        $stmt->closeCursor(); // On termine le traitement de la requête.

                        return $out;
                    endif;
                else : // Sinon,
                    return $this->_db->exec( $query ); // On exécute la requête et retourne le nombre de lignes affectées.
                endif;
            endif;

            return false;
        } catch( PDOException $e ) { // Dans le cas d'un échec, on récupère l'exception
            throw new CharacterException( $e->getMessage() );
        }
    }





    /**
     * reset - Exécute une requête en bdd
     * @param   
     * @return  bool
    **/
    public function reset() {
        return $this->executeQuery( self::QUERY_DROP_TABLE );
    }
}