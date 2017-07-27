<?php
	namespace StarWar\Type;

	use StarWar\AppContext;
	use StarWar\Data\DataSource;
	use StarWar\Types;
	use GraphQL\Type\Definition\ObjectType;
	use GraphQL\Type\Definition\ResolveInfo;
	use GraphQL\Type\Definition\Type;

	class QueryType extends ObjectType {
		/**
		 * QueryType constructor.
		 */
		public function __construct() {
			$config = [
				'name' => 'Query',
				'fields'=> [
					'character' => [
						'type' => Types::character(),
						'description' => 'Returns character by id',
						'args' => [
							'id' => Types::nonNull(Types::id()),
						],
					],
					'characters' => [
						'type' => Types::listOf(Types::character()),
						'description' => 'Returns all characters',
					],
					'movie' => [
						'type' => Types::movie(),
						'description' => 'Returns movie by id',
						'args' => [
							'id' => Types::nonNull(Types::id()),
						],
					],
					'movies' => [
						'type' => Types::listOf(Types::movie()),
						'description' => 'Returns movies',
					],
					'quote' => [
						'type' => Types::quote(),
						'description' => 'Return quote by id',
						'args' => [
							'id' => Types::nonNull(Types::id()),
						],
					],
					'quotes' => [
						'type' => Types::listOf(Types::quote()),
						'description' => 'Returns all quotes'
					],
					'hello' => Type::string(),
				],
				'resolveField' => function ($value, $args, $context, ResolveInfo $info) {
					$method = 'resolve' . ucfirst($info->fieldName);
					return $this->{$method}($value, $args, $context, $info);
				}
			];
			parent::__construct($config);
		}

		/**
		 * @param $rootValue
		 * @param $args
		 * @return null|\StarWar\Data\character
		 */
		public function resolveCharacter($rootValue, $args) {
			return $this->db()->findCharacter($args['id']);
		}

		/**
		 * @param $rootValue
		 * @param $args
		 * @return array
		 */
		public function resolveCharacters($rootValue, $args) {
			return $this->db()->findCharacters();
		}

		/**
		 * @param $rootValue
		 * @param $args
		 * @return null|\StarWar\Data\movie
		 */
		public function resolveMovie($rootValue, $args) {
			return $this->db()->findMovie($args['id']);
		}

		/**
		 * @param $rootValue
		 * @param $args
		 * @return array
		 */
		public function resolveMovies($rootValue, $args) {
			return $this->db()->findMovies();
		}

		/**
		 * @param $rootValue
		 * @param $args
		 * @return null|\StarWar\Data\quote
		 */
		public function resolveQuote($rootValue, $args) {
			return $this->db()->findQuote($args['id']);
		}

		/**
		 * @param $rootValue
		 * @param $args
		 * @return array
		 */
		public function resolveQuotes($rootValue, $args) {
			return $this->db()->findQuotes();
		}

		/**
		 * @return string
		 */
		public function resolveHello() {
			return 'Your graphql-php endpoint is ready! Use GraphiQL to browse API';
		}

		/**
		 * @return DataSource
		 */
		private function db() {
			return new DataSource();
		}
	}
