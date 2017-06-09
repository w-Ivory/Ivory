<?php
/**
 * --------------------------------------------------
 * SESSIONS
 * --------------------------------------------------
**/
session_start(); // On démarre une nouvelle session ou reprend une session existante
if( !defined( 'APP_TAG' ) ) define( 'APP_TAG', 'streetFighterO3W' );
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
if( !defined( 'DB_SCHEME' ) ) define( 'DB_SCHEME', 'mysql' );
if( !defined( 'DB_HOST' ) ) define( 'DB_HOST', 'localhost' );
if( !defined( 'DB_NAME' ) ) define( 'DB_NAME', 'streetfighter' );
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