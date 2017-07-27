<?php
	namespace StarWar\Data;

	use GraphQL\Utils;

	class Quote {
		/** @var integer */
		public $id;

		/** @var integer */
		public $characterId;

		/** @var integer */
		public $movieId;

		/** @var string */
		public $text;

		/**
		 * Quote constructor.
		 * @param array $data
		 */
		public function __construct(array $data) {
			Utils::assign($this, $data);
		}
	}
