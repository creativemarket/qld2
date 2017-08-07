<?php
	namespace StarWar\Type;

	use StarWar\Data\DataSource;
	use StarWar\Types;
	use GraphQL\Type\Definition\ObjectType;
	use GraphQL\Type\Definition\ResolveInfo;

	class MutationType extends ObjectType {
		/**
		 * MutationType constructor.
		 */
		public function __construct() {
			$config = [
				'name' => 'Mutation',
				'fields' => [
					'createScore' => [
						'type' => Types::score(),
						'description' => 'Create a new score',
						'args' => [
							'scoreInput' => Types::scoreInput(),
						],
					],
				],
				'resolveField' => function ($value, $args, $context, ResolveInfo $info) {
					$method = 'resolve' . ucfirst($info->fieldName);
					return $this->{$method}($value, $args, $context, $info);
				},
			];
			parent::__construct($config);
		}

		/**
		 * @param $rootValue
		 * @param $args
		 * @return null|\StarWar\Data\score
		 */
		public function resolveCreateScore($rootValue, $args) {
			$scoreInput = $args['scoreInput'];
			$scoreId = $this->db()->createScore($scoreInput['score'], $scoreInput['userName']);
			return $this->db()->findScore($scoreId);
		}

		/**
		 * @return DataSource
		 */
		private function db() {
			return new DataSource();
		}
	}
