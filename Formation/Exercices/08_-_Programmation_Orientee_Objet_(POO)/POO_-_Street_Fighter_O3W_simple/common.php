<?php
/**
 * loadClasses - Vérifie si un fichier existe et l'inclut
 * @param   string  $className
 * @return  
**/
function loadClasses( $className ) {
    $_file_ = 'classes/' . strtolower( $className ) . '.class.php';
    if( file_exists( $_file_ ) )
        require_once( $_file_ );
}
spl_autoload_register( 'loadClasses' ); // On enregistre la fonction "loadClasses" en tant qu'implémentation de __autoload()