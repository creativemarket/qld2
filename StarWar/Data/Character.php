<?php
	namespace StarWar\Data;

	use GraphQL\Utils;

	class Character {
		/** @var integer */
		public $id;

		/** @var string */
		public $name;

		/**
		 * Character constructor.
		 * @param array $data
		 */
		public function __construct(array $data) {
			Utils::assign($this, $data);
		}
	}
