<?php

	namespace StarWar\Data\Buffer;

	use \StarWar\Data\DataSource;

	class Character {

		/** @var array  */
		public static $ids = [];
		/** @var array */
		public static $characters = [];
		/** @var bool */
		public static $loaded = false;

		/**
		 * @param int $quoteId
		 * @param array $characterIds
		 */
		public static function add($quoteId, $characterIds) {
			self::$ids += [$quoteId => $characterIds];
		}

		public static function idsForQuote($id) {
			return self::$ids[$id];
		}

		/**
		 * return void
		 */
		public static function loadBuffered() {
			if (self::$loaded) { return; }

			$characterIds = [];
			foreach (self::$ids as $characterIdsForQuote) {
				foreach(array_values($characterIdsForQuote) as $charId) {
					array_push($characterIds, $charId);
				}
			}
			$characterIds = join(',', array_unique($characterIds));

			$results = self::db()->query("SELECT * FROM characters WHERE id IN ($characterIds)");

			while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
				self::$characters[$row['id']] = $row;
			}
			self::$loaded = true;
		}

		/**
		 * @param array $ids
		 * @return array
		 */
		public static function get($ids) {
			return array_map(function($id) {
				return self::$characters[$id];
			}, $ids);
		}

		private static function db() {
			return new DataSource();
		}
	}
