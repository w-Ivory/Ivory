<?php
/**
 * executeQuery - Execute une requête SQL
 * @param   
 * @return  object
**/
function connectDB() {
    try { // On essaie de faire
        $_str_host = 'localhost';
        $_str_dbname = 'cours_tunnels';
        $_str_login = 'root';
        $_str_pwd = '';

        return new PDO( 'mysql:host=' . $_str_host . ';dbname=' . $_str_dbname . ';charset=utf8', $_str_login, $_str_pwd, array( PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION ) ); // On crée une instance de l'objet PDO qui par défaut nous connecte à la base de données.
    } catch( PDOException $_e ) { // Dans le cas d'un échec, on récupère l'exception
        die( $_e->getMessage() ); // On tue le processus et affiche le message d'erreur.
    }
}


/**
 * executeQuery - Execute une requête SQL
 * @param   object  $pdo
 *          string  $str
 *          array   $options    [optional]
 * @return  mixed (array|bool)
**/
function executeQuery( $pdo, $str, $options = array() ) {
    try { // On essaie de faire
        if( count( $options )>0 ) : // Si on passe des paramètres à notre requête,
            if( ( $_pdo_stmt = $pdo->prepare( $str ) )!==false ) : // Si la préparation de la requête SQL via PDO nous retourne un résultat,
                $_bind_ctrl = true;
                foreach( $options as $key => $value ) :
                    // $bindFunction = $value['TYPE']==PDO::PARAM_NULL ? 'bindValue' : 'bindParam';
                    // if( ( $_bind_ctrl = $_pdo_stmt->$bindFunction( $key, $val, ( isset( $value['TYPE'] ) ? $value['TYPE'] : PDO::PARAM_STR ) ) )===false ) :
                    if( ( $_bind_ctrl = $_pdo_stmt->bindValue( $key, $value['VAL'], ( isset( $value['TYPE'] ) ? $value['TYPE'] : PDO::PARAM_STR ) ) )===false ) :
                        break;
                    endif;
                endforeach;

                if( $_bind_ctrl && ( $_arr_datas = $_pdo_stmt->execute() )===true ) : //Si tous les "bindParam" et l'exécution de la reuqête se sont bien déroulés, (on stocke le résultat de l'exécution dans la variable "_arr_datas" au passage)
                    if( strtoupper( substr( $str, 0, 6 ) )=='SELECT' ) : // Si la requête est une requête de sélection,
                        $_arr_datas = $_pdo_stmt->fetchAll( PDO::FETCH_ASSOC ); // On stocke le jeu de resultats au format tableau associatif.
                    endif;
                    $_pdo_stmt->closeCursor(); // On termine le traitement de la requête.
                    
                    return $_arr_datas;
                endif;

            endif;
        else :
            if( strtoupper( substr( $str, 0, 6 ) )=='SELECT' ) : // Si la requête est une requête de sélection,
                if( ( $_pdo_stmt = $pdo->query( $str ) )!==false ) : // Si l'exécution de la requête SQL via PDO nous retourne un résultat,
                    $_arr_datas = $_pdo_stmt->fetchAll( PDO::FETCH_ASSOC ); // On stocke le jeu de resultats au format tableau associatif.
                    $_pdo_stmt->closeCursor(); // On termine le traitement de la requête.

                    return $_arr_datas;
                endif;
            else : // Sinon,
                return $pdo->exec( $str ); // On exécute la requête et retourne le nombre de lignes affectées.
            endif;
        endif;

        return false;
    } catch( PDOException $_e ) { // Dans le cas d'un échec, on récupère l'exception
        die( $_e->getMessage() ); // On tue le processus et affiche le message d'erreur.
    }
}


/**
 * validateDate - Valide le format d'une date en fonction du format
 * @param   string  $date
 *          string  $format    [optional]
 * @return  bool
**/
function validateDate( $date, $format='Y-m-d H:i:s' ) {
    $_d = DateTime::createFromFormat( $format, $date );
    return ( $_d && ( $_d->format( $format ) == $date ) );
}