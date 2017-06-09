<?php
session_start();

require_once( 'SRequest.php' );

echo '$_GET contient : ';
var_dump( $_GET );
echo '<br />';
echo 'SRequest::getInstance()->get( \'toto\' ) contient : ';
var_dump( SRequest::getInstance()->get( 'toto' ) );
echo '<br />';
echo '$_GET contient : ';
var_dump( $_GET );
echo '<br />';
echo 'SRequest::getInstance()->get( \'titi\' ) contient : ';
var_dump( SRequest::getInstance()->get( 'titi' ) );
echo '<br />';
echo 'SRequest::getInstance()->getSession( \'blaencore_encore\' ) contient : ';
var_dump( SRequest::getInstance()->setSession( 'blaencore_encore', 'bla infini' ) );
var_dump( SRequest::getInstance()->getSession( 'blaencore_encore' ) );
echo '<br />';
echo '$_SESSION[\'blaencore_encore\'] contient : ';
var_dump( $_SESSION['blaencore_encore'] );
echo '<br />';


$req = new SRequest;
?>

<a href="index.php">Lien précédent</a>