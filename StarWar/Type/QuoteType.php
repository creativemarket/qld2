<?php
	namespace StarWar\Type;

	use StarWar\Data\Quote;
	use StarWar\Data\DataSource;
	use StarWar\Types;
	use GraphQL\Type\Definition\ObjectType;
	use GraphQL\Type\Definition\ResolveInfo;

	class QuoteType extends ObjectType {

		/**
		 * @return QuoteType
		 */
		public function __construct() {
			$config = [
				'name' => 'Quote',
				'fields' => function () {
					return [
						'id' => Types::id(),
						'character' => Types::character(),
						'movie' => Types::movie(),
						'text' => Types::string(),
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
		 * @param Quote $quote
		 * @return object
		 */
		public function resolveCharacter(Quote $quote) {
			return $this->db()->findCharacter($quote->characterId);
		}

		/**
		 * @param Quote $quote
		 * @return object
		 */
		public function resolveMovie(Quote $quote) {
			if ($quote->movieId) {
				return $this->db()->findMovie($quote->movieId);
			}
			return null;
		}

		/**
		 * @return DataSource
		 */
		private function db() {
			return new DataSource();
		}
	}
