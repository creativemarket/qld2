<?php

	$routes = [
		''			=> 'index.html',
		'graphql'	=> 'graphql.php',
	];

	$request = trim($_SERVER['REQUEST_URI'], '/');

	require $routes[$request];
