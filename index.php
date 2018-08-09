<?php
session_start();
define('_DB_SERVER_', 'localhost');
define('_DB_USER_', 'root');
define('_DB_PASSWD_', '');
define('_DB_NAME_', 'dutch');
//simple namespace-based loader
spl_autoload_register(function($className){
	include(__DIR__.DIRECTORY_SEPARATOR.str_replace('\\', DIRECTORY_SEPARATOR, $className).'.php');});

new Controller\LoginController;
$section = empty($_GET['section']) || !in_array($_GET['section'], ['Tags', 'Words', 'Test']) ? 'Words' : $_GET['section'] ;
$controller = 'Controller\\'.$section.'Controller';
new $controller;
