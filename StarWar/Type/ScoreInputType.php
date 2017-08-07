<?php
	namespace StarWar\Type;

	use StarWar\Types;
	use GraphQL\Type\Definition\InputObjectType;
	use GraphQL\Type\Definition\ResolveInfo;

	class ScoreInputType extends InputObjectType {
		/**
		 * ScoreInputType constructor.
		 */
		public function __construct() {
			$config = [
				'name' => 'ScoreInput',
				'fields' => function () {
					return [
						'userName' => [
							'type' => Types::string(),
							'description' => 'User name for new Score',
						],
						'score' => [
							'type' => Types::int(),
							'description' => 'Score value for new Score',
						],
					];
				},
				'resolveField' => function ($value, $args, $context, ResolveInfo $info) {
					$method = 'resolve' . ucfirst($info->fieldName);
					if (method_exists($this, $method)) {
						return $this->{$method}($value, $args, $context, $info);
					} else {
						return $value->{$info->fieldName};
					}
				}
			];
			parent::__construct($config);
		}
	}