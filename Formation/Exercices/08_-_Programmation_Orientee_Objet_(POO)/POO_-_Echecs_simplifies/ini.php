<?php
error_reporting( E_ALL & ~E_NOTICE ); // Sets which PHP errors are reported (http://php.net/manual/fr/function.error-reporting.php)
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
    define( 'APP_TAG', 'easyChessO3W' );
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
    define( 'DB_NAME', 'cours_easychess' );
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
    define( 'COREPATH', ABSPATH . 'core' . DS ); // Defines the path to the folder containing the core files
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
    define( 'SITE_TITLE', 'EasyChess O3W' );
if( !defined( 'AUTHOR_NAME' ) )
    // define( 'AUTHOR_NAME', 'I made you<span class="font-chess" style="color:rgb(215,9,129);display:inline-block;vertical-align:top;transform:rotateZ(45deg);">&#0119</span> !' );
    define( 'AUTHOR_NAME', 'I made you<span style="color:rgb(215,9,129);display:inline-block;vertical-align:top;transform:rotateZ(45deg);">&#9812;</span> !' );
/**
 * --------------------------------------------------
 * APP SETTINGS
 * --------------------------------------------------
**/
$_app_settings = array(
    'font'  => array( // Custom font
        'file'  => 'assets/font/CHEQ_TT.ttf',
        'name'  => 'Chess Regular'
    ),
    'color' => array( // Custom colors
        // 'board'     => 'rgb(148,141,125)',
        // 'alternate' => 'rgb(215,9,129)',
        'borders'   => array(
            'top'       => 'rgb(191,186,175)',
            'right'     => 'rgb(96,92,84)',
            'bottom'    => 'rgb(66,63,58)',
            'left'      => 'rgb(173,169,161)'
        ),
        'text'      => array(
            'all'   => 'rgb(21,21,21)',
            'light' => 'rgb(255,255,255)',
            'dark'  => 'rgb(21,21,21)'
        )
    )
);