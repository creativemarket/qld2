<?php
	namespace StarWar\Type;

	use StarWar\Data\DataSource;
	use StarWar\Types;
	use GraphQL\Type\Definition\ObjectType;
	use GraphQL\Type\Definition\ResolveInfo;

	class MutationType extends ObjectType
	{
		public function __construct()
		{
			$config = [
				'name' => 'Mutation',
				'fields' => [
					'createQuote' => [
						'type' => Types::quote(),
						'description' => 'Returns newly created quote',
						'args' => [
							'characterId' => Types::id(),
							'movieId' => Types::id(),
							'body' => Types::string()
						]
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
				],
				'resolveField' => function($val, $args, $context, ResolveInfo $info) {
					return $this->{$info->fieldName}($val, $args, $context, $info);
				}
			];
			parent::__construct($config);
		}

		public function createQuote($rootValue, $args)
		{
			DataSource::addQuote($args);
			return DataSource::lastQuote();
		}

		public function deprecatedField()
		{
			return 'You can request deprecated field, but it is not displayed in auto-generated documentation by default.';
		}
	}
