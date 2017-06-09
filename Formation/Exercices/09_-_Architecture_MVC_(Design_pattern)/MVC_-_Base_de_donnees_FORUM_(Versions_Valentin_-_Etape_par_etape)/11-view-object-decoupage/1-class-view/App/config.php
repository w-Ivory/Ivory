<?php

define('CONFIG_PDO_DSN', 'mysql:dbname=chat;host=localhost');
define('CONFIG_PDO_USER', 'root');
define('CONFIG_PDO_PASSWORD', '');


function my_autoload($class){
    if (file_exists('FW/'.$class.'.php')) {
        include 'FW/'.$class.'.php';
    } else {
        if (
            substr($class, -10)=="Controller" &&
            file_exists('App/Controller/'.$class.'.php')
            ) {
            include 'App/Controller/'.$class.'.php';
        } elseif (
            substr($class, -5)=="Model" &&
            file_exists('App/Model/'.$class.'.php')
            ) {
            include 'App/Model/'.$class.'.php';
        }
    }
}
spl_autoload_register('my_autoload');