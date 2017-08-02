<?php
// Test this using following command
// php -S localhost:8080
	require 'vendor/autoload.php';

	use StarWar\Types;
	use StarWar\AppContext;
	use GraphQL\Schema;
	use GraphQL\GraphQL;

	try {
		// Prepare context that will be available in all field resolvers (as 3rd argument):
		$appContext				= new AppContext();
		$appContext->rootUrl	= 'http://localhost:8080';
		$appContext->request	= $_REQUEST;

		// Parse incoming query and variables
		if ($raw = file_get_contents('php://input')) {
			$data = json_decode($raw, true);
		} else {
			$data = $_REQUEST;
		}

		$data += ['query' => null, 'variables' => null];

		$result = [];
		$query	= $data['query'];

		if (null !== $query) {
			// GraphQL schema to be passed to query executor
			$schema = new Schema([
				'query'    => Types::query(),
				'mutation' => Types::mutation(),
			]);

			$args	= json_decode($data['variables'], true);
			$result	= GraphQL::execute($schema, $query, null, $appContext, $args);
		}

		$httpStatus = array_key_exists('errors', $result) ? 400 : 200;
	} catch (\Exception $e) {
		$httpStatus = 500;

		$result = [
			'error' => [
				'message' => $e->getMessage(),
			],
		];
	}
	
	header('Content-Type: application/json', true, $httpStatus);
	header('Access-Control-Allow-Origin: http://localhost:9000');
	echo json_encode($result);
