<?php
///Criando o projeto
require '../Slim/Slim/Slim.php';
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();
//$app->response()->header('Content-Type', 'application/json;charset=utf-8');


$app->config(array(
	'debug' => true,
	'templates.path' => 'views'
	));

$app->get('/', function(){

	echo 'ola';
});

$app->get('/home/:nome', function($nome) use ($app){
	$app->render('templets.php', array('nome' => $nome));//redirect
}
)->conditions(array('nome' => '[a-z]{0,3}'));//conditiosn filtro nas repostas

$app->run();
?>