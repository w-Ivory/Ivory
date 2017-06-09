<?php
require_once( 'classes/user.class.php' );
require_once( 'classes/userManager.class.php' );

$tUsers = array();

define( 'HOST', 'localhost' );
define( 'DB', 'cours_forum' );
define( 'LOGIN', 'root' );
define( 'PASS', '' );

$maConnexion = new Manager( HOST, DB, LOGIN, PASS );

$maConnexion->setTable( User::TABLE );
foreach( $maConnexion->getList() as $user ) {
    echo $user;
}

$_str_query = 'INSERT INTO `' . User::TABLE . '` (`u_login`, `u_prenom`, `u_nom`, `u_date_naissance`, `u_date_inscription`, `u_rang_fk`) VALUES ("ghhghg", "tugudu", "patafiole", NOW(), NOW(), 3);'; // On définit la chaîne de caractères représentant la requête.""
$_arr_datas = $maConnexion->executeQuery( $_str_query );