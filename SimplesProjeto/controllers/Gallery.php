<?php 
	$app->get('/', function() 
		use ($app) { 
			require 'config/db.php'; 
			$pdo = new PDO($dsn, $usuario, $senha); 
			$stmt = $pdo->query('SELECT * FROM gallery'); 
			$data = $stmt->fetchAll();
			$app->render('index.phtml', array('data' => $data)); 
		}); 
	
	$app->get('/gallery/:id', function($id) 
		use ($app) { 
			require 'config/db.php'; 
			$pdo = new PDO($dsn, $usuario, $senha); 
			$stmt = $pdo->query("SELECT * FROM gallery where id = $id"); 
			$gallery = $stmt->fetchAll(); 
			$stmt = $pdo->query("SELECT * FROM image where gallery_id = $id"); 
			$images = $stmt->fetchAll(); 
			$app->render('gallery.phtml', array('gallery' => $gallery, 'images' => $images));
		}); 
?> 