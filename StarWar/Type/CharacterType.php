<?php
	namespace StarWar\Type;

	use StarWar\Types;
	use GraphQL\Type\Definition\ObjectType;
	use GraphQL\Type\Definition\ResolveInfo;

	class CharacterType extends ObjectType {
		/**
		 * CharacterType constructor.
		 */
		public function __construct() {
			$config = [
				'name' => 'Character',
				'description' => 'Our heroines',
				'fields' => function () {
					return [
						'id' => Types::id(),
						'name' => Types::string(),
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
