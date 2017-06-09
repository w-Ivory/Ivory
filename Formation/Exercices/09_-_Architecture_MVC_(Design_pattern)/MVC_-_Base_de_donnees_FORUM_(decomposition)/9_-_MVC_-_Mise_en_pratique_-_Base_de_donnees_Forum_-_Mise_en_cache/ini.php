<?php
/**
 * --------------------------------------------------
 * CORE PREDEFINED CONSTANTS
 * http://php.net/manual/fr/reserved.constants.php
 * --------------------------------------------------
**/
if( strtoupper( substr( PHP_OS, 0, 3 ) ) == 'WIN' ) : // If the version of the operating system (provided by the pre-defined constants PHP_OS) corresponds to a Windows kernel,
    if( !defined( 'PHP_EOL') ) : define( 'PHP_EOL', "\r\n" ); endif;
    if( !defined( 'DIRECTORY_SEPARATOR') ) : define( 'DIRECTORY_SEPARATOR', "\\" ); endif;
    if( !defined( 'LOCALE_STRING') ) : define( 'LOCALE_STRING', 'fra' ); endif;
else :
    if( !defined( 'PHP_EOL') ) : define( 'PHP_EOL', "\n" ); endif;
    if( !defined( 'DIRECTORY_SEPARATOR') ) : define( 'DIRECTORY_SEPARATOR', "/" ); endif;
    if( !defined( 'LOCALE_STRING') ) : define( 'LOCALE_STRING', 'fr-FR' ); endif;
endif;

/**
 * --------------------------------------------------
 * LOCALES
 * --------------------------------------------------
**/
if( !defined( 'ENCODING' ) ) define( 'ENCODING', 'UTF8' ); // Defines the character encoding
date_default_timezone_set( 'Europe/Paris' ); // Sets the default timezone used by all date/time functions in a script
$locale = setlocale( LC_ALL, LOCALE_STRING ); // Sets locale information for date and time formatting with strftime()

/**
 * -------------------------------------------------
 * --------------------------------------------------
**/
if( !defined( 'DS' ) ) define( 'DS', DIRECTORY_SEPARATOR ); // Defines the folder separator connected to the system
if( !defined( 'ABSPATH' ) ) define( 'ABSPATH', __DIR__ . DS ); // Defines the root folder
if( !defined( 'APPPATH' ) ) define( 'APPPATH', ABSPATH . 'App' . DS ); // Defines the path to the folder containing the aplication files
if( !defined( 'CONTROLLERSPATH' ) ) define( 'CONTROLLERSPATH', APPPATH . 'Controllers' . DS ); // Defines the path to the folder containing the controllers files
if( !defined( 'MODELSPATH' ) ) define( 'MODELSPATH', APPPATH . 'Models' . DS ); // Defines the path to the folder containing the models files
if( !defined( 'VIEWSPATH' ) ) define( 'VIEWSPATH', APPPATH . 'Views' . DS ); // Defines the path to the folder containing the views files
if( !defined( 'FWPATH' ) ) define( 'FWPATH', ABSPATH . 'FW' . DS ); // Defines the path to the folder containing the framework files
if( !defined( 'COREPATH' ) ) define( 'COREPATH', FWPATH . 'core' . DS ); // Defines the path to the folder containing the kernel files for the framework
if( !defined( 'ASSETSPATH' ) ) define( 'ASSETSPATH', FWPATH . 'assets' . DS ); // Defines the path to the folder containing the assets files
/**
 * --------------------------------------------------
 * DB
 * --------------------------------------------------
**/
if( !defined( 'DB_HOST' ) ) define( 'DB_HOST', 'localhost' );
if( !defined( 'DB_NAME' ) ) define( 'DB_NAME', 'cours_forum' );
if( !defined( 'DB_LOGIN' ) ) define( 'DB_LOGIN', 'root' );
if( !defined( 'DB_PWD' ) ) define( 'DB_PWD', '' );
/**
 * --------------------------------------------------
 * CACHE
 * --------------------------------------------------
**/
if( !defined('CACHEPATH') ) define( 'CACHEPATH', FWPATH . 'cache' . DS ); // Defines the path to the folder containing the cached files
if( !defined('CACHEDELAY') ) define( 'CACHEDELAY', 60 ); // Defines the path to the cache delay