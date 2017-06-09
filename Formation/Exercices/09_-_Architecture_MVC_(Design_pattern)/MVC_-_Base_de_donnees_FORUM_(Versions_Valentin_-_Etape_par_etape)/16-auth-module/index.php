<?php

define('ROOT',__DIR__);
define('DS',DIRECTORY_SEPARATOR);

define('APP_DIR','App');
define('FW_DIR','FW');

define('APP_PATH',ROOT.DS.APP_DIR);
define('FW_PATH',ROOT.DS.FW_DIR);


//Chargement de la configuration nécessaire au fonctionnement du FW :
require(FW_PATH.DS.'config.php');
//Chargement de la configuration nécessaire au fonctionnement de mon Application :
require(APP_PATH.DS.'config.php');

//Démarrage du Contrôleur Frontal
$AppFrontController = new FrontController();
$AppFrontController->start();
