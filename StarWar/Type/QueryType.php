<?php
	namespace StarWar\Type;

	use StarWar\AppContext;
	use StarWar\Data\DataSource;
	use StarWar\Types;
	use GraphQL\Type\Definition\ObjectType;
	use GraphQL\Type\Definition\ResolveInfo;
	use GraphQL\Type\Definition\Type;

	class QueryType extends ObjectType
	{
		public function __construct()
		{
			$config = [
				'name' => 'Query',
				'fields' => [
					'character' => [
						'type' => Types::character(),
						'description' => 'Returns character by id (in range of 1-5)',
						'args' => [
							'id' => Types::nonNull(Types::id())
						]
					],
					'viewer' => [
						'type' => Types::character(),
						'description' => 'Represents currently logged-in character (for the sake of example - simply returns character with id == 1)'
					],
					'movies' => [
						'type' => Types::listOf(Types::movie()),
						'description' => 'Returns subset of movies',
						'args' => [
							'after' => [
								'type' => Types::id(),
								'description' => 'Fetch movies listed after the movie with this ID'
							],
							'limit' => [
								'type' => Types::int(),
								'description' => 'Number of movies to be returned',
								'defaultValue' => 2
							]
						]
					],
					'lastMoviePosted' => [
						'type' => Types::movie(),
						'description' => 'Returns last movie'
					],
					'deprecatedField' => [
						'type' => Types::string(),
						'deprecationReason' => 'This field is deprecated!'
					],
					'fieldWithException' => [
						'type' => Types::string(),
						'resolve' => function() {
							throw new \Exception("Exception message thrown in field resolver");
						}
					],
					'hello' => Type::string()
				],
				'resolveField' => function($val, $args, $context, ResolveInfo $info) {
					return $this->{$info->fieldName}($val, $args, $context, $info);
				}
			];
			parent::__construct($config);
		}

		public function character($rootValue, $args)
		{
			return DataSource::findCharacter($args['id']);
		}

		public function viewer($rootValue, $args, AppContext $context)
		{
			return $context->viewer;
		}

		public function movies($rootValue, $args)
		{
			$args += ['after' => null];
			return DataSource::findMovies($args['limit'], $args['after']);
		}

		public function lastMoviePosted()
		{
			return DataSource::findLatestMovie();
		}

		public function hello()
		{
			return 'Your graphql-php endpoint is ready! Use GraphiQL to browse API';
		}

		public function deprecatedField()
		{
			return 'You can request deprecated field, but it is not displayed in auto-generated documentation by default.';
		}
	}
