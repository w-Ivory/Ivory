<?php

require_once('App/config.php');


//Choix du controller
$controllerName = str_replace(array('/','.','\\'),'',ucfirst(SRequest::getInstance()->get('controller')));
if ($controllerName == "") {
    $controllerName = 'Index';
}
$controllerClassName = $controllerName.'Controller';


$appController = new $controllerClassName (SRequest::getInstance());


//Choix de l'action
$actionName = SRequest::getInstance()->get('action');
if ($actionName == "") {
    $actionName = 'index';
}
$actionMethodName = $actionName.'Action';

if (method_exists($appController, $actionMethodName)) {
    $appController->setAction($actionName);
    $appController->$actionMethodName();
} else {
    throw new Exception("Error: No action => ".$controllerClassName."::".$actionMethodName."()", 1);
}
