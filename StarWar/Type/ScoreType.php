<?php
	namespace StarWar\Type;

	use StarWar\Types;
	use GraphQL\Type\Definition\ObjectType;
	use GraphQL\Type\Definition\ResolveInfo;

	class ScoreType extends ObjectType {
		/**
		 * ScoreType constructor.
		 */
		public function __construct() {
			$config = [
				'name' => 'Score',
				'description' => 'Our players\' efforts',
				'fields' => function () {
					return [
						'userName' => Types::string(),
						'score' => Types::int(),
					];
				},
				'resolveField' => function ($value, $args, $context, ResolveInfo $info) {
					$method = 'resolve' . ucfirst($info->fieldName);
					if (method_exists($this, $method)) {
						return $this->{$method}($value, $args, $context, $info);
					} else {
						return $value->{$info->fieldName};
					}
				},
			];
			parent::__construct($config);
		}
	}
