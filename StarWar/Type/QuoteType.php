<?php
	namespace StarWar\Type;

	use StarWar\Data\Quote;
	use StarWar\Data\DataSource;
	use StarWar\Types;
	use GraphQL\Type\Definition\ObjectType;
	use GraphQL\Type\Definition\ResolveInfo;

	class QuoteType extends ObjectType {
		public function __construct() {
			$config = [
				'name' => 'Quote',
				'fields' => function() {
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
									'defaultValue' => 5
								]
							]
						],
						'totalReplyCount' => Types::int(),
						'body' => Types::string()
					];
				},
				'resolveField' => function($value, $args, $context, ResolveInfo $info) {
					if (method_exists($this, $info->fieldName)) {
						return $this->{$info->fieldName}($value, $args, $context, $info);
					} else {
						return $value->{$info->fieldName};
					}
				}
			];
			parent::__construct($config);
		}

		public function character(Quote $quote) {
			return DataSource::findCharacter($quote->characterId);
		}

		public function parent(Quote $quote) {
			if ($quote->parentId) {
				return DataSource::findQuote($quote->parentId);
			}
			return null;
		}

		public function replies(Quote $quote, $args) {
			$args += ['after' => null];
			return DataSource::findReplies($quote->id, $args['limit'], $args['after']);
		}

		public function totalReplyCount(Quote $quote) {
			return DataSource::countReplies($quote->id);
		}
	}
