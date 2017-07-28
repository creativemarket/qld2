<?php
	namespace StarWar\Type;

	use StarWar\Data\Score;
	use StarWar\Data\DataSource;
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
						'user' => Types::user(),
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

		/**
		 * @param Score $score
		 * @return object
		 */
		public function resolveUser(Score $score) {
			return $this->db()->findUser($score->userId);
		}

		/**
		 * @return DataSource
		 */
		private function db() {
			return new DataSource();
		}
	}
