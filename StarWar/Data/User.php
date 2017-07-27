<?php
	namespace StarWar\Data;

	use GraphQL\Utils;

	class User {
		/** @var integer */
		public $id;

		/** @var string */
		public $name;

		/**
		 * User constructor.
		 * @param array $data
		 */
		public function __construct(array $data) {
			Utils::assign($this, $data);
		}
	}
