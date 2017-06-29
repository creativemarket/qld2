<?php
	namespace StarWar\Data;

	use GraphQL\Utils;

	class Character {
		public $id;

		public $email;

		public $firstName;

		public $lastName;

		public function __construct(array $data) {
			Utils::assign($this, $data);
		}
	}
