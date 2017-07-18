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
						'parent' => Types::quote(),
						'replies' => [
							'type' => Types::listOf(Types::quote()),
							'args' => [
								'after' => Types::int(),
								'limit' => [
									'type' => Types::int(),
									'defaultValue' => 5,
								],
							],
						],
						'totalReplyCount' => Types::int(),
						'body' => Types::string(),
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

		/**
		 * @param Quote $quote
		 * @return CharacterType
		 */
		public function character(Quote $quote) {
			return DataSource::findCharacter($quote->characterId);
		}

		/**
		 * @param Quote $quote
		 * @return QuoteType
		 */
		public function parent(Quote $quote) {
			if ($quote->parentId) {
				return DataSource::findQuote($quote->parentId);
			}
			return null;
		}

		/**
		 * @param Quote $quote
		 * @param $args array
		 * @return array
		 */
		public function replies(Quote $quote, $args) {
			$args += ['after' => null];
			return DataSource::findReplies($quote->id, $args['limit'], $args['after']);
		}

		/**
		 * @param Quote $quote
		 * @return int
		 */
		public function totalReplyCount(Quote $quote) {
			return DataSource::countReplies($quote->id);
		}
	}
