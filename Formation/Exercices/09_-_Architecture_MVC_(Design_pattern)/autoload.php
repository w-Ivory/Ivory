<?php
function autoload_generator($path, $hint=NULL, $extension = '.class.php')
{
	return function ($classname) use ($path, $hint, $extension)
	{
		if(is_null($hint) || strpos($classname, $hint) !== false)
		{
			$file = $path . $classname . $extension;
			if(file_exists($file))
			{
				require($file);
			}
		}
	};
}

function add_autoload($path, $hint=NULL, $extension = '.class.php')
{
	spl_autoload_register(autoload_generator($path, $hint, $extension));
}

add_autoload(Config\Path\core, 'Core');
add_autoload(Config\Path\controller, 'Controller');
add_autoload(Config\Path\model, 'Model');
add_autoload(Config\Path\view, 'View');
add_autoload(Config\Path\except, 'Exception', '.exception.php');
add_autoload(Config\Path\user);		//Search defaults in user directory (eg. application specific classes) AFTER all others failed