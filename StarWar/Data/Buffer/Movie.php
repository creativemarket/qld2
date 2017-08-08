<?php

	namespace StarWar\Data\Buffer;

	use \StarWar\Data\DataSource;

	class Movie {

		/** @var array  */
		public static $ids = [];
		/** @var array */
		public static $movies = [];
		/** @var bool */
		public static $loaded = false;

		/**
		 * @param int $quoteId
		 * @param array $movieIds
		 * @return void
		 */
		public static function add($quoteId, $movieIds) {
			self::$ids += [$quoteId => $movieIds];
		}

		/**
		 * @param $id
		 * @return array
		 */
		public static function idsForQuote($id) {
			return self::$ids[$id];
		}

		/**
		 * @return void
		 */
		public static function loadBuffered() {
			if (self::$loaded) {
				return;
			}

			$movieIds = [];
			foreach (self::$ids as $movieIdsForQuote) {
				foreach (array_values($movieIdsForQuote) as $charId) {
					array_push($movieIds, $charId);
				}
			}
			$movieIds = join(',', array_unique($movieIds));

			$results = self::db()->query("SELECT * FROM movies WHERE id IN ($movieIds)");

			while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
				self::$movies[$row['id']] = $row;
			}
			self::$loaded = true;
		}

		/**
		 * @param array $ids
		 * @return array
		 */
		public static function get($ids) {
			return array_map(function ($id) {
				return self::$movies[$id];
			}, $ids);
		}

		/**
		 * @return DataSource
		 */
		private static function db() {
			return new DataSource();
		}
	}
