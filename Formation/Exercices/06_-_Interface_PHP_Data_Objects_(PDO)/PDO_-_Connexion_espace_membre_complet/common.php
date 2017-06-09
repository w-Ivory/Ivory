<?php
/**
 * connectDB - Ouvre une connexion à une base de données MySQL
 * @param   string  $host
 *          string  $name
 *          string  $login
 *          string  $pwd
 * @return  object
**/
function connectDB( $host, $name, $login, $pwd ) {
    try { // On essaie de faire
        return new PDO( 'mysql:host=' . $host . ';dbname=' . $name . ';charset=utf8', $login, $pwd, array( PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION ) ); // On crée une instance de l'objet PDO qui par défaut nous connecte à la base de données.
    } catch( PDOException $_e ) { // Dans le cas d'un échec, on récupère l'exception
        // return array( '_err'=>array( 'code'=>$_e->getCode(), 'msg'=>'<span style="background-color:red;color:white;display:block;margin:10px 0;padding:4px 7px;">' . $_e->getMessage() . '</span>' ) ); // On stocke en session les données d'erreur.
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
        if( is_array( $options ) && count( $options )>0 ) : // Si on passe des paramètres à notre requête,
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
        return array( '_err'=>array( 'code'=>$_e->getCode(), 'msg'=>'<span style="background-color:red;color:white;display:block;margin:10px 0;padding:4px 7px;">' . $_e->getMessage() . '</span>' ) ); // On stocke en session les données d'erreur.
        // die( $_e->getMessage() ); // On tue le processus et affiche le message d'erreur.
    }
}



/**
 * validateDate - Valide le format d'une date en fonction du format
 * @param   string  $date
 *          string  $format    [optional]
 * @return  bool
**/
function validateDate( $date, $format = 'Y-m-d H:i:s' ) {
    $_d = DateTime::createFromFormat( $format, $date );
    return ( $_d && ( $_d->format( $format ) == $date ) );
}



