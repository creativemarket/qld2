<?php
// Test this using following command
// php -S localhost:8080 ./graphql.php
	require 'vendor/autoload.php';

	use StarWar\Types;
	use StarWar\AppContext;
	use StarWar\Data\DataSource;
	use GraphQL\Schema;
	use GraphQL\GraphQL;

	try {
		// Initialize our fake data source
		DataSource::init();

		// Prepare context that will be available in all field resolvers (as 3rd argument):
		$appContext = new AppContext();
		$appContext->viewer = DataSource::findCharacter('1');
		$appContext->rootUrl = 'http://localhost:8080';
		$appContext->request = $_REQUEST;

		// Parse incoming query and variables
		if (isset($_SERVER['CONTENT_TYPE']) && strpos($_SERVER['CONTENT_TYPE'], 'application/json') !== false) {
			$raw = file_get_contents('php://input') ?: '';
			$data = json_decode($raw, true);
		} else {
			$data = $_REQUEST;
		}

		$data += ['query' => null, 'variables' => null];

		if (null === $data['query']) {
			$data['query'] = '{hello}';
		}

		// GraphQL schema to be passed to query executor:
		$schema = new Schema([
			'query' => Types::query(),
		]);

		$result = GraphQL::execute($schema, $data['query'], null, $appContext, (array) $data['variables']);
		$httpStatus = 200;
	} catch (\Exception $e) {
		$httpStatus = 500;
		$result = [
			'error' => [
				'message' => $e->getMessage()
			]
		];
	}
	header('Content-Type: application/json', true, $httpStatus);
	echo json_encode($result);
