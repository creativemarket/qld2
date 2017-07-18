<?php
	namespace StarWar\Data;

	use GraphQL\Utils;

	class Quote {
		/** @var string */
		public $id;

		/** @var string */
		public $characterId;

		/** @var string */
		public $movieId;

		/** @var string */
		public $parentId;

		/** @var string */
		public $body;

		/**
		 * @param array $data
		 */
		public function __construct(array $data) {
			Utils::assign($this, $data);
		}
	}