/**
 * redirect - Redirige en cas d'erreur de routage
 * @param   string  $page
 * @return  
**/
function redirect( $page='.' ) {
    header( $_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found' );
    header( 'Location:' . $page ); // On redirige vers la page.
    exit;
}



/**
 * isErr - Vérifie si une erreur s'est produite
 * @param   array   $arr
 *          string  $key    [optional]
 * @return  mixed (array|bool)
**/
function isErr( $arr, $key='_err' ) {
    if( is_array( $arr ) && count( $arr )>0 && array_key_exists( $key, $arr ) ) : // Si la clé existe dans le tableau,
        return $arr[$key];
    endif;

    return false;
}



/**
 * authenticate - Tente de connecter un utilisateur
 * @param   object  $pdo
 *          string  $keyLogin
 *          string  $keyPwd
 *          array   $arr
 * @return  mixed (array|bool)
**/
function authenticate( $pdo, $keyLogin, $keyPwd, $arr ) {
    if( isset( $arr ) && is_array( $arr ) && array_key_exists( $keyLogin, $arr ) && array_key_exists( $keyPwd, $arr ) ) : // Si un utilisateur tente de se connecter,
        $_str_query = 'SELECT `user`.`id` AS "ID", `user`.`login` AS "login", `user`.`lastname` AS "nom", `user`.`firstname` AS "pnom", `role`.`id` AS "roleID", `role`.`lbl` AS "role", `role`.`power` AS "puissance", GROUP_CONCAT( `capability`.`id` ORDER BY `capability`.`id` ASC SEPARATOR ";" ) AS "autorisations"
FROM `user`
INNER JOIN `role` ON `user`.`role_fk`=`role`.`id`
LEFT JOIN `rel_role_capability` ON `role`.`id`=`rel_role_capability`.`role`
LEFT JOIN `capability` ON `rel_role_capability`.`capability`=`capability`.`id`
WHERE `user`.`login`=:login AND `user`.`pwd`=:pwd
GROUP BY `user`.`id`
LIMIT 1'; // On définit la chaîne de caractères représentant la requête
        $_arr_options = array( // On définit les options de la requête
            'login' => array(
                'VAL'   => $arr[$keyLogin]
            ),
            'pwd'   => array(
                'VAL'   => $arr[$keyPwd]
            )
        );
        if( ( $_user = executeQuery( $pdo, $_str_query, $_arr_options ) )!==false && count( $_user )>0 && isErr( $_user )===false ) : // Si le système a une référence unique et que la requête a pu s'exécuter sans renvoyer d'erreur,
            return $_user[0]; // On retourne l'utilisateur en session
        else : // Sinon,
            if( isset( $_user ) && array_key_exists( '_err', $_user ) ) : // Si une erreur ou une exception est retournée,
                return $_user; // On retourne l'erreur/exception
            else : // Sinon,
                return array( '_err'=>array( 'code'=>'all', 'msg'=>'<span style="background-color:orange;color:white;display:block;margin:10px 0;padding:4px 7px;">Mauvais identifiant/mot de passe !</span>' ) ); // On retourne l'erreur
            endif;
        endif;
    endif;

    return false;
}



/**
 * isAuthentified - Vérifie qu'un utilisateur est authentifié
 * @param   string  $key
 *          array   $arr
 * @return  bool
**/
function isAuthentified( $key, $arr ) {
    if( defined( 'APP_TAG' ) && isset( $arr ) && is_array( $arr ) && array_key_exists( APP_TAG, $arr ) && array_key_exists( $key, $arr[APP_TAG] ) && isErr( $arr[APP_TAG][$key] )===false ) : // Si le système est configuré correctement ou qu'un utilisateur est connécté sans erreur,
        return true;
    endif;

    return false;
}



/**
 * isReallyAuthentified - Vérifie qu'un utilisateur est authentifié et que les données correspondent à la base de données
 * @param   object  $pdo
 *          string  $key
 *          array   $arr
 * @return  bool
**/
function isReallyAuthentified( $pdo, $key, $arr ) {
    if( isAuthentified( $key, $arr ) ) :
        $_str_query = 'SELECT GROUP_CONCAT( `capability`.`id` ORDER BY `capability`.`id` ASC SEPARATOR ";" ) AS "autorisations"
FROM `user`
INNER JOIN `role` ON `user`.`role_fk`=`role`.`id`
LEFT JOIN `rel_role_capability` ON `role`.`id`=`rel_role_capability`.`role`
LEFT JOIN `capability` ON `rel_role_capability`.`capability`=`capability`.`id`
WHERE `user`.`id`=:id AND `user`.`role_fk`=:role
GROUP BY `user`.`id`
HAVING autorisations=:capabilities
LIMIT 1'; // On définit la chaîne de caractères représentant la requête
        $_arr_options = array( // On définit les options de la requête
            'id'            => array(
                'VAL'   => $arr[APP_TAG][$key]['ID'],
                'TYPE'  => PDO::PARAM_INT
            ),
            'role'          => array(
                'VAL'   => $arr[APP_TAG][$key]['roleID'],
                'TYPE'  => PDO::PARAM_INT
            ),
            'capabilities'  => array(
                'VAL'   => $arr[APP_TAG][$key]['autorisations']
            )
        );
        if( ( $res = executeQuery( $pdo, $_str_query, $_arr_options ) )!==false && is_array( $res ) && count( $res )>0 && isErr( $res )===false ) :
            return true;
        endif;
    endif;

    return false;
}



/**
 * hasPower - Vérifie qu'un utilisateur est autorisé à faire une action
 * @param   object  $pdo
 *          int     $key
 *          int     $comp
 * @return  bool
**/
function hasPower( $pdo, $key, $comp ) {
    $_str_query = 'SELECT `role`.`id`
FROM `role`
WHERE `role`.`id`=:role
AND `role`.`power`>=:power
LIMIT 1'; // On définit la chaîne de caractères représentant la requête
    $_arr_options = array( // On définit les options de la requête
        'role'  => array(
            'VAL'   => $key,
            'TYPE'  => PDO::PARAM_INT
        ),
        'power'  => array(
            'VAL'   => $comp,
            'TYPE'  => PDO::PARAM_INT
        )
    );
    if( ( $res = executeQuery( $pdo, $_str_query, $_arr_options ) )!==false && is_array( $res ) && count( $res )>0 && isErr( $res )===false ) :
        return true;
    endif;

    return false;
}



/**
 * getPower - Retourne la puissance d'un utilisateur
 * @param   object  $pdo
 *          int     $key
 *          int     $comp
 * @return  bool
**/
function getPower( $pdo, $key ) {
    $_str_query = 'SELECT `role`.`id`
FROM `user`
INNER JOIN `role` ON `user`.`role_fk`=`role`.`id`
WHERE `user`.`id`=:id
LIMIT 1'; // On définit la chaîne de caractères représentant la requête
    $_arr_options = array( // On définit les options de la requête
        'id'    => array(
            'VAL'   => $key,
            'TYPE'  => PDO::PARAM_INT
        )
    );
    if( ( $res = executeQuery( $pdo, $_str_query, $_arr_options ) )!==false && is_array( $res ) && count( $res )>0 && isErr( $res )===false ) :
        return $res[0]['id'];
    endif;

    return false;
}



/**
 * hasAbility - Vérifie qu'un utilisateur a les droits pour faire une opération
 * @param   string  $ability
 *          array   $arr
 * @return  bool
**/
function hasAbility( $ability, $arr ) {
    if( in_array( $ability, $arr ) ) : // Si le système n'est pas configuré correctement ou qu'aucun utilisateur n'est connécté,
        return true;
    endif;

    return false;
}



/**
 * displayError - Affiche les erreurs
 * @param   string  $err
 * @return  
**/
function displayError( $err ) {
    switch( $err ) :
        case 'ability':
            echo '<span style="background-color:red;color:white;display:block;margin:10px 0;padding:4px 7px;">Vous ne disposez pas des droits nécessaires pour cette action !</span>';
            break;
        case 'param':
            echo '<span style="background-color:red;color:white;display:block;margin:10px 0;padding:4px 7px;">Veuillez indiquer tous les paramètres obligatoires à votre requête !</span>';
            break;
        case 'pwd':
            echo '<span style="background-color:red;color:white;display:block;margin:10px 0;padding:4px 7px;">Les mots de passe ne sont pas identiques !</span>';
            break;
    endswitch;
}