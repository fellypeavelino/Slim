<?php 
	require '../Slim/Slim/Slim.php';
	\Slim\Slim::registerAutoloader();
	define('CONTROLLERS_PATH', './controllers/'); 
	define('VIEWS_PATH', './views/'); 
	$app = new \Slim\Slim(
		array( 
			'templates.path' => VIEWS_PATH 
		)); 
	$controllerDir = opendir(CONTROLLERS_PATH); 
	while ($controller = readdir($controllerDir)) { 
		if($controller != '.' && $controller != '..') 
			require CONTROLLERS_PATH . $controller; 
	} 
$app->run(); 