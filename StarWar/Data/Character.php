<?php
	namespace StarWar\Data;

	use GraphQL\Utils;

	class Character {
		/** @var string */
		public $id;

		/** @var string */
		public $email;

		/** @var string */
		public $firstName;

		/** @var string */
		public $lastName;

		/**
		 * Character constructor.
		 * @param array $data
		 */
		public function __construct(array $data) {
			Utils::assign($this, $data);
		}
	}
