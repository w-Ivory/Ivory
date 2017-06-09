<?php
//Point d'entrée de mon application
require_once('Controller.php');
require_once('SRequest.php');

$ctrl = new Controller(SRequest::getInstance());

if(SRequest::getInstance()->get('action') == 'voir'){
	$ctrl->voirAction();
}else{
	$ctrl->indexAction();
}
