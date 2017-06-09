<?php

require_once('App/config.php');
require_once('FW/SRequest.php');


//Choix du controller
$controllerName = str_replace(array('/','.','\\'),'',ucfirst(SRequest::getInstance()->get('controller')));
if ($controllerName == "") {
    $controllerName = 'Index';
}
$controllerClassName = $controllerName.'Controller';

$controllerFile = 'App/Controller/'.$controllerClassName.'.php';
if (file_exists($controllerFile)){
    require_once($controllerFile);
}else{
    throw new Exception("Error: No Controller named : ".$controllerName, 1);
}
$appController = new $controllerClassName (SRequest::getInstance());



//Choix de l'action
$actionName = SRequest::getInstance()->get('action');
if ($actionName == "") {
    $actionName = 'index';
}
$actionMethodName = $actionName.'Action';

if (method_exists($appController, $actionMethodName)) {
    $appController->$actionMethodName();
} else {
    throw new Exception("Error: No action => ".$controllerClassName."::".$actionMethodName."()", 1);
}
