<?php
/**
 * --------------------------------------------------
 * APP GENERALS
 * --------------------------------------------------
**/
if( !defined( 'DOMAIN' ) ) define( 'DOMAIN', ( isset( $_SERVER['REQUEST_SCHEME'] ) ? $_SERVER['REQUEST_SCHEME'] : 'http' ) . '://' . $_SERVER['SERVER_NAME'] . dirname( $_SERVER['PHP_SELF'] ) . '/' );

/**
 * --------------------------------------------------
 * PATHS
 * --------------------------------------------------
**/
if( !defined('DS') ) define( 'DS', DIRECTORY_SEPARATOR ); // On définit le séparateur de dossiers lié au système.
if( !defined( 'ABSPATH' ) ) define( 'ABSPATH', __DIR__ . DS ); // On définit le répoertoire racine.

/**
 * --------------------------------------------------
 * GAME SETTINGS
 * --------------------------------------------------
**/
if( !defined('INITIALJACKPOT') ) define( 'INITIALJACKPOT', 5 ); // On définit le montant par défaut de la cagnotte.
if( !defined('PRICETICKET') ) define( 'PRICETICKET', 2 ); // On définit le prix de chaque ticket.
if( !defined('MAXTICKETS') ) define( 'MAXTICKETS', 100 ); // On définit le nombre maximum de tickets par tirage.
if( !defined('GAINS') ) define( 'GAINS', array( 100, 50, 20 ) ); // On définit les prix du tirage au sort.