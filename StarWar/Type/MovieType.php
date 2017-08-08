<?php
	namespace StarWar\Type;

	use StarWar\Types;
	use GraphQL\Type\Definition\ObjectType;

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
					];
				},
			];
			parent::__construct($config);
		}
	}
