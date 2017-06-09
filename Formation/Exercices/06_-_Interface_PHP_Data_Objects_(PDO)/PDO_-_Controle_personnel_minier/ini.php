<?php
/**
 * --------------------------------------------------
 * APP GENERALS
 * --------------------------------------------------
**/
if( !defined( 'DOMAIN' ) ) define( 'DOMAIN', ( isset( $_SERVER['REQUEST_SCHEME'] ) ? $_SERVER['REQUEST_SCHEME'] : 'http' ) . '://' . $_SERVER['SERVER_NAME'] . dirname( $_SERVER['PHP_SELF'] ) . '/' );
if( !defined( 'ASSETSURL' ) ) define( 'ASSETSURL', DOMAIN . 'assets/' ); // On définit le chemin vers le dossier contenant les fichiers à inclure.

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
if( !defined( 'SITE_TITLE' ) ) define( 'SITE_TITLE', 'Contrôle du personnel minier en zone de creusage intensif' );
if( !defined( 'AUTHOR_NAME' ) ) define( 'AUTHOR_NAME', 'Cie d\'un nain formateur (d\'un ... nain ... formateur ... d\'un informateur ... blague ! Rigolez. RIGOLEZ J\'AI DIT !!!)' );