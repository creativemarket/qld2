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
						'email' => Types::string(),
						'firstName' => [
							'type' => Types::string(),
						],
						'lastName' => [
							'type' => Types::string(),
						],
						'fieldWithError' => [
							'type' => Types::string(),
							'resolve' => function () {
								throw new \Exception("This is error field");
							},
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
