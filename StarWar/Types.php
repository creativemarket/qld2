<?php
	namespace StarWar;

	use StarWar\Type\CharacterType;
	use StarWar\Type\MovieType;
	use StarWar\Type\QuoteType;
	use StarWar\Type\QueryType;
	use GraphQL\Type\Definition\ListOfType;
	use GraphQL\Type\Definition\NonNull;
	use GraphQL\Type\Definition\Type;

	/**
	 * Class Types
	 *
	 * Acts as a registry and factory for your types.
	 *
	 * As simplistic as possible for the sake of clarity of this example.
	 * Your own may be more dynamic (or even code-generated).
	 *
	 * @package GraphQL\Examples\Blog
	 */
	class Types {
		// Object types:
		private static $character;
		private static $movie;
		private static $quote;
		private static $query;

		/**
		 * @return CharacterType()
		 */
		public static function character() {
			return self::$character ?: (self::$character = new CharacterType());
		}

		/**
		 * @return MovieType()
		 */
		public static function movie() {
			return self::$movie ?: (self::$movie = new MovieType());
		}

		/**
		 * @return QuoteType
		 */
		public static function quote() {
			return self::$quote ?: (self::$quote = new QuoteType());
		}

		/**
		 * @return QueryType
		 */
		public static function query() {
			return self::$query ?: (self::$query = new QueryType());
		}

		// Let's add internal types as well for consistent experience

		public static function boolean() {
			return Type::boolean();
		}

		/**
		 * @return \GraphQL\Type\Definition\FloatType
		 */
		public static function float() {
			return Type::float();
		}

		/**
		 * @return \GraphQL\Type\Definition\IDType
		 */
		public static function id() {
			return Type::id();
		}

		/**
		 * @return \GraphQL\Type\Definition\IntType
		 */
		public static function int() {
			return Type::int();
		}

		/**
		 * @return \GraphQL\Type\Definition\StringType
		 */
		public static function string() {
			return Type::string();
		}

		/**
		 * @param Type $type
		 * @return ListOfType
		 */
		public static function listOf($type) {
			return new ListOfType($type);
		}

		/**
		 * @param Type $type
		 * @return NonNull
		 */
		public static function nonNull($type) {
			return new NonNull($type);
		}
	}
