<?php 
	require '../Slim/Slim/Slim.php'; 
	\Slim\Slim::registerAutoloader();
	$app = new \Slim\Slim();

	$app->get('/hello/:name', function ($name) { 
		/*get('controller/ chamada de modulo :modulo', modulo)*/
		echo "Hello, $name!"; 
	}); 
	//rotas
	$app->run(); 
?>