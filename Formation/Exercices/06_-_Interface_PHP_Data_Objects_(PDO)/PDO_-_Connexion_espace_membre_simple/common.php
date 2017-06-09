<?php
function manageError( $err ) {
    if( isset( $err ) ) {
        switch( $err ) {
            case 'connect':
                return 'Mauvais identifiant/mot de passe';
                break;
            case 'vide':
                return 'Veuillez saisir tous les champs';
                break;
            case 'cap':
                return 'Vous n\'avez pas l\'autorisation';
                break;
        }
    }
}


function logout( &$masession ) {
    unset( $masession );
    redirect( 'login.php' );
}


function redirect( $destination ) {
    header( 'Location:' . $destination );
    exit();
}

function connectDB() {
    try {
        $_str_host = 'localhost';
        $_str_dbname = 'cours_administration';
        $_str_login = 'root';
        $_str_pwd = '';

        return new PDO( 'mysql:host=' . $_str_host . ';dbname=' . $_str_dbname . ';charset=utf8', $_str_login, $_str_pwd, array( PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION ) ); // On crée une instance de l'objet PDO qui par défaut nous connecte à la base de données.
    } catch ( PDOException $e ) {
        die( $e->getMessage() );
    }
}