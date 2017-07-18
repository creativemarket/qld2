<?php
	namespace StarWar\Type;

	use StarWar\Data\DataSource;
	use StarWar\Data\Movie;
	use StarWar\Types;
	use GraphQL\Type\Definition\ObjectType;
	use GraphQL\Type\Definition\ResolveInfo;

	/**
	 * Class MovieType
	 * @package GraphQL\Examples\Social\Type
	 */
	class MovieType extends ObjectType {
		/**
		 * MovieType constructor.
		 */
		public function __construct() {
			$config = [
				'name' => 'Movie',
				'fields' => function () {
					return [
						'id' => Types::id(),
						'title' => Types::string(),
						'totalQuoteCount' => Types::int(),
						'quotes' => [
							'type' => Types::listOf(Types::quote()),
							'args' => [
								'after' => [
									'type' => Types::id(),
									'description' => 'Load all quotes listed after given quote ID',
								],
								'limit' => [
									'type' => Types::int(),
									'defaultValue' => 5,
								],
							],
						],
					];
				},
				'resolveField' => function ($value, $args, $context, ResolveInfo $info) {
					if (method_exists($this, $info->fieldName)) {
						return $this->{$info->fieldName}($value, $args, $context, $info);
					} else {
						return $value->{$info->fieldName};
					}
				},
			];
			parent::__construct($config);
		}

		/**
		 * @param Movie $movie
		 * @return int
		 */
		public function totalQuoteCount(Movie $movie) {
			return DataSource::countQuotes($movie->id);
		}

		/**
		 * @param Movie $movie
		 * @param       $args
		 * @return array
		 */
		public function quotes(Movie $movie, $args) {
			$args += ['after' => null];
			return DataSource::findQuotes($movie->id, $args['limit'], $args['after']);
		}
	}
