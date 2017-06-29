<?php
	namespace StarWar\Data;

	/**
	 * Class DataSource
	 *
	 * This is just a simple in-memory data holder for the sake of example.
	 * Data layer for real app may use Doctrine or query the database directly (e.g. in CQRS style)
	 *
	 */
	class DataSource {
		private static $characters = [];
		private static $movies = [];
		private static $quotes = [];
		private static $movieQuotes = [];
		private static $quoteReplies = [];

		public static function init() {
			self::$characters = [
				'1' => new Character(['id' => '1', 'email' => 'rey@starwar.com', 'firstName' => 'Rey', 'lastName' => '']),
				'2' => new Character(['id' => '2', 'email' => 'leia@starwar.com', 'firstName' => 'Leia', 'lastName' => 'Organa']),
				'3' => new Character(['id' => '3', 'email' => 'maz@starwar.com', 'firstName' => 'Maz', 'lastName' => 'Kanata']),
			];

			self::$movies = [
				'1' => new Movie(['id' => '1', 'title' => 'A New Hope']),
				'2' => new Movie(['id' => '2', 'title' => 'The Force Awakens']),
			];

			self::$quotes = [
				'100' => new Quote(['id' => '100', 'characterId' => '1', 'movieId' => '2', 'body' => 'The garbage will do']),
				'110' => new Quote(['id' => '110', 'characterId' => '2', 'movieId' => '2', 'body' => 'The saber. Take it.']),
				'111' => new Quote(['id' => '111', 'characterId' => '1', 'movieId' => '2', 'body' => 'I\'m never touching that thing again', 'parentId' => '110']),
				'112' => new Quote(['id' => '112', 'characterId' => '3', 'movieId' => '2', 'body' => 'I like that Wookie']),
				'113' => new Quote(['id' => '113', 'characterId' => '2', 'movieId' => '1', 'body' => 'Into the garbage chute, fly boy.']),
				'114' => new Quote(['id' => '114', 'characterId' => '2', 'movieId' => '1', 'body' => 'It\'s a wonder you\'re still alive.']),
				'115' => new Quote(['id' => '115', 'characterId' => '2', 'movieId' => '1', 'body' => 'Will someone get this big walking carpet out of my way?', 'parentId' => '114']),
			];

			self::$movieQuotes = [
				'1' => ['100', '110', '112'],
				'2' => ['113', '114']
			];

			self::$quoteReplies = [
				'110' => ['111'],
				'114' => ['115'],
			];
		}

		public static function findCharacter($id) {
			return isset(self::$characters[$id]) ? self::$characters[$id] : null;
		}

		public static function findMovie($id) {
			return isset(self::$movies[$id]) ? self::$movies[$id] : null;
		}

		public static function findQuote($id) {
			return isset(self::$quotes[$id]) ? self::$quotes[$id] : null;
		}

		public static function findLatestMovie() {
			return array_pop(self::$movies);
		}

		public static function findMovies($limit, $afterId = null) {
			$start = $afterId ? (int) array_search($afterId, array_keys(self::$movies)) + 1 : 0;
			return array_slice(array_values(self::$movies), $start, $limit);
		}

		public static function findQuotes($movieId, $limit = 5, $afterId = null) {
			$movieQuotes = isset(self::$movieQuotes[$movieId]) ? self::$movieQuotes[$movieId] : [];

			$start = isset($after) ? (int) array_search($afterId, $movieQuotes) + 1 : 0;
			$movieQuotes = array_slice($movieQuotes, $start, $limit);

			return array_map(
				function($quoteId) {
					return self::$quotes[$quoteId];
				},
				$movieQuotes
			);
		}

		public static function findReplies($quoteId, $limit = 5, $afterId = null) {
			$quoteReplies = isset(self::$quoteReplies[$quoteId]) ? self::$quoteReplies[$quoteId] : [];

			$start = isset($after) ? (int) array_search($afterId, $quoteReplies) + 1: 0;
			$quoteReplies = array_slice($quoteReplies, $start, $limit);

			return array_map(
				function($replyId) {
					return self::$quotes[$replyId];
				},
				$quoteReplies
			);
		}

		public static function countQuotes($movieId) {
			return isset(self::$movieQuotes[$movieId]) ? count(self::$movieQuotes[$movieId]) : 0;
		}

		public static function countReplies($quoteId) {
			return isset(self::$quoteReplies[$quoteId]) ? count(self::$quoteReplies[$quoteId]) : 0;
		}

	}
