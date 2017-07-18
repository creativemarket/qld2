<?php
	namespace StarWar\Type;

	use StarWar\Types;
	use GraphQL\Type\Definition\InputObjectType;
	use GraphQL\Type\Definition\ResolveInfo;

	class QuoteInputType extends InputObjectType {
		/**
		 * QuoteInputType constructor.
		 */
		public function __construct() {
			$config = [
				'name' => 'QuoteInput',
				'fields' => function () {
					return [
						'movieId' => [
							'type' => Types::int(),
							'description' => 'MovieId for new Quote',
						],
						'characterId' => [
							'type' => Types::int(),
							'description' => 'CharacterId for new Quote',
						],
						'parent' => [
							'type' => Types::int(),
							'description' => 'ParentId for new Quote',
						],
						'body' => [
							'type' => Types::string(),
							'description' => 'Body for new Quote',
						],
					];
				},
				'resolveField' => function ($value, $args, $context, ResolveInfo $info) {
					if (method_exists($this, $info->fieldName)) {
						return $this->{$info->fieldName}($value, $args, $context, $info);
					} else {
						return $value->{$info->fieldName};
					}
				}
			];
			parent::__construct($config);
		}
	}