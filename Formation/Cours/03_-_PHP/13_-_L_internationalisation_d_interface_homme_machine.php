<?php
/**
 * --------------------------------------------------
 * CORE PREDEFINED CONSTANTS
 * http://php.net/manual/fr/reserved.constants.php
 * --------------------------------------------------
**/
if( strtoupper( substr( PHP_OS, 0, 3 ) ) == 'WIN' ) // If the version of the operating system (provided by the pre-defined constants PHP_OS) corresponds to a Windows kernel,
    if( !defined( 'DIRECTORY_SEPARATOR') )
        define( 'DIRECTORY_SEPARATOR', "\\" );
else
    if( !defined( 'DIRECTORY_SEPARATOR') )
        define( 'DIRECTORY_SEPARATOR', "/" );

if( !defined( 'DS' ) )
    define( 'DS', DIRECTORY_SEPARATOR ); // Defines the folder separator connected to the system
/**
 * --------------------------------------------------
 * LOCALES
 * --------------------------------------------------
**/
if( !defined( 'CHARSET' ) )
    define( 'CHARSET', 'UTF-8' ); // Defines the character encoding
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

date_default_timezone_set( 'Europe/Paris' ); // Sets the default timezone used by all date/time functions in a script // timezone_identifiers_list() // if( strcmp( date_default_timezone_get(), ini_get( 'date.timezone' ) ) )
mb_internal_encoding( CHARSET ); // Sets/Gets internal character encoding
putenv( 'LC_ALL=' . ISO_LANGUAGE_CODE . '-' . ISO_COUNTRY_CODE ); // Sets the value of an environment variable
setlocale( LC_ALL, LOCALE_STRING ); // Sets locale information for date and time formatting with strftime()
// bindtextdomain( 'intl_O3W', '13_-_L_internationalisation_d_interface_homme_machine' . DS . 'languages' . DS . 'nocache' ); // Specifies location of translation tables
bindtextdomain( 'intl_O3W', '13_-_L_internationalisation_d_interface_homme_machine' . DS . 'languages' ); // Specifies location of translation tables
textdomain( 'intl_O3W' ); // Chooses domain
?><!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0" />
        <title>L'internationalisation d'IHM</title>

        <!-- // highlight.js : Coloration syntaxique du code -->
        <link rel="stylesheet" type="text/css" href="../../_assets/plugins/highlight/styles/monokai_sublime.css">
        <script type="text/javascript" src="../../_assets/plugins/highlight/highlight.pack.js"></script>
        <script type="text/javascript">
            hljs.initHighlightingOnLoad();
        </script>
        <!-- // -->

        <link rel="stylesheet" type="text/css" href="../../_assets/css/style.css">
    </head>
    <body>
        <h1>L'internationalisation d'IHM</h1>
        <!--
        <p><em></em></p>
        <hr />
        <h2></h2>
        <h3></h3>
        <p><em></em></p>
        <pre><code class="php"></code></pre>
        -->
        <?php
        $prenom = 'Damien';
        echo gettext( 'Hello world !' );
        echo '<br>';
        printf( _( 'My name is %s !!!' ), $prenom );
        echo '<br>';
        printf( ngettext( '<p>I have <strong>%d</strong> article</p>', '<p>I have <strong>%d</strong> articles</p>', 3 ), 3 );
        ?>
    </body>
</html>