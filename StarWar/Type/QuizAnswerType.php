<?php
	namespace StarWar\Type;

	use StarWar\Data\QuizAnswer;
	use StarWar\Data\DataSource;
	use StarWar\Types;
	use GraphQL\Type\Definition\ObjectType;
	use GraphQL\Type\Definition\ResolveInfo;

	class QuizAnswerType extends ObjectType {

		/**
		 * @return QuizAnswerType
		 */
		public function __construct() {
			$config = [
				'name' => 'QuizAnswer',
				'fields' => function () {
					return [
						'answer' => Types::string(),
						'isCorrect' => Types::boolean(),
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
