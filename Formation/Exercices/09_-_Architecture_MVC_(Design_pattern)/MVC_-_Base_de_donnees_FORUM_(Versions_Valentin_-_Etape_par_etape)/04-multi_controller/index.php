<?php


//Point d'entrée de mon application
require_once('SRequest.php');

//Choix du controller
//
switch(SRequest::getInstance()->get('controller')){
	case 'user':
		require_once('Controller/UserController.php');
		$ctrl = new UserController(SRequest::getInstance());
		//Choix de l'action
		switch(SRequest::getInstance()->get('action')){
			case 'voir':
				$ctrl->voirAction();
				break;
			default : 
				$ctrl->indexAction();
		}
		break;
	case 'conversation':
		require_once ('Controller/ConversationController.php');
		$ctrl = new ConversationController(SRequest::getInstance());
		//Choix de l'action
		switch(SRequest::getInstance()->get('action')){
			default : 
				$ctrl->indexAction();
		}
		break;
	default : 
		require_once ('Controller/IndexController.php');
		$ctrl = new IndexController(SRequest::getInstance());
		//Choix de l'action
		switch(SRequest::getInstance()->get('action')){
			default : 
				$ctrl->indexAction();
		}
		
}