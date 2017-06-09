<?php

define('CONFIG_PDO_DSN', 'mysql:dbname=chat;host=localhost');
define('CONFIG_PDO_USER', 'root');
define('CONFIG_PDO_PASSWORD', '');


function my_autoload($class)
{
    $path = ROOT.DS.'FW'.DS.$class.'.php';
    if (file_exists($path)) {
        include $path;
    } else {
        if ( substr($class, -10)=="Controller" && file_exists(ROOT.DS.'App'.DS.'Controller'.DS.$class.'.php')) {
            include ROOT.DS.'App'.DS.'Controller'.DS.$class.'.php';
        } elseif ( substr($class, -5)=="Model" && file_exists(ROOT.DS.'App'.DS.'Model'.DS.$class.'.php')) {
            include ROOT.DS.'App'.DS.'Model'.DS.$class.'.php';
        }
    }
}

spl_autoload_register('my_autoload');