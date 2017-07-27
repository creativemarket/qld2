<?php
	namespace StarWar\Type;

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
					];
				},
			];
			parent::__construct($config);
		}
	}
