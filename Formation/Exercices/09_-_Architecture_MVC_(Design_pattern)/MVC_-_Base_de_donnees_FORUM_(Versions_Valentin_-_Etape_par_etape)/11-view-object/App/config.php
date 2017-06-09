<?php

define('CONFIG_PDO_DSN', 'mysql:dbname=chat;host=localhost');
define('CONFIG_PDO_USER', 'root');
define('CONFIG_PDO_PASSWORD', '');



function my_autoload($class){
    if (file_exists('FW'.DS.$class.'.php')) {
        include 'FW'.DS.$class.'.php';
    } else {
        if (
            substr($class, -10)=="Controller" &&
            file_exists('App'.DS.'Controller'.DS.$class.'.php')
            ) {
            include 'App'.DS.'Controller'.DS.$class.'.php';
        } elseif (
            substr($class, -5)=="Model" &&
            file_exists('App'.DS.'Model'.DS.$class.'.php')
            ) {
            include 'App'.DS.'Model'.DS.$class.'.php';
        }
    }
    //var_dump('autoload : '.$class);
}
spl_autoload_register('my_autoload');