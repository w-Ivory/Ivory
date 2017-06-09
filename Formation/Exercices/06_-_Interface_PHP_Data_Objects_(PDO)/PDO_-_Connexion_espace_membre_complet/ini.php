<?php
/**
 * --------------------------------------------------
 * SESSIONS
 * --------------------------------------------------
**/
session_start(); // On autorise la page à accéder à la superglobale de session (http://php.net/manual/fr/function.session-start.php).
if( !defined( 'APP_TAG' ) ) define( 'APP_TAG', 'adminO3W' );
if( isset( $_GET ) && array_key_exists( 'destroy', $_GET ) ) : // Si la clé "destroy" est passée en paramètre dans l'URL,
    if( defined( 'APP_TAG' ) ) unset( $_SESSION[APP_TAG] ); // On détruit la session pour vider l'historique (http://php.net/manual/fr/function.session-destroy.php).
    header( 'Location: .' ); // On utilise la fonction "header" pour rediriger vers la racine du code en cours (http://php.net/manual/fr/function.header.php).
    exit();
endif;
/**
 * --------------------------------------------------
 * APP GENERALS
 * --------------------------------------------------
**/
if( !defined( 'DOMAIN' ) ) define( 'DOMAIN', ( isset( $_SERVER['REQUEST_SCHEME'] ) ? $_SERVER['REQUEST_SCHEME'] : 'http' ) . '://' . $_SERVER['SERVER_NAME'] . dirname( $_SERVER['PHP_SELF'] ) . '/' );
if( !defined( 'ASSETSURL' ) ) define( 'ASSETSURL', DOMAIN . 'assets/' ); // On définit le chemin vers le dossier contenant les fichiers à inclure.
/**
 * --------------------------------------------------
 * DB
 * --------------------------------------------------
**/
if( !defined( 'DB_HOST' ) ) define( 'DB_HOST', 'localhost' );
if( !defined( 'DB_NAME' ) ) define( 'DB_NAME', 'cours_administration' );
if( !defined( 'DB_LOGIN' ) ) define( 'DB_LOGIN', 'root' );
if( !defined( 'DB_PWD' ) ) define( 'DB_PWD', '' );
/**
 * --------------------------------------------------
 * PATHS
 * --------------------------------------------------
**/
if( !defined( 'DS' ) ) define( 'DS', DIRECTORY_SEPARATOR ); // On définit le séparateur de dossiers lié au système.
if( !defined( 'ABSPATH' ) ) define( 'ABSPATH', __DIR__ . DS ); // On définit le dossier racine.
if( !defined( 'ASSETSPATH' ) ) define( 'ASSETSPATH', ABSPATH . 'assets' . DS ); // On définit le chemin vers le dossier contenant les fichiers à inclure.
if( !defined( 'INCPATH' ) ) define( 'INCPATH', ABSPATH . 'inc' . DS ); // On définit le chemin vers le dossier contenant les fichiers à inclure.
/**
 * --------------------------------------------------
 * PAGE SETTINGS
 * --------------------------------------------------
**/
if( !defined( 'TITLE_SEPARATOR' ) ) define( 'TITLE_SEPARATOR', ' | ' );
if( !defined( 'SITE_TITLE' ) ) define( 'SITE_TITLE', 'Administration' );
if( !defined( 'AUTHOR_NAME' ) ) define( 'AUTHOR_NAME', 'De Admin à Damien, il n\'y a qu\'une lettre ...' );