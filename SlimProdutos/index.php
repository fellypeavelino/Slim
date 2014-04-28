<?php
///Criando o projeto
require '../Slim/Slim/Slim.php';
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();
$app->response()->header('Content-Type', 'application/json;charset=utf-8');
$app->get('/', function () {
echo "SlimProdutos";
});
//mapeamentos
$app->get('/categorias','getCategorias');// ->get('controller', 'modulo')
$app->post('/produtos','addProduto');
/*
	mapeamento diz que se houver uma requisição
	“POST /produtos”, o método addProduto será chamado. 
*/
$app->get('/produtos/:id','getProduto');

$app->run();

///Exibindo as categorias

function getConn()
{
	return new PDO('mysql:host=localhost;dbname=SlimProdutos',
	'root','',
	array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
);

}

function getCategorias()
{
	$stmt = getConn()->query("SELECT * FROM Categorias");
	$categorias = $stmt->fetchAll(PDO::FETCH_OBJ);
	echo "{categorias:".json_encode($categorias)."}";
}

//Incluindo produtos

function addProduto()
{
	$request = \Slim\Slim::getInstance()->request();
	$produto = json_decode($request->getBody());
	$sql = "
		INSERT INTO produtos (nome,preco,dataInclusao,idCategoria) values 
		(:nome,:preco,:dataInclusao,:idCategoria) 
	";
	$conn = getConn();
	$stmt = $conn->prepare($sql);
	$stmt->bindParam("nome",$produto->nome);
	$stmt->bindParam("preco",$produto->preco);
	$stmt->bindParam("dataInclusao",$produto->dataInclusao);
	$stmt->bindParam("idCategoria",$produto->idCategoria);
	$stmt->execute();
	$produto->id = $conn->lastInsertId();//metodo pdo para retornar ultimo id
	echo json_encode($produto);
}

//Obtendo um produto

function getProduto($id)

{
	$conn = getConn();
	$sql = "SELECT * FROM produtos WHERE id=:id";
	$stmt = $conn->prepare($sql);
	$stmt->bindParam("id",$id);
	$stmt->execute();
	$produto = $stmt->fetchObject();

	//categoria
	$sql = "SELECT * FROM categorias WHERE id=:id";
	$stmt = $conn->prepare($sql);
	$stmt->bindParam("id",$produto->idCategoria);
	$stmt->execute();
	$produto->categoria = $stmt->fetchObject();

	echo json_encode($produto);
}


//http://imasters.com.br/linguagens/php/aprenda-a-usar-o-restful-com-php-e-slim-framework/