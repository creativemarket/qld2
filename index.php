<?php

	$routes = [
		''			=> 'index.html',
		'graphql'	=> 'graphql.php',
	];

	$request = trim($_SERVER['REQUEST_URI'], '/');

	// Access-Control headers are received during OPTIONS requests
	if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
		header("Access-Control-Allow-Origin: http://localhost:9000");
		header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
		if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
			header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
		exit(0);
	}

	require $routes[$request];
