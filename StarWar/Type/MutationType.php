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
					'createUser' => [
						'type' => Types::user(),
						'description' => 'Create a new user',
						'args' => [
							'userName' => Types::string(),
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
			$scoreId = $this->db()->createScore($scoreInput['score'], $scoreInput['userId']);
			return $this->db()->findScore($scoreId);
		}

		public function resolveCreateUser($rootValue, $args) {
			$userId = $this->db()->createUser($args['userName']);
			return $this->db()->findUser($userId);
		}

		/**
		 * @return DataSource
		 */
		private function db() {
			return new DataSource();
		}
	}
