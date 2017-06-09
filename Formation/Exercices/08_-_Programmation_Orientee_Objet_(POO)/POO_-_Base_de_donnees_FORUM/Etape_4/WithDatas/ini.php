<?php
error_reporting( E_ALL & ~E_NOTICE ); // Sets which PHP errors are reported (http://php.net/manual/fr/function.error-reporting.php)
if( !defined( 'DEBUG_MODE' ) )
	define( 'DEBUG_MODE', TRUE );
/**
 * --------------------------------------------------
 * CORE PREDEFINED CONSTANTS
 * http://php.net/manual/fr/reserved.constants.php
 * --------------------------------------------------
**/
if( strtoupper( substr( PHP_OS, 0, 3 ) ) == 'WIN' ) : // If the version of the operating system (provided by the pre-defined constants PHP_OS) corresponds to a Windows kernel,
    if( !defined( 'PHP_EOL') ) : define( 'PHP_EOL', "\r\n" ); endif;
    if( !defined( 'DIRECTORY_SEPARATOR') ) : define( 'DIRECTORY_SEPARATOR', "\\" ); endif;
else :
    if( !defined( 'PHP_EOL') ) : define( 'PHP_EOL', "\n" ); endif;
    if( !defined( 'DIRECTORY_SEPARATOR') ) : define( 'DIRECTORY_SEPARATOR', "/" ); endif;
endif;
/**
 * --------------------------------------------------
 * SESSIONS
 * --------------------------------------------------
**/
session_start(); // Starts a new session or take over an existing session
if( !defined( 'APP_TAG' ) )
    define( 'APP_TAG', 'forumO3W' );
/**
 * --------------------------------------------------
 * APP GENERALS
 * --------------------------------------------------
**/
if( !defined( 'DOMAIN' ) )
    define( 'DOMAIN', ( isset( $_SERVER['REQUEST_SCHEME'] ) ? $_SERVER['REQUEST_SCHEME'] : 'http' ) . '://' . $_SERVER['SERVER_NAME'] . dirname( $_SERVER['PHP_SELF'] ) . '/' );
if( !defined( 'ASSETSURL' ) )
    define( 'ASSETSURL', DOMAIN . 'assets/' ); // Defines the path to the folder containing the files to include
/**
 * --------------------------------------------------
 * DB
 * --------------------------------------------------
**/
if( !defined( 'DB_HOST' ) )
    define( 'DB_HOST', 'localhost' );
if( !defined( 'DB_NAME' ) )
    define( 'DB_NAME', 'cours_forum' );
if( !defined( 'DB_LOGIN' ) )
    define( 'DB_LOGIN', 'root' );
if( !defined( 'DB_PWD' ) )
    define( 'DB_PWD', '' );
/**
 * --------------------------------------------------
 * PATHS
 * --------------------------------------------------
**/
if( !defined( 'DS' ) )
    define( 'DS', DIRECTORY_SEPARATOR ); // Defines the folder separator connected to the system
if( !defined( 'ABSPATH' ) )
    define( 'ABSPATH', __DIR__ . DS ); // Defines the root folder
if( !defined( 'COREPATH' ) )
    define( 'COREPATH', ABSPATH . 'core' . DS ); // Defines the path to the folder containing the core's files
if( !defined( 'APPPATH' ) )
    define( 'APPPATH', ABSPATH . 'app' . DS ); // Defines the path to the folder containing the application's files
if( !defined( 'ASSETSPATH' ) )
    define( 'ASSETSPATH', ABSPATH . 'assets' . DS ); // Defines the path to the folder containing the assets files
if( !defined( 'INCPATH' ) )
    define( 'INCPATH', ABSPATH . 'inc' . DS ); // Defines the path to the folder containing the files to include
/**
 * --------------------------------------------------
 * PAGE SETTINGS
 * --------------------------------------------------
**/
if( !defined( 'TITLE_SEPARATOR' ) )
    define( 'TITLE_SEPARATOR', ' | ' );
if( !defined( 'SITE_TITLE' ) )
    define( 'SITE_TITLE', 'Forum O3W' );
if( !defined( 'AUTHOR_NAME' ) )
    define( 'AUTHOR_NAME', 'Bla bla bla bla' );

if( !defined( 'SPEECH_BALLOON' ) )
    define( 'SPEECH_BALLOON', '&#128172;' );
if( !defined( 'LEFT_SPEECH_BUBBLE' ) )
    define( 'LEFT_SPEECH_BUBBLE', '&#128488;' );
if( !defined( 'RIGHT_SPEECH_BUBBLE' ) )
    define( 'RIGHT_SPEECH_BUBBLE', '&#128489;' );
if( !defined( 'TWO_SPEECH_BUBBLES' ) )
    define( 'TWO_SPEECH_BUBBLES', '&#128490;' );
if( !defined( 'THREE_SPEECH_BUBBLES' ) )
    define( 'THREE_SPEECH_BUBBLES', '&#128491;' );

if( !defined( 'RESULTS_PER_PAGE' ) )
    define( 'RESULTS_PER_PAGE', 20 );