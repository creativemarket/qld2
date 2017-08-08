<?php
	namespace StarWar\Type;

	use StarWar\Data\DataSource;
	use StarWar\Types;
	use GraphQL\Type\Definition\ObjectType;
	use GraphQL\Type\Definition\ResolveInfo;

	class QueryType extends ObjectType {
		/**
		 * QueryType constructor.
		 */
		public function __construct() {
			$config = [
				'name' => 'Query',
				'fields' => [
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
					'quiz' => [
						'type' => Types::listOf(Types::quizQuestion()),
						'description' => 'Returns quiz questions and answers',
						'args' => [
							'limit' => [
								'type' => Types::int(),
								'defaultValue' => 10,
							],
						],
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
						'description' => 'Returns all quotes',
					],
					'topScores' => [
						'type' => Types::listof(Types::score()),
						'description' => 'Returns top scores (default 5)',
						'args' => [
							'limit' => [
								'type' => Types::int(),
								'defaultValue' => 5,
							],
						],
					],
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
		 * @return array
		 */
		public function resolveCharacters() {
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
		 * @return array
		 */
		public function resolveMovies() {
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
		 * @return array
		 */
		public function resolveQuotes() {
			return $this->db()->findQuotes();
		}

		/**
		 * @param $rootValue
		 * @param $args
		 * @return array
		 */
		public function resolveQuiz($rootValue, $args) {
			return $this->db()->findQuizQuestions($args['limit']);
		}

		/**
		 * @param $rootValue
		 * @param $args
		 * @return array
		 */
		public function resolveTopScores($rootValue, $args) {
			return $this->db()->findTopScores($args['limit']);
		}

		/**
		 * @return DataSource
		 */
		private function db() {
			return new DataSource();
		}
	}
