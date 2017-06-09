<?php
define('ROOT', __DIR__);
define('DS',DIRECTORY_SEPARATOR);

require_once(ROOT.DS.'App'.DS.'config.php');


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
