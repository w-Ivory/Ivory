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
    if( !defined( 'PATH_SEPARATOR') ) : define( 'PATH_SEPARATOR', ';' ); endif;
    if( !defined( 'DIRECTORY_SEPARATOR') ) : define( 'DIRECTORY_SEPARATOR', "\\" ); endif;
else :
    if( !defined( 'PHP_EOL') ) : define( 'PHP_EOL', "\n" ); endif;
    if( !defined( 'PATH_SEPARATOR') ) : define( 'PATH_SEPARATOR', ':' ); endif;
    if( !defined( 'DIRECTORY_SEPARATOR') ) : define( 'DIRECTORY_SEPARATOR', "/" ); endif;
endif;

if( !defined( 'DS' ) )
    define( 'DS', DIRECTORY_SEPARATOR ); // Defines the folder separator connected to the system
/**
 * --------------------------------------------------
 * PATHS
 * --------------------------------------------------
**/
if( !defined( 'DOMAIN' ) )
    define( 'DOMAIN', ( isset( $_SERVER['REQUEST_SCHEME'] ) ? $_SERVER['REQUEST_SCHEME'] : 'http' ) . '://' . $_SERVER['SERVER_NAME'] . dirname( $_SERVER['PHP_SELF'] ) . '/../' );

if( !defined( 'THEMES_URL' ) )
    define( 'THEMES_URL', DOMAIN . 'web/' ); // Defines the path to the folder containing the files to include
if( !defined( 'ASSETS_URL' ) )
    define( 'ASSETS_URL', THEMES_URL . 'assets/' ); // Defines the path to the folder containing the files to include

if( !defined( 'ABSPATH' ) )
    define( 'ABSPATH', __DIR__ . DS . '..' . DS . '..' . DS ); // Defines the root folder
if( !defined( 'VENDORPATH' ) )
    define( 'VENDORPATH', ABSPATH . 'vendor' . DS ); // Defines the path to the folder containing the third-party dependencies
if( !defined( 'APPPATH' ) )
    define( 'APPPATH', ABSPATH . 'app' . DS ); // Defines the path to the folder containing the application configuration and translations
if( !defined( 'RESOURCESPATH' ) )
    define( 'RESOURCESPATH', APPPATH . 'resources' . DS ); // Defines the path to the folder containing the resources files
if( !defined( 'THEMESPATH' ) )
    define( 'THEMESPATH', APPPATH . 'themes' . DS ); // Defines the path to the folder containing the themes files
if( !defined( 'VARPATH' ) )
    define( 'VARPATH', ABSPATH . 'var' . DS ); // Defines the path to the folder containing the generated files (cache, logs, ...)
if( !defined( 'BUNDLESPATH' ) )
    define( 'BUNDLESPATH', ABSPATH . 'bundles' . DS ); // Defines the path to the folder containing the project's PHP code
if( !defined( 'WEBPATH' ) )
    define( 'WEBPATH', ABSPATH . 'web' . DS ); // Defines the path to the folder containing the web root directory
if( !defined( 'ASSETSPATH' ) )
    define( 'ASSETSPATH', WEBPATH . 'assets' . DS ); // Defines the path to the folder containing the assets files

// set_include_path( get_include_path() . PATH_SEPARATOR . VENDORPATH . PATH_SEPARATOR . APPPATH . PATH_SEPARATOR . BUNDLESPATH );
if( !defined( 'REQUIRED_PATH' ) )
    define( 'REQUIRED_PATH', VENDORPATH . PATH_SEPARATOR . APPPATH . PATH_SEPARATOR . BUNDLESPATH );
/**
 * --------------------------------------------------
 * SESSION
 * --------------------------------------------------
**/
if( !defined( 'APP_TAG' ) )
    define( 'APP_TAG', 'ForumO3W' );
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
 * APP SETTINGS
 * --------------------------------------------------
**/
if( !defined( 'TITLE_SEPARATOR' ) )
    define( 'TITLE_SEPARATOR', ' | ' );
if( !defined( 'SITE_TITLE' ) )
    define( 'SITE_TITLE', 'Forum O3W' );
if( !defined( 'AUTHOR_NAME' ) )
    define( 'AUTHOR_NAME', 'Bla bla bla bla' );
if( !defined( 'SUPPORT_EMAIL' ) )
    define( 'SUPPORT_EMAIL', 'webmaster@localhost' );

if( !defined( 'RESULTS_PER_PAGE' ) )
    define( 'RESULTS_PER_PAGE', 20 );
/**
 * --------------------------------------------------
 * LOCALES
 * --------------------------------------------------
**/
if( !defined( 'ENCODING' ) )
    define( 'ENCODING', 'UTF8' ); // Defines the character encoding
if( !defined( 'ISO_LANGUAGE_CODE' ) )
    define( 'ISO_LANGUAGE_CODE', 'fr' ); // Defines the abbreviation for language
if( !defined( 'ISO_COUNTRY_CODE' ) )
    define( 'ISO_COUNTRY_CODE', 'FR' ); // Defines the abbreviation for language

if( strtoupper( substr( PHP_OS, 0, 3 ) ) == 'WIN' ) // If the version of the operating system (provided by the pre-defined constants PHP_OS) corresponds to a Windows kernel,
    if( !defined( 'LOCALE_STRING') )
        define( 'LOCALE_STRING', 'fra' );
else
    if( !defined( 'LOCALE_STRING') )
        define( 'LOCALE_STRING', ISO_LANGUAGE_CODE . '-' . ISO_COUNTRY_CODE );
